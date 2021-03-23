<?php 
	namespace App\Controllers;
	use App\Models\Configuracion\md_permisos_usuario;

	class ctrl_menu extends BaseController {
		protected $sesión;
		protected $permisos_usuario;
		protected $db;

		public function __construct() {
			$this->sesión = session();
			$this->permisos_usuario = new md_permisos_usuario();
			$this->db = \Config\Database::connect();
		}

		public function permisos_usuario() {
			$this->validar_sesion();
			$id_usuario = $this->sesión->id_usuario_ses;

			echo $this->permisos_usuario->permisos_usuario($this->db, $id_usuario);
		}

		public function usuarios() {
			$this->validar_sesion();
			echo view('Configuracion/usuarios');
		}

		public function apr() {
			$this->validar_sesion();
			echo view('Configuracion/apr');
		}

		public function costo_metros() {
			$this->validar_sesion();
			echo view('Configuracion/costo_metros');
		}

		public function socios() {
			$this->validar_sesion();
			echo view('Formularios/socios');
		}

		public function arranques() {
			$this->validar_sesion();
			echo view('Formularios/arranques');
		}

		public function sectores() {
			$this->validar_sesion();
			echo view('Formularios/sectores');
		}

		public function subsidios() {
			$this->validar_sesion();
			echo view('Formularios/subsidios');
		}

		public function convenios() {
			$this->validar_sesion();
			echo view('Formularios/convenios');
		}

		public function medidores() {
			$this->validar_sesion();
			echo view('Formularios/medidores');
		}

		public function metros() {
			$this->validar_sesion();
			echo view('Consumo/metros');
		}

		public function caja() {
			$this->validar_sesion();
			echo view('Pagos/caja');
		}

		public function historial_pagos() {
			$this->validar_sesion();
			echo view('Pagos/historial_pagos');
		}

		public function boleta_electronica() {
			$this->validar_sesion();
			echo view('Pagos/boleta_electronica');
		}

		public function informe_socios() {
			$this->validar_sesion();
			echo view('Informes/informe_socios');	
		}

		public function validar_sesion() {
			if (!$this->sesión->has("id_usuario_ses")) {
				return redirect()->to("http://localhost/gestion_apr/public/");
				exit();
	    	}
		}
	}
?>