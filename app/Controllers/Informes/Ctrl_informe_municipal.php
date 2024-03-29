<?php 
	namespace App\Controllers\Informes;

	use App\Controllers\BaseController;
	use App\Models\Consumo\Md_metros;

	class Ctrl_informe_municipal extends BaseController {
		protected $metros;
		protected $sesión;
		protected $db;

		public function __construct() {
			$this->metros = new Md_metros();
			$this->sesión = session();
			$this->db = \Config\Database::connect();
		}

		public function validar_sesion() {
			if (!$this->sesión->has("id_usuario_ses")) {
				echo "La sesión expiró, actualice el sitio web con F5";
				exit();
	    	}
		}

		public function datatable_informe_municipal($mes_consumo) {
			$this->validar_sesion();
			echo $this->metros->datatable_informe_municipal($this->db, $this->sesión->id_apr_ses, $mes_consumo);
		}
	}
?>