<?php 
	namespace App\Controllers\Pagos;

	use App\Controllers\BaseController;
	use App\Models\Consumo\md_metros;
	use App\Models\Consumo\md_metros_traza;
	use App\Models\Pagos\md_caja;
	use App\Models\Pagos\md_caja_detalle;
	use App\Models\Pagos\md_caja_traza;

	class ctrl_caja extends BaseController {
		protected $metros;
		protected $metros_traza;
		protected $caja;
		protected $caja_detalle;
		protected $caja_traza;
		protected $sesión;
		protected $db;

		public function __construct() {
			$this->metros = new md_metros();
			$this->metros_traza = new md_metros_traza();
			$this->caja = new md_caja();
			$this->caja_detalle = new md_caja_detalle();
			$this->caja_traza = new md_caja_traza();
			$this->sesión = session();
			$this->db = \Config\Database::connect();
		}

		public function validar_sesion() {
			if (!$this->sesión->has("id_usuario_ses")) {
				echo "La sesión expiró, actualice el sitio web con F5";
				exit();
	    	}
		}

		public function datatable_deuda_socio($id_socio) {
			$this->validar_sesion();

			$datosDeuda = $this->metros->select("id as id_metros")->select("total_mes as deuda")->select("date_format(fecha_vencimiento, '%d-%m-%Y') as fecha_vencimiento")->where("id_socio", $id_socio)->where("estado", 1)->findAll();

			foreach ($datosDeuda as $key) {
				$row = array(
					"id_metros" => $key["id_metros"],
					"deuda" => $key["deuda"],
					"fecha_vencimiento" => $key["fecha_vencimiento"]
				);

				$data[] = $row;
			}

			if (isset($data)) {
				$salida = array("data" => $data);
				return json_encode($salida);
			} else {
				$salida = array("data" => "");
				return json_encode($salida);
			}
		}

		public function guardar_pago() {
			$this->validar_sesion();
			
			define("OK", 1);
			define("PAGADO", 2);
			define("PAGADO_TRAZA", 5);

			$id_socio = $this->request->getPost("id_socio");
			$total_pagar = $this->request->getPost("total_pagar");
			$entregado = $this->request->getPost("entregado");
			$vuelto = $this->request->getPost("vuelto");
			$arr_ids_metros = $this->request->getPost("arr_ids_metros");

			$fecha = date("Y-m-d H:i:s");
			$id_usuario = $this->sesión->id_usuario_ses;
			$id_apr = $this->sesión->id_apr_ses;

			$datosPago = [
				"total_pagar" => $total_pagar,
				"entregado" => $entregado,
				"vuelto" => $vuelto,
				"id_socio" => $id_socio,
				"id_usuario" => $id_usuario,
				"fecha" => $fecha,
				"id_apr" => $id_apr
			];

			if ($this->caja->save($datosPago)) {
				$datosPago_ = $this->caja->select("max(id) as id_caja")->where("estado", 1)->first();
				$id_caja = $datosPago_["id_caja"];
				$estado_pago = PAGADO;

				foreach ($arr_ids_metros as $id_metros) {
					$datosPagoDetalle = [
						"id_caja" => $id_caja,
						"id_metros" => $id_metros
					];

					if (!$this->caja_detalle->save($datosPagoDetalle)) {
						echo "Error al registrar el detalle del pago";
					}

					$datosMetros = [
						"id" => $id_metros,
						"estado" => $estado_pago,
						"id_usuario" => $id_usuario,
						"fecha" => $fecha
					];

					if ($this->metros->save($datosMetros)) {
						$datosMetrosTraza = [
							"id_metros" => $id_metros,
							"estado" => PAGADO_TRAZA,
							"id_usuario" => $id_usuario,
							"fecha" => $fecha
						];

						if (!$this->metros_traza->save($datosMetrosTraza)) {
							echo "Error al registrar traza al registro de metros";
						}
					}
				}

				echo OK;

				$datosPagoTraza = [
					"id_caja" => $id_caja,
					"estado" => 1,
					"id_usuario" => $id_usuario,
					"fecha" => $fecha
				];

				if (!$this->caja_traza->save($datosPagoTraza)) {
					echo "Error al registrar la traza del pago";
				}
			}
		}
	}
?>