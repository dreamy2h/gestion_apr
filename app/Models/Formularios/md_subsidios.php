<?php namespace App\Models\Formularios;

	use CodeIgniter\Model;

	class Md_subsidios extends Model {
		protected $table = 'subsidios';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'id_socio', 'numero_decreto', 'fecha_decreto', 'fecha_caducidad', 'id_porcentaje', 'fecha_encuesta', 'puntaje', 'numero_unico', 'digito_unico', 'id_usuario', 'fecha', 'estado', 'id_apr'];

	    public function datatable_subsidios($db, $id_apr) {
	    	$consulta = "SELECT 
							s.id as id_subsidio,
						    s.id_socio,
						    concat(so.rut, ' ', so.dv) as rut_socio,
						    so.rol as rol_socio,
						    concat(so.nombres, ' ', so.ape_pat, ' ', so.ape_mat) as nombre_socio,
						    s.numero_decreto as n_decreto,
						    date_format(s.fecha_decreto, '%d-%m-%Y') as fecha_decreto,
						    date_format(s.fecha_caducidad, '%d-%m-%Y') as fecha_caducidad,
						    s.id_porcentaje,
						    p.glosa as porcentaje,
						    date_format(s.fecha_encuesta, '%d-%m-%Y') as fecha_encuesta,
						    s.puntaje,
						    s.numero_unico as n_unico,
						    s.digito_unico as d_unico,
						    u.usuario,
						    date_format(s.fecha, '%d-%m-%Y %H:%i') as fecha
						FROM 
							subsidios s
						    inner join socios so on s.id_socio = so.id
						    inner join porcentajes p on s.id_porcentaje = p.id
						    inner join usuarios u on s.id_usuario = u.id
						    inner join apr on s.id_apr = apr.id
						where
							s.estado = 1 and
						    s.id_apr = $id_apr";


			$query = $db->query($consulta);
			$subsidios = $query->getResultArray();

			foreach ($subsidios as $key) {
				$row = array(
					"id_subsidio" => $key["id_subsidio"],
					"id_socio" => $key["id_socio"],
					"rut_socio" => $key["rut_socio"],
					"rol_socio" => $key["rol_socio"],
					"nombre_socio" => $key["nombre_socio"],
					"n_decreto" => $key["n_decreto"],
					"fecha_decreto" => $key["fecha_decreto"],
					"fecha_caducidad" => $key["fecha_caducidad"],
					"id_porcentaje" => $key["id_porcentaje"],
					"porcentaje" => $key["porcentaje"],
					"fecha_encuesta" => $key["fecha_encuesta"],
					"puntaje" => $key["puntaje"],
					"n_unico" => $key["n_unico"],
					"d_unico" => $key["d_unico"],
					"usuario" => $key["usuario"],
					"fecha" => $key["fecha"],
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

		public function datatable_subsidio_reciclar($db, $id_apr) {
	    	$consulta = "SELECT 
							s.id as id_subsidio,
						    concat(so.nombres, ' ', so.ape_pat, ' ', so.ape_mat) as nombre_socio,
						    s.numero_decreto as n_decreto,
						    date_format(s.fecha_decreto, '%d-%m-%Y') as fecha_decreto,
							p.glosa as porcentaje,
						    u.usuario,
						    date_format(s.fecha, '%d-%m-%Y %H:%i') as fecha
						FROM 
							subsidios s
						    inner join socios so on s.id_socio = so.id
						    inner join porcentajes p on s.id_porcentaje = p.id
						    inner join usuarios u on s.id_usuario = u.id
						    inner join apr on s.id_apr = apr.id
						where
							s.estado = 0 and
						    s.id_apr = $id_apr";


			$query = $db->query($consulta);
			$arranques = $query->getResultArray();

			foreach ($arranques as $key) {
				$row = array(
					"id_subsidio" => $key["id_subsidio"],
					"nombre_socio" => $key["nombre_socio"],
					"n_decreto" => $key["n_decreto"],
					"fecha_decreto" => $key["fecha_decreto"],
					"porcentaje" => $key["porcentaje"],
					"usuario" => $key["usuario"],
					"fecha" => $key["fecha"]
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

	    public function datatable_buscar_socio($db, $id_apr) {
	    	$consulta = "SELECT 
							s.id as id_socio,
							concat(s.rut, '-', s.dv) as rut,
							s.rol,
							concat(s.nombres, ' ', s.ape_pat, ' ', s.ape_mat) as nombre,
							date_format(s.fecha_entrada, '%d-%m-%Y') as fecha_entrada
						from 
							subsidios sub
							right join socios s on sub.id_socio = s.id
						where 
							sub.id_socio is null and
    						s.id_apr = $id_apr and
    						s.estado = 1";


			$query = $db->query($consulta);
			$subsidios = $query->getResultArray();

			foreach ($subsidios as $key) {
				$row = array(
					"id_socio" => $key["id_socio"],
					"rut" => $key["rut"],
					"rol" => $key["rol"],
					"nombre" => $key["nombre"],
					"fecha_entrada" => $key["fecha_entrada"]
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