<?php namespace App\Models\Formularios;

	use CodeIgniter\Model;

	class md_socios extends Model {
		protected $table = 'socios';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'rut', 'dv', 'rol', 'nombres', 'ape_pat', 'ape_mat', 'fecha_entrada', 'fecha_nacimiento', 'id_sexo', 'calle', 'numero', 'resto_direccion', 'id_comuna', 'estado', 'id_usuario', 'fecha', 'id_apr'];

	    public function datatable_socios($db, $id_apr) {
	    	$consulta = "SELECT 
							s.id as id_socio,
							concat(s.rut, '-', s.dv) as rut,
						    s.rol,
							s.nombres,
							s.ape_pat,
							s.ape_mat,
						    concat(s.nombres, ' ', s.ape_pat, ' ', s.ape_mat) as nombre_completo,
						    date_format(s.fecha_entrada, '%d-%m-%Y') as fecha_entrada,
						    date_format(s.fecha_nacimiento, '%d-%m-%Y') as fecha_nacimiento,
							s.id_sexo,
							p.id_region,
							c.id_provincia,
							s.id_comuna,
							c.nombre as comuna,
							s.calle,
							s.numero,
							s.resto_direccion,
							u.usuario,
							date_format(s.fecha, '%d-%m-%Y %H:%i:%s') as fecha
						from 
							socios s
							inner join usuarios u on u.id = s.id_usuario
							left join comunas c on c.id = s.id_comuna
							left join provincias p on p.id = c.id_provincia
						where
							s.id_apr = $id_apr";


			$query = $db->query($consulta);
			$socios = $query->getResultArray();

			foreach ($socios as $key) {
				$row = array(
					"id_socio" => $key["id_socio"],
					"rut" => $key["rut"],
					"rol" => $key["rol"],
					"nombres" => $key["nombres"],
					"ape_pat" => $key["ape_pat"],
					"ape_mat" => $key["ape_mat"],
					"nombre_completo" => $key["nombre_completo"],
					"fecha_entrada" => $key["fecha_entrada"],
					"fecha_nacimiento" => $key["fecha_nacimiento"],
					"id_sexo" => $key["id_sexo"],
					"id_region" => $key["id_region"],
					"id_provincia" => $key["id_provincia"],
					"id_comuna" => $key["id_comuna"],
					"comuna" => $key["comuna"],
					"calle" => $key["calle"],
					"numero" => $key["numero"],
					"resto_direccion" => $key["resto_direccion"],
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

	    public function existe_socio($rut, $rol) {
	    	$this->select("count(*) as filas");
	    	$this->where("rut", $rut);
	    	$this->where("rol", $rol);
	    	$datos = $this->first();
    	 	if (intval($datos["filas"]) > 0) {
    	 		return true;
    	 	} else {
    	 		return false;
    	 	}
	    }

	    public function datatable_informe_socios($db, $id_apr) {
	    	$consulta = "SELECT 
							s.id as id_socio,
						    concat(s.rut, '-', s.dv) as rut,
						    s.rol,
						    concat(s.nombres, ' ', s.ape_pat, ' ', s.ape_mat) as nombre_completo,
						    date_format(s.fecha_entrada, '%d-%m-%Y') as fecha_entrada,
						    date_format(s.fecha_nacimiento, '%d-%m-%Y') as fecha_nacimiento,
						    IFNULL(ELT(FIELD(s.id_sexo, 1, 2), 'Masculino','Femenino'), 'Sin registro') as sexo,
						    ifnull(s.calle, 'Sin registro') as calle,
						    ifnull(s.numero, 0) as numero,
						    ifnull(s.resto_direccion, 'Sin registro') as resto_direccion,
						    ifnull(c.nombre, 'Sin registro') as comuna,
						    IFNULL(ELT(FIELD(s.estado, 0, 1), 'Desactivado','Activado'), 'Sin registro') as estado
						FROM 
							socios s
						    left join comunas c on s.id_comuna = c.id
						where
							s.id_apr = ?";

			$query = $db->query($consulta, [$id_apr]);
			$socios = $query->getResultArray();

			foreach ($socios as $key) {
				$row = array(
					"id_socio" => $key["id_socio"],
					"rut" => $key["rut"],
					"rol" => $key["rol"],
					"nombre_completo" => $key["nombre_completo"],
					"fecha_entrada" => $key["fecha_entrada"],
					"fecha_nacimiento" => $key["fecha_nacimiento"],
					"sexo" => $key["sexo"],
					"calle" => $key["calle"],
					"numero" => $key["numero"],
					"resto_direccion" => $key["resto_direccion"],
					"comuna" => $key["comuna"],
					"estado" => $key["estado"]
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