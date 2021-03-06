<?php namespace App\Models\Consumo;

	use CodeIgniter\Model;

	class md_metros extends Model {
		protected $table = 'metros';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'id_socio', 'monto_subsidio', 'fecha_ingreso', 'fecha_vencimiento', 'consumo_anterior', 'consumo_actual', 'metros', 'subtotal', 'multa', 'total_servicios', 'total_mes', 'id_usuario', 'fecha', 'estado', 'id_apr'];

	    public function datatable_metros($db, $id_apr) {
	    	define("ACTIVO", 1);
	    	$estado = ACTIVO;

	    	$consulta = "SELECT 
							m.id as id_metros,
							m.id_socio,
							soc.rut as rut_socio,
							soc.rol as rol_socio,
							concat(soc.nombres, ' ', soc.ape_pat, ' ', soc.ape_mat) as nombre_socio,
							a.id as id_arranque,
						    ifnull(p.glosa, '0%') as subsidio,
						    (select tope_subsidio from apr where id = m.id_apr) as tope_subsidio,
						    ifnull(m.monto_subsidio, 0) as monto_subsidio,
							sec.nombre as sector,
							med.id_diametro,
							d.glosa as diametro,
							date_format(m.fecha_ingreso, '%d-%m-%Y') as fecha_ingreso,
							date_format(m.fecha_vencimiento, '%d-%m-%Y') as fecha_vencimiento,
							m.consumo_anterior,
							m.consumo_actual,
							m.metros,
							ifnull(m.subtotal, 0) as subtotal,
							ifnull(m.multa, 0) as multa,
							ifnull(m.total_servicios, 0) as total_servicios,
							ifnull(m.total_mes, 0) as total_mes,
							u.usuario,
							date_format(m.fecha, '%d-%m-%Y') as fecha
						from 
							metros m
							inner join socios soc on m.id_socio = soc.id
							inner join arranques a on a.id_socio = soc.id
							inner join sectores sec on a.id_sector = sec.id
							left join subsidios sub on sub.id_socio = soc.id
							left join porcentajes p on sub.id_porcentaje = p.id
							inner join usuarios u on m.id_usuario = u.id
						    inner join medidores med on a.id_medidor = med.id
						    inner join diametro d on med.id_diametro = d.id
						where 
							m.estado = ? and
							m.id_apr = ?
						order by m.fecha_vencimiento asc
						limit 10000";

			$query = $db->query($consulta, [$estado, $id_apr]);
			$metros = $query->getResultArray();

			foreach ($metros as $key) {
				$row = array(
					"id_metros" => $key["id_metros"],
					"id_socio" => $key["id_socio"],
					"rut_socio" => $key["rut_socio"],
					"rol_socio" => $key["rol_socio"],
					"nombre_socio" => $key["nombre_socio"],
					"id_arranque" => $key["id_arranque"],
					"subsidio" => $key["subsidio"],
					"tope_subsidio" => $key["tope_subsidio"],
					"monto_subsidio" => $key["monto_subsidio"],
					"sector" => $key["sector"],
					"id_diametro" => $key["id_diametro"],
					"diametro" => $key["diametro"],
					"fecha_ingreso" => $key["fecha_ingreso"],
					"fecha_vencimiento" => $key["fecha_vencimiento"],
					"consumo_anterior" => $key["consumo_anterior"],
					"consumo_actual" => $key["consumo_actual"],
					"metros" => $key["metros"],
					"subtotal" => $key["subtotal"],
					"multa" => $key["multa"],
					"total_servicios" => $key["total_servicios"],
					"total_mes" => $key["total_mes"],
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

	    public function datatable_buscar_socio($db, $id_apr) {
	    	$consulta = "SELECT 
							s.id as id_socio,
							concat(s.rut, '-', s.dv) as rut,
							s.rol,
							concat(s.nombres, ' ', s.ape_pat, ' ', s.ape_mat) as nombre,
							date_format(s.fecha_entrada, '%d-%m-%Y') as fecha_entrada,
							a.id as id_arranque,
						    m.id_diametro,
						    d.glosa as diametro,
							sec.nombre as sector,
							ifnull(p.glosa, '0%') as subsidio,
							(select tope_subsidio from apr where id = s.id_apr) as tope_subsidio,
							ifnull((select consumo_actual from metros m where m.id = (select max(m2.id) from metros m2 where m2.id_socio = a.id_socio and estado = 1)), 0) as consumo_anterior,
						    cf.cargo_fijo
						from 
							arranques a
						    inner join medidores m on a.id_medidor = m.id
						    inner join diametro d on m.id_diametro = d.id
							inner join socios s on a.id_socio = s.id
							inner join sectores sec on a.id_sector = sec.id
							left join subsidios sub on sub.id_socio = s.id
							left join porcentajes p on sub.id_porcentaje = p.id
						    inner join apr_cargo_fijo cf on cf.id_apr = s.id_apr and cf.id_diametro = m.id_diametro
						where 
							s.id_apr = $id_apr and
							s.estado = 1";


			$query = $db->query($consulta);
			$metros = $query->getResultArray();

			foreach ($metros as $key) {
				$row = array(
					"id_socio" => $key["id_socio"],
					"rut" => $key["rut"],
					"rol" => $key["rol"],
					"nombre" => $key["nombre"],
					"fecha_entrada" => $key["fecha_entrada"],
					"id_arranque" => $key["id_arranque"],
					"id_diametro" => $key["id_diametro"],
					"diametro" => $key["diametro"],
					"sector" => $key["sector"],
					"subsidio" => $key["subsidio"],
					"tope_subsidio" => $key["tope_subsidio"],
					"consumo_anterior" => $key["consumo_anterior"],
					"cargo_fijo" => $key["cargo_fijo"]
				);

				$data[] = $row;
			}

			if (isset($data)) {
				$salida = array("data" => $data);
				return json_encode($salida);
			} else {
				return "{ \"data\": [] }";
			}
	    }
	}
?>