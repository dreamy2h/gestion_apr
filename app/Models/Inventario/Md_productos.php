<?php namespace App\Models\Inventario;

	use CodeIgniter\Model;

	class Md_productos extends Model {
		protected $table = 'productos';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'nombre', 'marca', 'modelo', 'estado', 'id_usuario', 'fecha','id_apr'];

	    public function datatable_productos($db, $id_apr) {
	    	define("ACTIVO", 1);
	    	$estado = ACTIVO;

	    	$consulta = "SELECT 
							p.id as id_producto,
						    p.nombre,
						    p.marca,
						    p.modelo,
						    (select count(*) from productos_detalles pd where pd.id_producto = p.id and IFNULL(pd.id_estado, -1) != 0) as cantidad,
						    case when p.estado = 1 then 'Activado' else 'Desactivado' end as estado,
						    u.usuario,
						    date_format(p.fecha, '%d-%m-%Y') as fecha
						from 
							productos p
						    inner join usuarios u on p.id_usuario = u.id
						where 
						    p.id_apr = ?";


			$query = $db->query($consulta, [$id_apr]);
			$productos = $query->getResultArray();

			foreach ($productos as $key) {
				$row = array(
					"id_producto" => $key["id_producto"],
					"nombre" => $key["nombre"],
					"marca" => $key["marca"],
					"modelo" => $key["modelo"],
					"cantidad" => $key["cantidad"],
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

	  //   public function datatable_estados_producto_reciclar($db, $id_apr) {
	  //   	define("DESACTIVADO", 0);
	  //   	$estado = DESACTIVADO;

	  //   	$consulta = "SELECT 
			// 				m.id as id_estado,
   //                          m.estado_producto as estado
			// 			from 
			// 				estados_producto m
			// 			where
			// 				m.id_apr = ? and
			// 				m.estado = ?";

			// $query = $db->query($consulta, [$id_apr, $estado]);
			// $estados_producto = $query->getResultArray();

			// foreach ($estados_producto as $key) {
			// 	$row = array(
			// 		"id_estado" => $key["id_estado"],
			// 		"estado" => $key["estado"]
			// 	);

			// 	$data[] = $row;
			// }

			// if (isset($data)) {
			// 	$salida = array("data" => $data);
			// 	return json_encode($salida);
			// } else {
			// 	return "{ \"data\": [] }";
			// }
		// }
	}
?>