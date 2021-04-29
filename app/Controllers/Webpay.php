<?php 
	namespace App\Controllers;
	use App\Models\Consumo\Md_metros;
	use App\Models\Consumo\Md_metros_traza;
	use App\Models\Pagos\Md_caja;
	use App\Models\Pagos\Md_caja_detalle;
	use App\Models\Pagos\Md_caja_traza;
	use App\Models\Formularios\Md_socios;

	class Webpay extends Auth {
		protected $metros;
		protected $metros_traza;
		protected $caja;
		protected $caja_detalle;
		protected $caja_traza;
		protected $socios;
		protected $db;

		public function __construct() {
			$this->metros = new Md_metros();
			$this->metros_traza = new Md_metros_traza();
			$this->caja = new Md_caja();
			$this->caja_detalle = new Md_caja_detalle();
			$this->caja_traza = new Md_caja_traza();
			$this->socios = new Md_socios();
			$this->db = \Config\Database::connect();
		}

		public function crear_folio_webpay() {
			$token = ($this->request->getHeader("Authorization")!=null)?$this->request->getHeader("Authorization")->getValue():"";
			if ($this->validateToken($token) == true) {
				if ($this->request->getMethod() == "post") {
					define("PAGADO", 2);
					define("WEBPAY", 4);
					define("PAGADO_TRAZA", 5);
					$estado = PAGADO;
					$forma_pago = WEBPAY;
					$id_usuario = 9;
					$fecha = date("Y-m-d H:i:s");
					
					$arr_datos = json_decode(file_get_contents("php://input")); 
					// return $this->respond(["message" => $arr_datos], 401);
					
					foreach ($arr_datos as $datos => $datosPago) {
						$e = 0;
						foreach ($datosPago as $key => $value) {
							switch ($e) {
								case 0:
									$total_pagar = $value;
									break;
								case 1:
									$id_socio = $value;
									break;
								case 2:
									$id_apr = $value;
									break;
								case 3:
									$id_metros = $value;
									break;
							}
							$e++;
						}

						$datosPago = [
							"total_pagar" => $total_pagar,
							"entregado" => 0,
							"vuelto" => 0,
							"id_forma_pago" => $forma_pago,
							"id_socio" => $id_socio,
							"id_usuario" => $id_usuario,
							"fecha" => $fecha,
							"id_apr" => $id_apr
						];

						$this->caja->save($datosPago);
						$datosPagoBuscar = $this->caja->select("max(id) as id_caja")->where("estado", 1)->first();
						$id_caja = $datosPagoBuscar["id_caja"];

						$datosPagoTraza = [
							"id_caja" => $id_caja,
							"estado" => 1,
							"id_usuario" => $id_usuario,
							"fecha" => $fecha
						];

						$this->caja_traza->save($datosPagoTraza);
						
						$largo = count($id_metros);
						
						for ($i=0; $i < $largo; $i++) {
							$datosPagoDetalle = [
								"id_caja" => $id_caja,
								"id_metros" => $id_metros[0]
							];

							$this->caja_detalle->save($datosPagoDetalle);

							$datosMetros = [
								"id" => $id_metros[0],
								"estado" => $estado,
								"id_usuario" => $id_usuario,
								"fecha" => $fecha
							];

							$this->metros->save($datosMetros);
								
							$datosMetrosTraza = [
								"id_metros" => $id_metros[0],
								"estado" => PAGADO_TRAZA,
								"id_usuario" => $id_usuario,
								"fecha" => $fecha
							];

							$this->metros_traza->save($datosMetrosTraza);
						}

						$respuesta = [
							"message" => "Datos guardados con éxito",
							"estado" => "exito",
							"folio" => $id_caja
						];

						return $this->respond($respuesta, 200);
					}
				} else {
					$respuesta = [
						"message" => "No hay datos enviados por post",
						"estado" => "error"
					];

					return $this->respond($respuesta, 401);
				}
			} else {
				$respuesta = [
					"message" => "Token Inválido",
					"estado" => "error"
				];

				return $this->respond($respuesta, 401);
			}
		}

		public function consulta_deuda() {
			$token = ($this->request->getHeader("Authorization")!=null)?$this->request->getHeader("Authorization")->getValue():"";
			if ($this->validateToken($token) == true) {
				if ($this->request->getMethod() == "post") {
					$rut = $this->request->getPost('rut');
					// return $this->respond(["message" => $rut], 401);

					$consulta = "SELECT 
									s.id as id_socio,
								    concat(s.nombres, ' ', s.ape_pat, ' ', s.ape_mat) as nombre,
									m.total_mes as total_pagar,
									s.id_apr,
									m.id as id_metros,
									apr.nombre as apr
								from 
									socios s 
									inner join metros m on m.id_socio = s.id
									inner join apr on m.id_apr = apr.id
								where 
									s.rut = ? and 
									s.estado = ?";

					$query = $this->db->query($consulta, [$rut, 1]);
					$metros = $query->getResultArray();

					foreach ($metros as $key) {
						$row = array(
							"id_socio" => $key["id_socio"],
							"nombre" => $key["nombre"],
							"total_pagar" => $key["total_pagar"],
							"id_apr" => $key["id_apr"],
							"id_metros" => $key["id_metros"],
							"apr" => $key["apr"]
						);

						$data[] = $row;
					}

					return $this->respond($data, 200);
				} else {
					$respuesta = [
						"message" => "No hay datos enviados por post",
						"estado" => "error"
					];

					return $this->respond($respuesta, 401);
				}
			} else {
				$respuesta = [
					"message" => "Token Inválido",
					"estado" => "error"
				];

				return $this->respond($respuesta, 401);
			}
		}
	}
?>