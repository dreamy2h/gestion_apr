<?php 
	namespace App\Controllers\Consumo;

	use App\Controllers\BaseController;
	use App\Models\Consumo\Md_metros;
	use App\Models\Consumo\Md_metros_traza;
	use App\Models\Configuracion\Md_costo_metros;
	use App\Models\Formularios\Md_convenio_detalle;

	class Ctrl_metros extends BaseController {
		protected $metros;
		protected $metros_traza;
		protected $costo_metros;
		protected $convenio_detalle;
		protected $sesión;
		protected $db;

		public function __construct() {
			$this->metros = new Md_metros();
			$this->metros_traza = new Md_metros_traza();
			$this->costo_metros = new Md_costo_metros();
			$this->convenio_detalle = new Md_convenio_detalle();
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
			$id_apr = $this->sesión->id_apr_ses;

			$id_metros = $this->request->getPost("id_metros");
			$id_socio = $this->request->getPost("id_socio");
			$monto_subsidio = $this->request->getPost("monto_subsidio");
			$fecha_ingreso = $this->request->getPost("fecha_ingreso");
			$fecha_vencimiento = $this->request->getPost("fecha_vencimiento");
			$consumo_anterior = $this->request->getPost("consumo_anterior");
			$consumo_actual = $this->request->getPost("consumo_actual");
			$metros = $this->request->getPost("metros");
			$subtotal = $this->request->getPost("subtotal");
			$multa = $this->request->getPost("multa");
			$total_servicios = $this->request->getPost("total_servicios");
			$total_mes = $this->request->getPost("total_mes");

			$datosMetros = [
				"id_socio" => $id_socio,
				"monto_subsidio" => $monto_subsidio,
				"fecha_ingreso" =>  date_format(date_create($fecha_ingreso), 'Y-m-d'),
				"fecha_vencimiento" => date_format(date_create($fecha_vencimiento), 'Y-m-d'),
				"consumo_anterior" => $consumo_anterior,
				"consumo_actual" => $consumo_actual,
				"metros" => $metros,
				"subtotal" => $subtotal,
				"multa" => $multa,
				"total_servicios" => $total_servicios,
				"total_mes" => $total_mes,
				"id_usuario" => $id_usuario,
				"fecha" => $fecha,
				"id_apr" => $id_apr
			];

			if ($id_metros != "") {
				$estado_traza = MODIFICAR_METROS;
				$datosMetros["id"] = $id_metros;
			} else {
				$estado_traza = INGRESO_METROS;
			}

			if ($this->metros->save($datosMetros)) {
				echo OK;
				
				if ($id_metros == "") {
					$obtener_id = $this->metros->select("max(id) as id_metros")->first();
					$id_metros = $obtener_id["id_metros"];
				}
					
				$this->guardar_traza($id_metros, $estado_traza, "");
			} else {
				echo "Error al guardar los metros";
			}
		}

		public function eliminar_metros() {
			$this->validar_sesion();
	    	define("ELIMINAR_METROS", 3);
	    	define("ELIMINAR", 0);
	    	define("OK", 1);
	    	$estado = ELIMINAR;
	    	$estado_traza = ELIMINAR_METROS;

			$id_metros = $this->request->getPost("id_metros");
			$observacion = $this->request->getPost("observacion");

			$fecha = date("Y-m-d H:i:s");
			$id_usuario = $this->sesión->id_usuario_ses;

			$datosMetros = [
				"id" => $id_metros,
				"estado" => $estado,
				"id_usuario" => $id_usuario,
				"fecha" => $fecha
			];

			if ($this->metros->save($datosMetros)) {
				echo OK;
				$this->guardar_traza($id_metros, $estado_traza, $observacion);
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

		public function datatable_costo_metros($consumo_actual, $id_diametro) {
			$this->validar_sesion();
			echo $this->costo_metros->datatable_costo_metros_consumo($this->db, $this->sesión->id_apr_ses, $id_diametro, $consumo_actual);
		}

		public function calcular_total_servicios() {
			$fecha_vencimiento = $this->request->getPost("fecha_vencimiento");
			$id_socio = $this->request->getPost("id_socio");

			echo $this->convenio_detalle->calcular_total_servicios($this->db, $fecha_vencimiento, $id_socio);
		}

		public function existe_consumo_mes() {
			$id_socio = $this->request->getPost("id_socio");
			$fecha_vencimiento = $this->request->getPost("fecha_vencimiento");

			$existe_consumo_mes = $this->metros->select("count(*) as filas")->where("id_socio", $id_socio)->where("date_format(fecha_vencimiento, '%m-%Y')", date_format(date_create($fecha_vencimiento), 'm-Y'))->where("estado", 1)->first();
			$filas = $existe_consumo_mes["filas"];

			echo $filas;
		}

		public function v_importar_planilla() {
			$this->validar_sesion();
			echo view("Consumo/importar_planilla");
		}
	}
?>