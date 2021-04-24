<?php 
	namespace App\Controllers;
	use App\Models\Consumo\Md_metros;
	use App\Models\Consumo\Md_metros_traza;
	use App\Models\Pagos\Md_caja;
	use App\Models\Pagos\Md_caja_detalle;
	use App\Models\Pagos\Md_caja_traza;

	class Webpay extends Auth {
		protected $metros;
		protected $metros_traza;
		protected $caja;
		protected $caja_detalle;
		protected $caja_traza;

		public function __construct() {
			$this->metros = new Md_metros();
			$this->metros_traza = new Md_metros_traza();
			$this->caja = new Md_caja();
			$this->caja_detalle = new Md_caja_detalle();
			$this->caja_traza = new Md_caja_traza();
		}

		public function crear_folio_webpay() {
			$token = ($this->request->getHeader("Authorization")!=null)?$this->request->getHeader("Authorization")->getValue():"";
			if ($this->validateToken($token) == true) {
				if ($this->request->getMethod() == "post") {
					define("PAGADO", 2);
					define("WEBPAY", 4);

					var_dump($_POST);
					// $arr_datos = json_decode(file_get_contents("php://input")); 


					
					$estado = PAGADO;
					$id_usuario = 9;
					$fecha = date("Y-m-d H:i:s");

					$datosMetros = [
						"id" => $id_metros,
						"estado" => $estado,
						"id_usuario" => $id_usuario,
						"fecha" => $fecha
					];

					$this->metros->save($datosMetros);

					$datosMetrosBuscar = $this->metros->select("total_mes as total_pagar")->select("id_socio")->select("id_apr");

					$total_pagar = $datosMetrosBuscar["total_pagar"];
					$id_socio = $datosMetrosBuscar["id_socio"];
					$id_apr = $datosMetrosBuscar["id_apr"];
					$n_transaccion = $this->request->getPost("numero_transaccion");
					$forma_pago = WEBPAY;

					$datosPago = [
						"total_pagar" => $total_pagar,
						"entregado" => 0,
						"vuelto" => 0,
						"id_forma_pago" => $forma_pago,
						"numero_transaccion" => $n_transaccion,
						"id_socio" => $id_socio,
						"id_usuario" => $id_usuario,
						"fecha" => $fecha,
						"id_apr" => $id_apr
					];

					$this->caja->save($datosPago);

					$datosPagoBuscar = $this->caja->select("max(id) as id_caja")->where("estado", 1)->first();
					$id_caja = $datosPagoBuscar["id_caja"];
				} else {

				}
			} else {
				return $this->respond(["message" => "Token Inválido"], 401);
			}
		}
	}
?>