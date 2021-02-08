<?php 
	namespace App\Controllers\Configuracion;

	use App\Controllers\BaseController;
	use App\Models\Configuracion\md_costo_metros;
	use App\Models\Configuracion\md_costo_metros_traza;

	class ctrl_costo_metros extends BaseController {
		protected $costo_metros;
		protected $costo_metros_traza;
		protected $sesión;
		protected $db;

		public function __construct() {
			$this->costo_metros = new md_costo_metros();
			$this->costo_metros_traza = new md_costo_metros_traza();
			$this->sesión = session();
			$this->db = \Config\Database::connect();
		}

		public function validar_sesion() {
			if (!$this->sesión->has("id_usuario_ses")) {
				echo "La sesión expiró, actualice el sitio web con F5";
				exit();
	    	}
		}

		public function datatable_costo_metros($id_apr) {
			$this->validar_sesion();
			echo $this->costo_metros->datatable_costo_metros($this->db, $id_apr);
		}

		public function guardar_costo_metros() {
			$this->validar_sesion();
	    	define("CREAR_COSTO_METROS", 1);
	    	define("MODIFICAR_COSTO_METROS", 2);
			define("OK", 1);

			$fecha = date("Y-m-d H:i:s");
			$id_usuario = $this->sesión->id_usuario_ses;

			$id_costo_metros = $this->request->getPost("id_costo_metros");
			$id_apr = $this->request->getPost("id_apr");
			$desde = $this->request->getPost("desde");
			$hasta = $this->request->getPost("hasta");
			$costo = $this->request->getPost("costo");

			if (intval($hasta) <= intval($desde)) {
				echo "Hasta debe ser mayor a desde";
				exit();
			}

			if ($this->costo_metros->validar_metraje_existente($this->db, $desde, $hasta, $id_apr, $id_costo_metros)) {
				echo "El rango de metros ingresado, se topa con uno existente";
				exit();
			}

			$datosCostoMetros = [
				"id_apr" => $id_apr,
				"desde" => $desde,
				"hasta" => $hasta,
				"costo" => $costo,
				"id_usuario" => $id_usuario,
				"fecha" => $fecha
			];

			if ($id_costo_metros != "") {
				$estado_traza = MODIFICAR_COSTO_METROS;
				$datosCostoMetros["id"] = $id_costo_metros;
			} else {
				$estado_traza = CREAR_COSTO_METROS;
			}

			if ($this->costo_metros->save($datosCostoMetros)) {
				echo OK;
				
				if ($id_costo_metros == "") {
					$obtener_id = $this->costo_metros->select("max(id) as id_costo_metros")->first();
					$id_costo_metros = $obtener_id["id_costo_metros"];
				}
					
				$this->guardar_traza($id_costo_metros, $estado_traza, "");
			} else {
				echo "Error al guardar los datos de costos";
			}
		}

		public function guardar_traza($id_costo_metros, $estado, $observacion) {
			$this->validar_sesion();

			$fecha = date("Y-m-d H:i:s");
			$id_usuario = $this->sesión->id_usuario_ses;

			$datosTraza = [
				"id_costo_metros" => $id_costo_metros,
				"estado" => $estado,
				"observacion" => $observacion,
				"id_usuario" => $id_usuario,
				"fecha" => $fecha
			];

			if (!$this->costo_metros_traza->save($datosTraza)) {
				echo "Falló al guardar la traza";
			}
		}

		public function eliminar_costo_metros() {
			define("ELIMINAR_COSTO_METROS", 3);
			define("ELIMINAR", 0);
			define("OK", 1);

			$fecha = date("Y-m-d H:i:s");
			$id_usuario = $this->sesión->id_usuario_ses;
			$estado_traza = ELIMINAR_COSTO_METROS;

			$id_costo_metros = $this->request->getPost("id_costo_metros");
			$estado = $this->request->getPost("estado");
			$observacion = $this->request->getPost("observacion");

			$datosCostoMetros = [
				"id" => $id_costo_metros,
				"id_usuario" => $id_usuario,
				"fecha" => $fecha,
				"estado" => $estado,
			];

			if ($this->costo_metros->save($datosCostoMetros)) {
				echo OK;
				$this->guardar_traza($id_costo_metros, $estado_traza, $observacion);
			} else {
				echo "Error al eliminar el costo";
			}
		}

		public function v_costo_metros_traza() {
			$this->validar_sesion();
			echo view("Configuracion/costo_metros_traza");
		}

		public function datatable_costo_metros_traza($id_costo_metros) {
			$this->validar_sesion();
			echo $this->costo_metros_traza->datatable_costo_metros_traza($this->db, $id_costo_metros);
		}
	}
?>