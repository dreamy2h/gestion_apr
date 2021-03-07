<?php namespace App\Models\Pagos;

	use CodeIgniter\Model;

	class md_caja_detalle extends Model {
		protected $table = 'caja_detalle';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'id_caja', 'id_metros'];
	}
?>