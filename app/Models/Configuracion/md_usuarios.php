<?php namespace App\Models\Configuracion;

	use CodeIgniter\Model;

	class md_usuarios extends Model {
		protected $table = 'usuarios';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'usuario', 'clave', 'id_apr', 'nombres', 'ape_paterno', 'ape_materno', 'calle', 'numero', 'resto_direccion', 'id_comuna', 'estado', 'id_usuario', 'fecha'];

	    public function existe_usuario($usu_cod) {
	    	$this->select("count(*) as filas");
	    	$this->where("usu_cod", $usu_cod);
	    	$datos = $this->findAll();
	    	return $datos;	
	    }

	    public function datatable_usuarios($db) {
	    	define("ACTIVO", 1);
			$estado = ACTIVO;
		
			$consulta = "SELECT 
							u.id as id_usuario,
						    u.usuario,
						    u.id_apr,
						    apr.nombre as apr,
						    u.nombres,
						    u.ape_paterno,
						    u.ape_materno,
						    concat(u.nombres, ' ', u.ape_paterno, ' ', u.ape_materno) as nombre_usuario,
						    p.id_region,
						    c.id_provincia,
						    u.id_comuna,
						    c.nombre as comuna,
						    u.calle,
						    u.numero,
						    u.resto_direccion,
						    u.estado as id_estado,
						    IFNULL(ELT(FIELD(u.estado, 0, 1, 2), 'Pendiente','Activo', 'Bloqueado'),'Sin registro') as estado,
						    usu.usuario as usuario_reg,
						    date_format(u.fecha, '%d-%m-%Y') as fecha
						from 
							usuarios u
						    inner join apr on apr.id = u.id_apr
						    left join comunas c on c.id = u.id_comuna
						    left join provincias p on p.id = c.id_provincia
						    inner join usuarios usu on usu.id = u.id_usuario";


			$query = $db->query($consulta);
			$usuarios = $query->getResultArray();

			foreach ($usuarios as $key) {
				$row = array(
					"id_usuario" => $key["id_usuario"],
					"usuario" => $key["usuario"],
					"id_apr" => $key["id_apr"],
					"apr" => $key["apr"],
					"nombres" => $key["nombres"],
					"ape_paterno" => $key["ape_paterno"],
					"ape_materno" => $key["ape_materno"],
					"nombre_usuario" => $key["nombre_usuario"],
					"id_region" => $key["id_region"],
					"id_provincia" => $key["id_provincia"],
					"id_comuna" => $key["id_comuna"],
					"comuna" => $key["comuna"],
					"calle" => $key["calle"],
					"numero" => $key["numero"],
					"resto_direccion" => $key["resto_direccion"],
					"id_estado" => $key["id_estado"],
					"estado" => $key["estado"],
					"usuario_reg" => $key["usuario_reg"],
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
	    
	}
?>