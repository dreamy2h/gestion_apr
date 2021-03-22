<?php 
	namespace App\Controllers;

	class ctrl_menu extends BaseController {
		protected $sesión;

		public function __construct() {
			$this->sesión = session();
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