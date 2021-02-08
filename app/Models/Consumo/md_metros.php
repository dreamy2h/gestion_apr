<?php namespace App\Models\Consumo;

	use CodeIgniter\Model;

	class md_metros extends Model {
		protected $table = 'metros';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'id_socio', 'monto_subsidio', 'fecha_ingreso', 'fecha_vencimiento', 'consumo_anteior', 'consumo_actual', 'metros', 'total_metros', 'subtotal', 'multa', 'tota_servicios', 'saldo_aterior', 'total_mes', 'id_usuario', 'fecha', 'estado'];

	    public function datatable_metros($db, $id_apr) {
	    	$consulta = "SELECT 
							m.id as id_metros,
						    m.id_socio,
						    soc.rut as rut_socio,
						    soc.rol as rol_socio,
						    concat(soc.nombres, ' ', soc.ape_pat, ' ', soc.ape_mat) as nombre_socio,
						    a.id as id_arranque,
						    sec.nombre as sector,
						    concat(p.glosa, ' - ', m.monto_subsidio) as subsidio,
						    date_format(m.fecha_ingreso, '%d-%m-%Y') as fecha_ingreso,
						    date_format(m.fecha_vencimiento, '%d-%-m-Y') as fecha_vencimiento,
						    m.consumo_anterior,
						    m.consumo_actual,
						    m.metros,
						    m.total_metros,
						    m.subtotal,
						    m.multa,
						    m.total_servicios,
						    m.saldo_anterior,
						    m.total_mes,
						    u.usuario,
						    date_format(m.fecha, '%d-%m-%Y') as fecha
						from 
							metros m
						    inner join socios soc on m.id_socio = soc.id
						    inner join arranques a on a.id_socio = soc.id
						    inner join sectores sec on a.id_sector = sec.id
						    inner join subsidios sub on sub.id_socio = soc.id
						    inner join porcentajes p on sub.id_porcentaje = p.id
    						inner join usuarios u on m.id_usuario = u.id_usuario
						where 
							m.estado = 1 and
    						m.id_apr = $id_apr";

			$query = $db->query($consulta);
			$metros = $query->getResultArray();

			foreach ($metros as $key) {
				$row = array(
					"id_metros" => $key["id_metros"],
					"id_socio" => $key["id_socio"],
					"rut_socio" => $key["rut_socio"],
					"rol_socio" => $key["rol_socio"],
					"nombre_socio" => $key["nombre_socio"],
					"id_arranque" => $key["id_arranque"],
					"sector" => $key["sector"],
					"subsidio" => $key["subsidio"],
					"fecha_ingreso" => $key["fecha_ingreso"],
					"fecha_vencimiento" => $key["fecha_vencimiento"],
					"consumo_anterior" => $key["consumo_anterior"],
					"consumo_actual" => $key["consumo_actual"],
					"metros" => $key["metros"],
					"total_metros" => $key["total_metros"],
					"subtotal" => $key["subtotal"],
					"multa" => $key["multa"],
					"total_servicios" => $key["total_servicios"],
					"saldo_anterior" => $key["saldo_anterior"],
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
						    sec.nombre as sector,
						    ifnull((select consumo_actual from metros m where m.id = (select max(m2.id) from metros m2 where m2.id_socio = a.id_socio)), 0) as consumo_anterior
						from 
							arranques a
							inner join socios s on a.id_socio = s.id
						    inner join sectores sec on a.id_sector = sec.id
						    
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
					"sector" => $key["sector"],
					"consumo_anterior" => $key["consumo_anterior"]
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