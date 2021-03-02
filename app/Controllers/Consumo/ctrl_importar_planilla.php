<?php 
	namespace App\Controllers\Consumo;
	use App\Controllers\BaseController;
	use CodeIgniter\HTTP\IncomingRequest;
	use CodeIgniter\Database\Query;
	use App\Models\Formularios\md_socios;
	use App\Models\Consumo\md_metros;
	use App\Models\Formularios\md_convenio_detalle;
	use App\Models\Configuracion\md_costo_metros;
	use App\Models\Formularios\md_arranques;
	use App\Models\Formularios\md_medidores;
	use App\Models\Formularios\md_diametro;

	class ctrl_importar_planilla extends BaseController {
		protected $sesión;
		protected $db;
		protected $socios;
		protected $metros;
		protected $convenio_detalle;
		protected $costo_metros;
		protected $arranques;
		protected $medidores;
		protected $diametro;

		public function __construct() {
			$this->sesión = session();
			$this->db = \Config\Database::connect();
			$this->socios = new md_socios();
			$this->metros = new md_metros();
			$this->convenio_detalle = new md_convenio_detalle();
			$this->costo_metros = new md_costo_metros();
			$this->arranques = new md_arranques();
			$this->medidores = new md_medidores();
			$this->diametro = new md_diametro();
		}

		public function importar_planilla() {
			if ($this->request->getMethod() == "post") {
				$ruta = "uploads/";

				if (!is_dir($ruta)) {
					mkdir($ruta, 0755);
				}

				$file = $this->request->getFile("archivos");

				if (!$file->isValid()) {
					throw new RuntimeException($file->getErrorString() . "(". $file->getError() . ")");
				} else {
					$name_file = $file->getName();
					$file->move($ruta);

					if ($file->hasMoved()) {
						$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xls");
						$spreadsheet = $reader->load($ruta.$name_file);
						$sheet = $spreadsheet->getSheet(0);

						$builder = $this->db->table("metros");

						$arr_errors = [];

						foreach ($sheet->getRowIterator(2) as $row) {
							$rol = trim($sheet->getCellByColumnAndRow(2, $row->getRowIndex()));
							$consumo_actual = trim($sheet->getCellByColumnAndRow(8, $row->getRowIndex()));

							$datosSocio = $this->socios->select("id as id_socio")->select("concat(rut, '-', dv) as rut_socio")->select("concat(nombres, ' ', ape_pat, ' ', ape_mat) as nombre_socio")->where("rol", $rol)->where("id_apr", $this->sesión->id_apr_ses)->first();
							$id_socio = $datosSocio["id_socio"];
							$fecha_vencimiento = $this->request->getPost("fecha_vencimiento");

							$existe_consumo_mes = $this->metros->select("count(*) as filas")->where("id_socio", $id_socio)->where("date_format(fecha_vencimiento, '%m-%Y')", date_format(date_create($fecha_vencimiento), 'm-Y'))->where("estado", 1)->first();
							$filas = $existe_consumo_mes["filas"];

							if ($filas > 0) {
								$error = [
									"id_socio" => $id_socio,
									"rut_socio" => $rut_socio,
									"rol_socio" => $rol_socio,
									"nombre_socio" => $nombre_socio,
									"error" => "Registro ya existe"
								];

								$arr_errors[$id_socio] = $error;
							} else {
								$total_servicio = $this->convenio_detalle->calcular_total_servicios($this->db, $fecha_vencimiento, $id_socio);
								$datosMetros = $this->metros->select("max(id) as id_metros")->where("id_socio", $id_socio)->where("estado", 1)->first();
								$datosMetros = $this->metros->select("ifnull(consumo_actual, 0) as consumo_anterior")->where("id", $datosMetros["id_metros"])->first();

								if ($datosMetros != "") {
									$consumo_anterior = $datosMetros["consumo_anterior"];	
								} else {
									$consumo_anterior = 0;
								}
								

								$metros_ = intval($consumo_actual) - intval($consumo_anterior); echo $metros_;

								$arranques_ = $this->arranques->select("id_medidor")->where("id_socio", $id_socio)->first();
								$medidores_ = $this->medidores->select("id_diametro")->where("id", $arranques_["id_medidor"])->first();
								$id_diametro = $medidores_["id_diametro"];

								$datosCostoMetros = $this->costo_metros->datatable_costo_metros_consumo($this->db, $this->sesión->id_apr_ses, $id_diametro, $metros_);

								print_r($datosCostoMetros);
							}
						}
					}
				}
			}
		}
	}
?>