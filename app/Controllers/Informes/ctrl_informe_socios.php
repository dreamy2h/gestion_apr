<?php 
	namespace App\Controllers\Informes;

	use App\Controllers\BaseController;
	use App\Models\Formularios\md_socios;
	use App\Models\Formularios\md_socios_traza;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;

	class ctrl_informe_socios extends BaseController {
		protected $socios;
		protected $socios_traza;
		protected $sesión;
		protected $db;

		public function __construct() {
			$this->socios = new md_socios();
			$this->socios_traza = new md_socios_traza();
			$this->sesión = session();
			$this->db = \Config\Database::connect();
		}

		public function validar_sesion() {
			if (!$this->sesión->has("id_usuario_ses")) {
				echo "La sesión expiró, actualice el sitio web con F5";
				exit();
	    	}
		}

		public function datatable_informe_socios() {
			$this->validar_sesion();
			echo $this->socios->datatable_informe_socios($this->db, $this->sesión->id_apr_ses);
		}
	}
?>