<?php namespace App\Models\Configuracion;

	use CodeIgniter\Model;

	class Md_permisos_usuario extends Model {
		protected $table = 'permisos_usuario';
	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id_usuario', 'id_permiso', 'estado', 'usuario', 'fecha'];

	    public function permisos_usuario($db, $id_usuario) {
	    	define("ACTIVO", 1);
	    	$estado = ACTIVO;

	    	$consulta = "SELECT 
							pe.id as id_grupo,
							pe.nombre as grupo,
							pe.icono as icono_grupo,
							pe.collapse,
						    pd.nombre as permiso,
						    pd.ruta,
						    pd.div_id,
						    pd.icono
						from 
							permisos_usuario pu
						    inner join permisos_detalle pd on pu.id_permiso = pd.id
						    inner join permisos_enc pe on pd.id_grupo = pe.id
						where 
							pu.estado = ? and
						    pu.id_usuario = ?";


			$query = $db->query($consulta, [$estado, $id_usuario]);
			$permisos_usuario = $query->getResultArray();

			foreach ($permisos_usuario as $key) {
				$row = array(
					"id_grupo" => $key["id_grupo"],
					"grupo" => $key["grupo"],
					"icono_grupo" => $key["icono_grupo"],
					"collapse" => $key["collapse"],
					"permiso" => $key["permiso"],
					"ruta" => $key["ruta"],
					"div_id" => $key["div_id"],
					"icono" => $key["icono"]
				);

				$data[] = $row;
			}

			if (isset($data)) {
				return json_encode($data);
			} else {
				return "[]";
			}
	    }
	}
?>