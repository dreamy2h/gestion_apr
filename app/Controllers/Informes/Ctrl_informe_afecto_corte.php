<?php 
	namespace App\Controllers\Informes;

	use App\Controllers\BaseController;
	use App\Models\Formularios\Md_socios;

	class Ctrl_informe_afecto_corte extends BaseController {
		protected $socios;
		protected $sesión;
		protected $db;

		public function __construct() {
			$this->socios = new Md_socios();
			$this->sesión = session();
			$this->db = \Config\Database::connect();
		}

		public function validar_sesion() {
			if (!$this->sesión->has("id_usuario_ses")) {
				echo "La sesión expiró, actualice el sitio web con F5";
				exit();
	    	}
		}

		public function datatable_informe_afecto_corte($n_meses) {
			$this->validar_sesion();
			echo $this->socios->datatable_informe_afecto_corte($this->db, $this->sesión->id_apr_ses, $n_meses);
		}
	}
?>