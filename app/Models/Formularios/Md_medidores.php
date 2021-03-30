<?php namespace App\Models\Formularios;

	use CodeIgniter\Model;

	class Md_medidores extends Model {
		protected $table = 'medidores';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'numero', 'id_diametro', 	'estado', 'id_usuario', 'fecha', 'id_apr'];

	    public function datatable_medidores($db, $id_apr) {
	    	$consulta = "SELECT 
							m.id as id_medidor,
						    m.numero,
						    m.id_diametro,
						    d.glosa as diametro,
						    IFNULL(ELT(FIELD(m.estado, 0, 1), 'Eliminado', 'Activo'),'Sin registro') as estado,
						    u.usuario,
						    date_format(m.fecha, '%d-%m-%Y %H:%m') as fecha
						from 
							medidores m
						    inner join diametro d on m.id_diametro = d.id
						    inner join usuarios u on m.id_usuario = u.id
						where
							m.estado = 1 and
						    m.id_apr = $id_apr";


			$query = $db->query($consulta);
			$medidores = $query->getResultArray();

			foreach ($medidores as $key) {
				$row = array(
					"id_medidor" => $key["id_medidor"],
					"numero" => $key["numero"],
					"id_diametro" => $key["id_diametro"],
					"diametro" => $key["diametro"],
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
				return "{ \"data\": [] }";
			}
	    }

		public function datatable_medidor_reciclar($db, $id_apr) {
	    	$consulta = "SELECT 
							m.id as id_medidor,
						    m.numero,
						    m.id_diametro,
						    d.glosa as diametro,
						    IFNULL(ELT(FIELD(m.estado, 0, 1), 'Eliminado', 'Activo'),'Sin registro') as estado,
						    u.usuario,
						    date_format(m.fecha, '%d-%m-%Y %H:%m') as fecha
						from 
							medidores m
						    inner join diametro d on m.id_diametro = d.id
						    inner join usuarios u on m.id_usuario = u.id
						where
							m.estado = 0 and
						    m.id_apr = $id_apr";


			$query = $db->query($consulta);
			$medidores = $query->getResultArray();

			foreach ($medidores as $key) {
				$row = array(
					"id_medidor" => $key["id_medidor"],
					"numero" => $key["numero"],
					"id_diametro" => $key["id_diametro"],
					"diametro" => $key["diametro"],
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
				return "{ \"data\": [] }";
			}
	    }

	    public function llenar_cmb_medidores($db, $id_apr) {
	    	$consulta = "SELECT 
							id,
						    numero
						from 
							medidores
						where
							id NOT IN(select id_medidor from arranques where id_medidor is not null and id_apr = $id_apr and estado = 1) and
						    id_apr = $id_apr and
						    estado = 1";


			$query = $db->query($consulta);
			$medidores = $query->getResultArray();

			foreach ($medidores as $key) {
				$row = array(
					"value" => $key["id"],
					"text" => $key["numero"]
				);

				$data[] = $row;
			}

			return json_encode($data);
	    }
	}
?>