<?php namespace App\Models\Pagos;

	use CodeIgniter\Model;

	class Md_caja extends Model {
		protected $table = 'caja';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'total_pagar', 'entregado', 'vuelto', 'id_forma_pago', 'numero_transaccion', 'id_socio', 'estado', 'id_usuario', 'fecha', 'id_apr'];

	    public function datatable_historial_pagos($db, $id_apr, $id_socio, $desde, $hasta) {
	    	$consulta = "SELECT 
							c.id as id_caja,
							c.total_pagar as pagado,
							c.entregado,
							c.vuelto,
						    fp.glosa as forma_pago,
						    ifnull(c.numero_transaccion, 'No Registrado') as n_transaccion,
							s.rol as rol_socio,
							IFNULL(ELT(FIELD(c.estado, 0, 1), 'Anulado', 'Pagado'),'Sin registro') as estado,
							u.usuario,
							date_format(c.fecha, '%d-%m-%Y') as fecha
						from 
							caja c
							inner join socios s on c.id_socio = s.id
							inner join usuarios u on c.id_usuario = u.id
						    inner join forma_pago fp on c.id_forma_pago = fp.id
						where
							c.id_apr = ?";

			if ($id_socio != "") {
				$consulta .= " and c.id_socio = ?";
			}

			if ($desde != "" && $hasta != "") {
				$consulta .= " and date_format(c.fecha, '%d-%m-%Y') between ? and ?";
			}

			$bind = [$id_apr];

			if ($id_socio != "") {
				array_push($bind, $id_socio);
			}

			if ($desde != "" && $hasta != "") {
				array_push($bind, $desde, $hasta);
			}

			$query = $db->query($consulta, $bind);
			$caja = $query->getResultArray();

			foreach ($caja as $key) {
				$row = array(
					"id_caja" => $key["id_caja"],
					"pagado" => $key["pagado"],
					"entregado" => $key["entregado"],
					"vuelto" => $key["vuelto"],
					"forma_pago" => $key["forma_pago"],
					"n_transaccion" => $key["n_transaccion"],
					"rol_socio" => $key["rol_socio"],
					"estado" => $key["estado"],
					"usuario" => $key["usuario"],
					"fecha" => $key["fecha"]
				);

				$data[] = $row;
			}

			if (isset($data)) {
				$salida = array("data" => $data);
				return json_encode($salida);
			} else {
				return "{ \"data\": []}";
			}
	    }
	    
	    public function datatable_informe_pagos_diarios($db, $id_apr) {
	    	define("ACTIVO", 1);
	    	$estado = ACTIVO;
	    	$fecha = date("d-m-Y");

	    	$consulta = "SELECT 
							c.id as folio_caja,
						    s.rol as rol_socio,
						    concat(s.nombres, ' ', s.ape_pat, ' ', s.ape_mat) as nombre_socio,
						    c.total_pagar,
						    c.entregado,
						    c.vuelto,
						    m.metros as consumo,
						    u.usuario as usu_reg
						from 
							caja c
						    inner join caja_detalle cd on cd.id_caja = c.id
						    inner join socios s on c.id_socio = s.id
						    inner join metros m on cd.id_metros = m.id
						    inner join usuarios u on c.id_usuario = u.id
						where 
							date_format(c.fecha, '%d-%m-%Y') = ? and
						    c.id_apr = ? and
						    c.estado = ?";

			$query = $db->query($consulta, [$fecha, $id_apr, $estado]);
			$caja = $query->getResultArray();

			foreach ($caja as $key) {
				$row = array(
					"folio_caja" => $key["folio_caja"],
					"rol_socio" => $key["rol_socio"],
					"nombre_socio" => $key["nombre_socio"],
					"total_pagar" => $key["total_pagar"],
					"entregado" => $key["entregado"],
					"vuelto" => $key["vuelto"],
					"consumo" => $key["consumo"],
					"usu_reg" => $key["usu_reg"]
				);

				$data[] = $row;
			}

			if (isset($data)) {
				$salida = array("data" => $data);
				return json_encode($salida);
			} else {
				return "{ \"data\": []}";
			}
	    }

	    public function datatable_informe_arqueo($db, $id_apr, $datosBusqueda) {
	    	$consulta = "SELECT 
							c.id as id_caja,
							s.rol as rol_socio,
							concat(s.nombres, ' ', s.ape_pat, ' ', s.ape_mat) as nombre_socio,
						    fp.glosa as forma_pago,
						    ifnull(c.numero_transaccion, 'No Registrado') as n_transaccion,
						    date_format(c.fecha, '%d-%m-%Y') as fecha_pago,
						    m.monto_facturable as total,
						    m.monto_subsidio,
						    c.total_pagar as pagado,
						    c.entregado,
						    c.vuelto
						from 
							caja c
						    inner join caja_detalle cd on cd.id_caja = c.id
						    inner join metros m on cd.id_metros = m.id
						    inner join socios s on c.id_socio = s.id
						    inner join forma_pago fp on c.id_forma_pago = fp.id
						where
							c.id_apr = ? and
							c.estado = ?";

			$bind = [$id_apr, 1];

			if ($datosBusqueda != "") {
				$datos = explode(",", $datosBusqueda);
				$id_socio = $datos[0];
				$desde = $datos[1];
				$hasta = $datos[2];
				$id_forma_pago = $datos[3];

				if ($id_socio != "") {
					$consulta .= " and c.id_socio = ?";
					array_push($bind, $id_socio);
				}

				if ($desde != "" && $hasta != "") {
					$consulta .= " and date_format(c.fecha, '%d-%m-%Y') between ? and ?";
					array_push($bind, $desde, $hasta);
				}

				if ($id_forma_pago != "") {
					$consulta .= " and c.id_forma_pago = ?";
					array_push($bind, $id_forma_pago);
				}
			}
			
			$query = $db->query($consulta, $bind);
			$caja = $query->getResultArray();

			foreach ($caja as $key) {
				$row = array(
					"id_caja" => $key["id_caja"],
					"rol_socio" => $key["rol_socio"],
					"nombre_socio" => $key["nombre_socio"],
					"forma_pago" => $key["forma_pago"],
					"n_transaccion" => $key["n_transaccion"],
					"fecha_pago" => $key["fecha_pago"],
					"total" => $key["total"],
					"monto_subsidio" => $key["monto_subsidio"],
					"pagado" => $key["pagado"],
					"entregado" => $key["entregado"],
					"vuelto" => $key["vuelto"]
				);

				$data[] = $row;
			}

			if (isset($data)) {
				$salida = array("data" => $data);
				return json_encode($salida);
			} else {
				return "{ \"data\": []}";
			}
	    }

	    public function datatable_informe_mensual($db, $id_apr, $mes_consumo) {
	    	$consulta = "SELECT 
							date_format(c.fecha, '%d-%m-%Y') as fecha_pago,
						    count(*) as cantidad_boletas,
						    sum(m.subtotal) as subtotal,
						    sum(m.monto_subsidio) as subsidios,
						    sum(m.multa) as multas,
						    sum(m.total_servicios) as servicios,
						    sum(c.total_pagar) as total_pagado
						from 
							caja c
						    inner join caja_detalle cd on cd.id_caja = c.id
						    inner join metros m on cd.id_metros = m.id
						where 
							c.id_apr = ? and
							date_format(c.fecha, '%m-%Y') = ?
						group by
							date_format(c.fecha, '%d-%m-%Y')";

			$query = $db->query($consulta, [$id_apr, $mes_consumo]);
			$caja = $query->getResultArray();

			foreach ($caja as $key) {
				$row = array(
					"fecha_pago" => $key["fecha_pago"],
					"cantidad_boletas" => $key["cantidad_boletas"],
					"subtotal" => $key["subtotal"],
					"subsidios" => $key["subsidios"],
					"multas" => $key["multas"],
					"servicios" => $key["servicios"],
					"total_pagado" => $key["total_pagado"]
				);

				$data[] = $row;
			}

			if (isset($data)) {
				$salida = array("data" => $data);
				return json_encode($salida);
			} else {
				return "{ \"data\": []}";
			}
	    }

	}
?>