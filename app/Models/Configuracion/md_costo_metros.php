<?php namespace App\Models\Configuracion;

	use CodeIgniter\Model;

	class md_costo_metros extends Model {
		protected $table = 'costo_metros';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'id_apr', 'desde', 'hasta', 'costo', 'estado', 'id_usuario', 'fecha'];

	    public function datatable_costo_metros($db, $id_apr) {
	    	$consulta = "SELECT 
							cm.id as id_costo_metros,
						    cm.id_apr,
						    apr.nombre as apr,
						    cm.desde,
							cm.hasta,
						    cm.costo,
						    u.usuario,
						    date_format(cm.fecha, '%d-%m-%Y %H:%i') as fecha
						from 
							costo_metros cm
						    inner join apr on cm.id_apr = apr.id
						    inner join usuarios u on cm.id_usuario = u.id
						where
							cm.id_apr = $id_apr and
						    cm.estado = 1";


			$query = $db->query($consulta);
			$costo_metros = $query->getResultArray();

			foreach ($costo_metros as $key) {
				$row = array(
					"id_costo_metros" => $key["id_costo_metros"],
					"id_apr" => $key["id_apr"],
					"apr" => $key["apr"],
					"desde" => $key["desde"],
					"hasta" => $key["hasta"],
					"costo" => $key["costo"],
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

	    public function validar_metraje_existente($db, $desde, $hasta, $id_apr, $id_costo_metros) {
	    	define("ACTIVO", 1);
	    	$estado = ACTIVO;

	    	$consulta = "SELECT 
							count(*) as filas
						from 
							costo_metros
						where 
							id_apr = ? and 
							estado = ? and
							(desde between ? and ? or
							hasta between ? and ? or
							?  between desde and hasta or
							?  between desde and hasta)";

			if ($id_costo_metros != "") {
				$consulta .= " and id <> ?";
			}
						    
			$bind = [$id_apr, $estado, $desde, $hasta, $desde, $hasta, $desde, $hasta];

			if ($id_costo_metros != "") {
				array_push($bind, $id_costo_metros);
			}

			$query = $db->query($consulta, $bind);
			$row = $query->getRow();
			$filas = $row->filas;

			if ($filas > 0) {
				return true;
			} else {
				return false;
			}
	    }

	    public function datatable_costo_metros_consumo($db, $id_apr, $consumo_actual) {
	    	$consulta = "SELECT 
							cm.id as id_costo_metros,
							cm.desde,
							cm.hasta,
							cm.costo
						from 
							costo_metros cm
							inner join apr on cm.id_apr = apr.id
							inner join usuarios u on cm.id_usuario = u.id
						where
							cm.id_apr = $id_apr and
							cm.estado = 1
						order by cm.desde asc";



			$query = $db->query($consulta);
			$costo_metros = $query->getResultArray();
			$resto;
			$metros;

			foreach ($costo_metros as $key) {
				$resto = ((intval($key["desde"]) - intval($key["desde"])) + 1);
				if ($resto > intval($consumo_actual)) {
					$metros = intval($consumo_actual);
					$consumo_actual = 0;
				} else {
					$metros = $resto;
					$consumo_actual = intval($consumo_actual) - $resto;
				}

				$row = array(
					"id_costo_metros" => $key["id_costo_metros"],
					"metros" => $metros,
					"desde" => $key["desde"],
					"hasta" => $key["hasta"],
					"costo" => $key["costo"],
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