<?php 
	namespace App\Controllers\Pagos;

	use App\Controllers\BaseController;
	use App\Models\Consumo\Md_metros;
	use App\Models\Consumo\Md_metros_traza;
	use App\Models\Formularios\Md_socios;
	use App\Models\Configuracion\Md_comunas;
	use \Mpdf\Mpdf;

	class Ctrl_boleta_electronica extends BaseController {
		protected $metros;
		protected $metros_traza;
		protected $socios;
		protected $comunas;
		protected $sesión;
		protected $db;
		protected $error = "";

		public function __construct() {
			$this->metros = new Md_metros();
			$this->metros_traza = new Md_metros_traza();
			$this->socios = new Md_socios();
			$this->comunas = new Md_comunas();
			$this->sesión = session();
			$this->db = \Config\Database::connect();
		}

		public function validar_sesion() {
			if (!$this->sesión->has("id_usuario_ses")) {
				echo "La sesión expiró, actualice el sitio web con F5";
				exit();
	    	}
		}

		public function datatable_boleta_electronica($datosBusqueda) {
			$this->validar_sesion();
			echo $this->metros->datatable_boleta_electronica($this->db, $this->sesión->id_apr_ses, $datosBusqueda);
		}

		public function emitir_dte() {
			define("BOLETA_EXENTA", 41);
	        define("ASIGNA_FOLIO_BOLECT", 7);

			$url = 'https://libredte.cl';
			$hash = $this->sesión->hash_apr_ses;
			$rut_apr = $this->sesión->rut_apr_ses . "-" . $this->sesión->dv_apr_ses;

			$folios = $this->request->getPost("arr_boletas");

			foreach ($folios as $folio) {
				$datosMetros = $this->metros->select("id_socio")->select("total_mes")->select("consumo_anterior")->select("consumo_actual")->select("metros")->where("id", $folio)->first();

				$consumo_anterior = $datosMetros["consumo_anterior"];
				$consumo_actual = $datosMetros["consumo_actual"];
				$metros_ = $datosMetros["metros"];
				$total_mes = $datosMetros["total_mes"];
				$id_socio =  $datosMetros["id_socio"];

				if (intval($total_mes) > 0) {
					$datosSocios = $this->socios->select("concat(rut, '-', dv) as rut_socio")->select("concat(nombres, ' ', ape_pat, ' ', ape_mat) as nombre_socio")->select("concat(calle, ', ', numero, ', ', resto_direccion) as direccion")->select("id_comuna")->where("id", $id_socio)->first();

					if ($datosSocios["rut_socio"] != "") {
						$rut_socio = $datosSocios["rut_socio"];
					} else {
						$rut_socio = "66666666-6";
					}

					if ($datosSocios["nombre_socio"] != "") {
						$nombre_socio = $datosSocios["nombre_socio"];
					} else {
						$nombre_socio = "Sin RUT";
					}

					if ($datosSocios["direccion"] != ", , ") {
						$direccion = $datosSocios["direccion"];
					} else {
						$direccion = "Sin Dirección";
					}

					if ($datosSocios["id_comuna"] != "") {
						$datosComuna = $this->comunas->select("nombre")->where("id", $datosSocios["id_comuna"])->first();
						$comuna = $datosComuna["nombre"];
					} else {
						$comuna = "Sin Comuna";
					}
					
					$datosParaGrafico = $this->metros->select("date_format(fecha_ingreso, '%m-%Y') as fecha")->select("consumo_actual")->where("id_socio", $id_socio)->whereNotIn("estado", [0])->findAll();

					$datos_graf = [];

					foreach ($datosParaGrafico as $key) {
						$datos_graf[$key["fecha"]] = $key["consumo_actual"];
					}

					$dte = [
		                'Encabezado' => [
		                    'IdDoc' => [
		                        'TipoDTE' => BOLETA_EXENTA,
		                    ],
		                    'Emisor' => [
		                        'RUTEmisor' => $rut_apr,
		                    ],
		                    'Receptor' => [
		                        'RUTRecep' => $rut_socio,
		                        'RznSocRecep' => $nombre_socio,
		                        'GiroRecep' => 'Particular',
		                        'DirRecep' => $direccion,
		                        'CmnaRecep' => $comuna
		                    ],
		                ],
		                'Detalle' => [
		                    [
		                        'IndExe' => 1,
		                        'NmbItem' => 'Consumo de Agua Potable',
		                        'QtyItem' => 1,
		                        'PrcItem' => $total_mes
		                    ],
		                ],
		                'LibreDTE' => [
		                    'extra' => [
		                        'dte' => [
		                            'Encabezado' => [
		                                'IdDoc' => [
		                                    "TermPagoGlosa" => "Lectura mes anterior: $consumo_anterior m³. Lectura mes actual: $consumo_actual m³. Consumo del mes: $metros_ m³."
		                                ]
		                            ]
		                        ],
		                        'historial' => [
		                            'titulo' => 'Consumo de Agua Potable',
		                            'datos' => $datos_graf
		                        ]
		                    ]
		                ]
		            ];

		            $LibreDTE = new \sasco\LibreDTE\SDK\LibreDTE($hash, $url);

		            // crear DTE temporal
		            $emitir = $LibreDTE->post('/dte/documentos/emitir', $dte);
		            if ($emitir['status']['code']!=200) {
		                die('Error al emitir DTE temporal: '.$emitir['body']."\n");
		            }

		            // crear DTE real
		            $generar = $LibreDTE->post('/dte/documentos/generar', $emitir['body']);
		            if ($generar['status']['code']!=200) {
		                die('Error al generar DTE real: '.$generar['body']."\n");
		            } else {
		                $datosMetrosSave = [
		                	"folio_bolect" => $generar['body']['folio'],
		                	"id" => $folio
		                ];

		                if ($this->metros->save($datosMetrosSave)) {
		                	
		                	$fecha = date("Y-m-d H:i:s");
							$id_usuario = $this->sesión->id_usuario_ses;
							$estado = ASIGNA_FOLIO_BOLECT;

							$datosTraza = [
								"id_metros" => $folio,
								"estado" => $estado,
								"id_usuario" => $id_usuario,
								"fecha" => $fecha
							];

							if (!$this->metros_traza->save($datosTraza)) {
								$this->error .= "Id Metros: $folio, <br>";
			                	$this->error .= "Error: Falló al ingresar traza. <br><br>";
							}
		                } else {
		                	$this->error .= "Id Metros: $folio, <br>";
		                	$this->error .= "Error: Falló al actualizar el folio SII. <br><br>";
		                }
		            }
				}

	            // // guardar PDF en el disco
	            // file_put_contents("../../../../pdf/boletas_sii/" . $generar['body']['folio'] . ".pdf", $generar_pdf['body']);
			}

			if ($this->error == "") {
            	echo 1;
            } else {
            	echo $this->error;
            }
		}

		public function imprimir_dte($arr_boletas) {
			$mpdf = new \Mpdf\Mpdf();

			define("BOLETA_EXENTA", 41);

			$url = 'https://libredte.cl';
			$hash = $this->sesión->hash_apr_ses;
			$rut_apr = $this->sesión->rut_apr_ses;
			$LibreDTE = new \sasco\LibreDTE\SDK\LibreDTE($hash, $url);

			$folios = explode(",", $arr_boletas);

			foreach ($folios as $folio) {
				$datosMetros = $this->metros->select("folio_bolect")->where("id", $folio)->first();
				$folio_sii = $datosMetros["folio_bolect"];

				// obtener el PDF del DTE
	            $pdf = $LibreDTE->get('/dte/dte_emitidos/pdf/' . BOLETA_EXENTA . '/' . $folio_sii . '/' . $rut_apr);
	            if ($pdf['status']['code']!=200) {
	                die('Error al generar PDF del DTE: '.$pdf['body']."\n");
	            }

	            file_put_contents($folio_sii . ".pdf", $pdf['body']);

				$pagecount = $mpdf->SetSourceFile($folio_sii . ".pdf");
				$tplId = $mpdf->ImportPage($pagecount);
	            $mpdf->AddPage();
				$mpdf->UseTemplate($tplId);

				unlink($folio_sii . ".pdf");
			}

			return redirect()->to($mpdf->Output());
		}
	}
?>