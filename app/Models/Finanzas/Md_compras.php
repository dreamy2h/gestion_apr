<?php namespace App\Models\Finanzas;

	use CodeIgniter\Model;

	class Md_compras extends Model {
		protected $table = 'compras';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'id_tipo_documento', 'n_documento', 'fecha_documento', 'neto', 'iva', 'total', 'id_proveedor', 'id_egreso'];

	    public function datos_compra($db, $id_egreso) {
	    	$consulta = "SELECT
							c.id as id_compra,
						    c.id_tipo_documento,
						    c.n_documento,
						    date_format(c.fecha_documento, '%d-%m-%Y') as fecha_documento,
						    c.neto,
						    c.iva,
						    c.total,
						    c.id_proveedor,
						    concat(p.rut, '-', p.dv) as rut_proveedor,
						    p.razon_social
						from 
							compras c
						    inner join proveedores p on c.id_proveedor = p.id
						where 
							c.id_egreso = ?";


			$query = $db->query($consulta, [$id_egreso]);
			$data = $query->getResultArray();

			return json_encode($data);
	    }
	}
?>