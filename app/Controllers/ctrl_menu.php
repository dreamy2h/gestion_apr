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

		public function validar_sesion() {
			if (!$this->sesión->has("id_usuario_ses")) {
				echo "La sesión expiró, actualice el sitio web con F5";
				exit();
	    	}
		}
	}
?>