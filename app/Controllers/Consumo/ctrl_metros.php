<?php 
	namespace App\Controllers\Consumo;

	use App\Controllers\BaseController;
	use App\Models\Consumo\md_metros;
	use App\Models\Consumo\md_metros_traza;
	use App\Models\Configuracion\md_costo_metros;

	class ctrl_metros extends BaseController {
		protected $metros;
		protected $metros_traza;
		protected $costo_metros;
		protected $sesión;
		protected $db;

		public function __construct() {
			$this->metros = new md_metros();
			$this->metros_traza = new md_metros_traza();
			$this->costo_metros = new md_costo_metros();
			$this->sesión = session();
			$this->db = \Config\Database::connect();
		}

		public function validar_sesion() {
			if (!$this->sesión->has("id_usuario_ses")) {
				echo "La sesión expiró, actualice el sitio web con F5";
				exit();
	    	}
		}

		public function datatable_metros() {
			$this->validar_sesion();
			echo $this->metros->datatable_metros($this->db, $this->sesión->id_apr_ses);
		}

		public function guardar_metros() {
			$this->validar_sesion();
	    	define("INGRESO_METROS", 1);
	    	define("MODIFICAR_METROS", 2);

			define("OK", 1);

			$fecha = date("Y-m-d H:i:s");
			$id_usuario = $this->sesión->id_usuario_ses;

			$id_metros = $this->request->getPost("id_metros");
			$id_socio = $this->request->getPost("id_socio");
			$subsidio = $this->request->getPost("subsidio");
			$fecha_ingreso = $this->request->getPost("fecha_ingreso");
			$fecha_vencimiento = $this->request->getPost("fecha_vencimiento");
			$consumo_anterior = $this->request->getPost("consumo_anterior");
			$consumo_actual = $this->request->getPost("consumo_actual");
			$metros = $this->request->getPost("metros");
			$total_metros = $this->request->getPost("total_metros");
			$subtotal = $this->request->getPost("subtotal");
			$multa = $this->request->getPost("multa");
			$total_servicios = $this->request->getPost("total_servicios");
			$saldo_aterior = $this->request->getPost("saldo_aterior");
			$total_mes = $this->request->getPost("total_mes");

			$datosMetros = [
				"id_socio" => $id_socio,
				"monto_subsidio" => $subsidio,
				"fecha_ingreso" => $fecha_ingreso,
				"fecha_vencimiento" => $fecha_vencimiento,
				"consumo_anterior" => $consumo_anterior,
				"consumo_actual" => $consumo_actual,
				"metros" => $metros,
				"total_metros" => $total_metros,
				"Subtotal" => $subtotal,
				"multa" => $multa,
				"total_servicios" => $total_servicios,
				"saldo_anterior" => $saldo_aterior,
				"total_mes" => $total_mes,
				"id_usuario" => $id_usuario,
				"fecha" => $fecha
			];

			if ($id_metros != "") {
				$estado_traza = MODIFICAR_METROS;
				$datosMetros["id"] = $id_metros;
			} else {
				$estado_traza = INGRESO_METROS;
			}

			if ($this->metros->save($datosMetros)) {
				echo OK;
				
				if ($id_metros != "") {
					$obtener_id = $this->metros->select("max(id) as id_metros")->first();
					$id_metros = $obtener_id["id_metros"];
				}
					
				$this->guardar_traza($id_metros, $estado_traza, "");
			} else {
				echo "Error al guardar los metros";
			}
		}

		public function guardar_traza($id_metros, $estado, $observacion) {
			$this->validar_sesion();

			$fecha = date("Y-m-d H:i:s");
			$id_usuario = $this->sesión->id_usuario_ses;

			$datosTraza = [
				"id_metros" => $id_metros,
				"estado" => $estado,
				"observacion" => $observacion,
				"id_usuario" => $id_usuario,
				"fecha" => $fecha
			];

			if (!$this->metros_traza->save($datosTraza)) {
				echo "Falló al guardar la traza";
			}
		}

		public function v_metros_traza() {
			$this->validar_sesion();
			echo view("Consumo/metros_traza");
		}

		public function datatable_metros_traza($id_metros) {
			$this->validar_sesion();
			echo $this->metros_traza->datatable_metros_traza($this->db, $id_metros);
		}

		public function datatable_buscar_socio() {
			$this->validar_sesion();
			echo $this->metros->datatable_buscar_socio($this->db, $this->sesión->id_apr_ses);
		}

		public function datatable_costo_metros($consumo_actual) {
			$this->validar_sesion();
			echo $this->costo_metros->datatable_costo_metros_consumo($this->db, $this->sesión->id_apr_ses, $consumo_actual);
		}
	}
?>