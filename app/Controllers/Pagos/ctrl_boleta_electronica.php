<?php 
	namespace App\Controllers\Pagos;

	use App\Controllers\BaseController;
	use App\Models\Consumo\md_metros;
	use App\Models\Consumo\md_metros_traza;

	class ctrl_boleta_electronica extends BaseController {
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

		public function validar_sesion() {
			if (!$this->sesión->has("id_usuario_ses")) {
				echo "La sesión expiró, actualice el sitio web con F5";
				exit();
	    	}
		}

		public function datatable_boleta_electronica($datosBusqueda) {
			$this->validar_sesion();
			echo $this->metros->datatable_boleta_electronica($this->db, $this->sesión->id_apr_ses, $datosBusqueda);
		}
	}
?>