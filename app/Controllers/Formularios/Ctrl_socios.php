<?php 
	namespace App\Controllers\Formularios;

	use App\Controllers\BaseController;
	use App\Models\Formularios\Md_socios;
	use App\Models\Formularios\Md_socios_traza;

	class Ctrl_socios extends BaseController {
		protected $socios;
		protected $socios_traza;
		protected $sesión;
		protected $db;

		public function __construct() {
			$this->socios = new Md_socios();
			$this->socios_traza = new Md_socios_traza();
			$this->sesión = session();
			$this->db = \Config\Database::connect();
		}

		public function validar_sesion() {
			if (!$this->sesión->has("id_usuario_ses")) {
				echo "La sesión expiró, actualice el sitio web con F5";
				exit();
	    	}
		}

		public function datatable_socios() {
			$this->validar_sesion();
			echo $this->socios->datatable_socios($this->db, $this->sesión->id_apr_ses);
		}

		public function guardar_socio() {
			$this->validar_sesion();
	    	define("CREAR_SOCIO", 1);
	    	define("MODIFICAR_SOCIO", 2);

			define("OK", 1);
			define("ACTIVO", 1);

			$fecha = date("Y-m-d H:i:s");
			$id_usuario = $this->sesión->id_usuario_ses;
			$id_apr = $this->sesión->id_apr_ses;
			$estado = ACTIVO;

			$id_socio = $this->request->getPost("id_socio");
			$rut = $this->request->getPost("rut");
			$rol = $this->request->getPost("rol");
			$nombres = $this->request->getPost("nombres");
			$ape_pat = $this->request->getPost("ape_pat");
			$ape_mat = $this->request->getPost("ape_mat");
			$fecha_entrada = $this->request->getPost("fecha_entrada");
			$fecha_nacimiento = $this->request->getPost("fecha_nacimiento");
			$id_sexo = $this->request->getPost("id_sexo");
			$id_region = $this->request->getPost("id_region");
			$id_provincia = $this->request->getPost("id_provincia");
			$id_comuna = $this->request->getPost("id_comuna");
			$calle = $this->request->getPost("calle");
			$numero = $this->request->getPost("numero");
			$resto_direccion = $this->request->getPost("resto_direccion");

			if ($id_comuna == "") { $id_comuna = null; }
			if ($fecha_nacimiento == "") { $fecha_nacimiento = null; } else { $fecha_nacimiento = date_format(date_create($fecha_nacimiento), 'Y-m-d'); }

			$rut_completo = explode("-", $rut);
			$rut = $rut_completo[0];
			$dv = $rut_completo[1];

			if ($this->socios->existe_socio($rut, $rol) and $id_socio == "") {
				echo "Socio ya existe en el sistema";
				exit();
			}

			$datosSocio = [
				"rut" => $rut,
				"dv" => $dv,
				"rol" => $rol,
				"nombres" => $nombres,
				"ape_pat" => $ape_pat,
				"ape_mat" => $ape_mat,
				"fecha_entrada" => date_format(date_create($fecha_entrada), 'Y-m-d'),
				"fecha_nacimiento" => $fecha_nacimiento,
				"id_sexo" => $id_sexo,
				"calle" => $calle,
				"numero" => $numero,
				"resto_direccion" => $resto_direccion,
				"id_comuna" => $id_comuna,
				"id_usuario" => $id_usuario,
				"fecha" => $fecha,
				"id_apr" => $id_apr,
			];

			if ($id_socio != "") {
				$estado_traza = MODIFICAR_SOCIO;
				$datosSocio["id"] = $id_socio;
			} else {
				$estado_traza = CREAR_SOCIO;
				$datosSocio["estado"] = $estado;
			}

			if ($this->socios->save($datosSocio)) {
				echo OK;
				
				if ($id_socio == "") {
					$obtener_id = $this->socios->select("max(id) as id_socio")->first();
					$id_socio = $obtener_id["id_socio"];
				}
					
				$this->guardar_traza($id_socio, $estado_traza, "");
			} else {
				echo "Error al guardar los datos del sector";
			}
		}

		public function guardar_traza($id_socio, $estado, $observacion) {
			$this->validar_sesion();

			$fecha = date("Y-m-d H:i:s");
			$id_usuario = $this->sesión->id_usuario_ses;

			$datosTraza = [
				"id_socio" => $id_socio,
				"estado" => $estado,
				"observacion" => $observacion,
				"id_usuario" => $id_usuario,
				"fecha" => $fecha
			];

			if (!$this->socios_traza->save($datosTraza)) {
				echo "Falló al guardar la traza";
			}
		}

		public function v_socio_traza() {
			$this->validar_sesion();
			echo view("Formularios/socio_traza");
		}

		public function datatable_socio_traza($id_socio) {
			$this->validar_sesion();
			echo $this->socios_traza->datatable_socio_traza($this->db, $id_socio);
		}
	}
?>