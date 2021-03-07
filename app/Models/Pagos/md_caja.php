<?php namespace App\Models\Pagos;

	use CodeIgniter\Model;

	class md_caja extends Model {
		protected $table = 'caja';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'total_pagar', 'entregado', 'vuelto', 'id_socio', 'estado', 'id_usuario', 'fecha', 'id_apr'];
	}
?>