<?php 
	namespace App\Controllers\Pagos;

	use App\Controllers\BaseController;
	use App\Models\Consumo\Md_metros;
	use App\Models\Consumo\Md_metros_traza;
	use App\Models\Formularios\Md_socios;
	use App\Models\Formularios\Md_arranques;
	use App\Models\Formularios\Md_medidores;
	use App\Models\Configuracion\Md_comunas;
	use App\Models\Configuracion\Md_apr;
	use \Mpdf\Mpdf;

	class Ctrl_boleta_electronica extends BaseController {
		protected $metros;
		protected $metros_traza;
		protected $socios;
		protected $comunas;
		protected $apr;
		protected $arranques;
		protected $medidores;
		protected $sesión;
		protected $db;
		protected $error = "";

		public function __construct() {
			$this->metros = new Md_metros();
			$this->metros_traza = new Md_metros_traza();
			$this->socios = new Md_socios();
			$this->comunas = new Md_comunas();
			$this->apr = new Md_apr();
			$this->arranques = new Md_arranques();
			$this->medidores = new Md_medidores();
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
			$this->validar_sesion();
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
			$this->validar_sesion();
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

		public function imprimir_aviso_cobranza($arr_boletas) {
			$this->validar_sesion();
			$mpdf = new \Mpdf\Mpdf([
			    'mode' => 'utf-8',
			    'format' => 'letter',
			    'margin_bottom' => 1
			]);

			$datosApr = $this->apr->select("nombre")
									->select("concat(rut, '-', dv) as rut")
									->select("ifnull(calle, 'Sin Registro') as calle")
									->select("case when numero = 0 then 'Sin Registro' else numero end as numero")
									->select("ifnull(resto_direccion, 'Sin Registro') as resto_direccion")
									->where("id", $this->sesión->id_apr_ses)->first();

			$nombre_apr = $datosApr["nombre"];
			$rut_apr = $datosApr["rut"];
			$direccion_apr = $datosApr["calle"] . ", " . $datosApr["numero"] . ", " . $datosApr["resto_direccion"];

			$folios = explode(",", $arr_boletas);
			
			foreach ($folios as $folio) {
				$datosMetros = $this->metros->select("id_socio")
											->select("consumo_anterior")
											->select("consumo_actual")
											->select("metros")
											->select("monto_facturable")
											->select("total_mes")
											->select("date_format(fecha, '%d-%m-%Y') as fecha_emision")
											->select("date_format(fecha_vencimiento, '%d-%m-%Y') as fecha_vencimiento")
											->where("id", $folio)->first();

				$id_socio = $datosMetros["id_socio"];
				$consumo_anterior = $datosMetros["consumo_anterior"];
				$consumo_actual = $datosMetros["consumo_actual"];
				$consumo_metros = $datosMetros["metros"];
				$monto_facturable = $datosMetros["monto_facturable"];
				$total_mes = $datosMetros["total_mes"];
				$fecha_emision = $datosMetros["fecha_emision"];
				$fecha_vencimiento = $datosMetros["fecha_vencimiento"];

				$datosSocio = $this->socios->select("concat(nombres, ' ', ape_pat, ' ', ape_mat) as nombre_socio")
											->select("concat(calle, ', ', numero, ', ', resto_direccion) as direccion_socio")
											->select("rol as codigo_socio")
											->where("id", $id_socio)->first();

				$nombre_socio = $datosSocio["nombre_socio"];
				$direccion_socio = $datosSocio["direccion_socio"];
				$codigo_socio = $datosSocio["codigo_socio"];

				$datosArranque = $this->arranques->select("id_medidor")->where("id_socio", $id_socio)->first();
				$datosMedidor = $this->medidores->select("numero")->where("id", $datosArranque["id_medidor"])->first();

				$numero_medidor = $datosMedidor["numero"];

				$pagecount = $mpdf->SetSourceFile("002.pdf");
				$tplId = $mpdf->ImportPage($pagecount);
		        $mpdf->AddPage();
				$mpdf->UseTemplate($tplId);
				$mpdf->WriteHTML('
					<div style="height: 11%;"></div>
					<div>
			        	<div style="font-size: 90%; width: 60%; float: left;">
			        		<br><br><br>
			        		<b>' . $nombre_apr .  '</b><br>
							RUT: ' . $rut_apr . '<br>
							CAPTACIÓN, PURIFICACIÓN Y DIST. DE AGUA<br>
							' . $direccion_apr . '<br>
							FONOS: 722 392 155 - 722 392 131
			        	</div>
			        	
			        	<div style="width: 40%; float: left;">
			        		<div style="font-size: 140%;">
			        			<b>N° ' . $folio . '<br></b><br>
			        		</div>
			        		<div style="font-size: 90%;">
				        		BOLETA DE VENTAS Y SERVICIOS<br>
								NO AFECTAS O EXENTAS DE IVA<br>
								OFICIO N° 2.413 DEL 30 - 08 - 96 DEL S.I.I.<br>
								RESOLUCIÓN N° 78 03-04-1998
							</div>
			        	</div>
			        </div>
			        <br><br>
					<div>
			        	<div style="width: 60%; float: left; margin-left: 3%;">
			        		' . $nombre_socio . '<br>
							' . $direccion_socio . '<br>
							' . $codigo_socio . '<br>
							' . $numero_medidor . '
			        	</div>
			        </div>
			        <br><br><br><br><br>
					<div>
			        	<div style="width: 25%; float: left; margin-left: 3%;">
			        		' . $consumo_anterior . ' M<sup>3</sup><br>
			        	</div>
			        	<div style="width: 32%; float: left;">
			        		' . $consumo_actual . ' M<sup>3</sup><br>
			        	</div>
			        	<div style="width: 40%; float: left;">
			        		' . $consumo_metros . ' M<sup>3</sup><br>
			        	</div>
			        </div>
			        <div style="height: 6.7%;"></div>
					<div>
			        	<div style="width: 100%; float: left; margin-left: 60%;">
			        		$ ' . number_format($total_mes, 0, ",", ".") . '
			        	</div>
			        </div>
			        <div style="height: 8%;"></div>
					<div>
			        	<div style="width: 35%; float: left; margin-left: 10%;">
			        		' . $fecha_emision . '
			        	</div>
			        	<div style="width: 35%; float: left;">
			        		' . $fecha_vencimiento . '
			        	</div>
			        	<div style="width: 15%; float: left;">
			        		$ ' . number_format($total_mes, 0, ",", ".") . '
			        	</div>
			        </div>
			        <div style="height: 13%;"></div>
					<div>
			        	<div style="font-size: 70%; width: 40%; float: left;">
			        		<b>' . $nombre_apr .  '</b><br>
							RUT: ' . $rut_apr . '<br>
							CAPTACIÓN, PURIFICACIÓN Y DIST. DE AGUA<br>
							' . $direccion_apr . '<br>
							FONOS: 722 392 155 - 722 392 131
			        	</div>
			        	
			        	<div style="width: 40%; float: left;">
			        		<div style="font-size: 10 	0%;">
			        			<b>N° ' . $folio . '<br>
			        		</div>
			        		<div style="font-size: 70%;">
				        		BOLETA DE VENTAS Y SERVICIOS<br>
								NO AFECTAS O EXENTAS DE IVA<br>
								OFICIO N° 2.413 DEL 30 - 08 - 96 DEL S.I.I.<br>
								RESOLUCIÓN N° 78 03-04-1998
							</div>
			        	</div>
			        	<div style="width: 20%; float: left;">
			        		<br><br>
			        		' . $fecha_emision . '
			        	</div>
			        	<br>
			        	<div style="width: 77%; float: left; margin-left: 3%; font-size: 70%;">
			        		' . $nombre_socio . '<br>
							' . $direccion_socio . '<br>
							' . $codigo_socio . '<br>
							' . $numero_medidor . '
			        	</div>
			        	<div style="width: 20%; float: left;">
			        		<br><br>
			        		' . $fecha_vencimiento . '
			        	</div>
			        </div>
				');
			}
			
			$verificar_dispositivo = $this->verificar_dispositivo();

			if ($verificar_dispositivo == "mobil" or $verificar_dispositivo == "tablet") {
				return $mpdf->Output("Aviso de Cobranza.pdf", "D");
			} else {
				return redirect()->to($mpdf->Output("Aviso de Cobranza.pdf", "I"));
			}
		}

		public function verificar_dispositivo() {
			$tablet_browser = 0;
			$mobile_browser = 0;
			$body_class = 'desktop';
			 
			if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			    $tablet_browser++;
			    $body_class = "tablet";
			}
			 
			if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			    $mobile_browser++;
			    $body_class = "mobile";
			}
			 
			if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
			    $mobile_browser++;
			    $body_class = "mobile";
			}
			 
			$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
			$mobile_agents = array(
			    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
			    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
			    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
			    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
			    'newt','noki','palm','pana','pant','phil','play','port','prox',
			    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
			    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
			    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
			    'wapr','webc','winw','winw','xda ','xda-');
			 
			if (in_array($mobile_ua,$mobile_agents)) {
			    $mobile_browser++;
			}
			 
			if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
			    $mobile_browser++;
			    //Check for tablets on opera mini alternative headers
			    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
			    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
			      $tablet_browser++;
			    }
			}
			if ($tablet_browser > 0) {
			// Si es tablet has lo que necesites
			   return 'tablet';
			}
			else if ($mobile_browser > 0) {
			// Si es dispositivo mobil has lo que necesites
			   return 'mobil';
			}
			else {
			// Si es ordenador de escritorio has lo que necesites
			   return 'ordenador';
			}  
		}
	}
?>