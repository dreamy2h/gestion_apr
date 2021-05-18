<?php namespace App\Models\Finanzas;

	use CodeIgniter\Model;

	class Md_ingresos extends Model {
		protected $table = 'ingresos';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'monto', 'fecha_ingreso', 'id_tipo_ingreso', 'tipo_entidad', 'id_entidad', 'id_motivo', 'observaciones', 'id_usuario', 'fecha', 'estado', 'id_apr'];

	    public function datatable_ingresos($db, $id_apr) {
	    	define("ACTIVO", 1);
	    	$estado = ACTIVO;

	    	$consulta = "SELECT 
							i.id as id_ingreso,
						    i.monto,
						    date_format(i.fecha_ingreso, '%d-%m-%Y') as fecha_ingreso,
                            i.id_tipo_ingreso,
                            ti.tipo_ingreso,
                            i.tipo_entidad,
                            i.id_entidad,
                            CASE
								WHEN i.tipo_entidad = 'Funcionario' THEN (select concat(f.rut, '-', f.dv) as rut_funcionario from funcionarios f where f.id = i.id_entidad)
								WHEN i.tipo_entidad = 'Proveedor' THEN (select concat(p.rut, '-', p.dv) as rut_proveedor from proveedores p where p.id = i.id_entidad)
                                WHEN i.tipo_entidad = 'Socio' THEN (select concat(s.rut, '-', s.dv) as rut_socio from socios s where s.id = i.id_entidad)
								ELSE 'No Registrado'
							END as rut_entidad,
                            CASE
								WHEN i.tipo_entidad = 'Funcionario' THEN (select concat(f.nombres, ' ', f.ape_pat, ' ', f.ape_mat) as funcionario from funcionarios f where f.id = i.id_entidad)
								WHEN i.tipo_entidad = 'Proveedor' THEN (select p.razon_social from proveedores p where p.id = i.id_entidad)
                                WHEN i.tipo_entidad = 'Socio' THEN ((select concat(s.nombres, ' ', s.ape_pat, ' ', s.ape_mat) as socio from socios s where s.id = i.id_entidad))
								ELSE 'No Registrado'
							END as nombre_entidad,
						    i.id_motivo,
						    m.motivo,
						    i.observaciones,
						    u.usuario,
						    date_format(i.fecha, '%d-%m-%Y %H:%i') as fecha
						from 
							ingresos i
                            inner join tipos_ingreso ti on i.id_tipo_ingreso = ti.id
						    inner join motivos m on i.id_motivo = m.id
						    inner join usuarios u on i.id_usuario = u.id
						where
							i.id_apr = $id_apr and
						    i.estado = $estado";


			$query = $db->query($consulta, [$id_apr, $estado]);
			$ingresos = $query->getResultArray();

			foreach ($ingresos as $key) {
				$row = array(
					"id_ingreso" => $key["id_ingreso"],
					"monto" => $key["monto"],
					"fecha_ingreso" => $key["fecha_ingreso"],
					"id_tipo_ingreso" => $key["id_tipo_ingreso"],
					"tipo_ingreso" => $key["tipo_ingreso"],
					"tipo_entidad" => $key["tipo_entidad"],
					"id_entidad" => $key["id_entidad"],
					"rut_entidad" => $key["rut_entidad"],
					"nombre_entidad" => $key["nombre_entidad"],
					"id_motivo" => $key["id_motivo"],
					"motivo" => $key["motivo"],
					"observaciones" => $key["observaciones"],
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
	}
?>