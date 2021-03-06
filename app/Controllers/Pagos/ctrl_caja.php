<?php 
	namespace App\Controllers\Pagos;

	use App\Controllers\BaseController;
	use App\Models\Consumo\md_metros;
	use App\Models\Consumo\md_metros_traza;

	class ctrl_caja extends BaseController {
		protected $metros;
		protected $metros_traza;
		protected $sesión;
		protected $db;

		public function __construct() {
			$this->metros = new md_metros();
			$this->metros_traza = new md_metros_traza();
			$this->sesión = session();
			$this->db = \Config\Database::connect();
		}

		public function datatable_deuda_socio($id_socio) {
			$datosDeuda = $this->metros->select("id as id_metros")->select("total_mes as deuda")->select("date_format(fecha_vencimiento, '%d-%m-%Y') as fecha_vencimiento")->where("id_socio", $id_socio)->where("estado", 1)->findAll();

			foreach ($datosDeuda as $key) {
				$row = array(
					"id_metros" => $key["id_metros"],
					"deuda" => $key["deuda"],
					"fecha_vencimiento" => $key["fecha_vencimiento"]
				);

				$data[] = $row;
			}

			if (isset($data)) {
				$salida = array("data" => $data);
				return json_encode($salida);
			} else {
				$salida = array("data" => "");
				return json_encode($salida);
			}
		}
	}
?>