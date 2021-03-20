<?php 
	namespace App\Controllers\Informes;

	use App\Controllers\BaseController;
	use App\Models\Formularios\md_socios;
	use App\Models\Formularios\md_socios_traza;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

		public function datatable_informe_socios($datosBusqueda) {
			$this->validar_sesion();
			echo $this->socios->datatable_informe_socios($this->db, $this->sesión->id_apr_ses, $datosBusqueda, "datatable");
		}

		public function exportar_excel($datosBusqueda) {
			$this->validar_sesion();
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			$datosSocios = $this->socios->datatable_informe_socios($this->db, $this->sesión->id_apr_ses, $datosBusqueda, "export");
			$fecha = date("Y-m-d H:i:s");

			$sheet->setCellValue('A1', 'Id.');
			$sheet->setCellValue('B1', 'RUT');
			$sheet->setCellValue('C1', 'ROL');
			$sheet->setCellValue('D1', 'Nombre');
			$sheet->setCellValue('E1', 'Fecha Entrada');
			$sheet->setCellValue('F1', 'Fecha Nacimiento');
			$sheet->setCellValue('G1', 'Sexo');
			$sheet->setCellValue('H1', 'Calle');
			$sheet->setCellValue('I1', 'N° Casa');
			$sheet->setCellValue('J1', 'Resto Dirección');
			$sheet->setCellValue('K1', 'Comuna');
			$sheet->setCellValue('L1', 'Estado');

			$x = 2;
		    foreach($datosSocios as $dato){
		        $sheet->setCellValue('A'.$x, $dato["id_socio"]);
		        $sheet->setCellValue('B'.$x, $dato["rut"]);
		        $sheet->setCellValue('C'.$x, $dato["rol"]);
		        $sheet->setCellValue('D'.$x, $dato["nombre_completo"]);
		        $sheet->setCellValue('E'.$x, $dato["fecha_entrada"]);
		        $sheet->setCellValue('F'.$x, $dato["fecha_nacimiento"]);
		        $sheet->setCellValue('G'.$x, $dato["sexo"]);
		        $sheet->setCellValue('H'.$x, $dato["calle"]);
		        $sheet->setCellValue('I'.$x, $dato["numero"]);
		        $sheet->setCellValue('J'.$x, $dato["resto_direccion"]);
		        $sheet->setCellValue('K'.$x, $dato["comuna"]);
		        $sheet->setCellValue('L'.$x, $dato["estado"]);
		      	$x++;
		    }

			$writer = new Xlsx($spreadsheet);
			$filename = "Export-Socios-" . $fecha;

			header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
	        header('Cache-Control: max-age=0');
	        
	        $writer->save('php://output');
		}
	}
?>