<?php namespace App\Models\Pagos;

	use CodeIgniter\Model;

	class md_caja_traza extends Model {
		protected $table = 'caja_traza';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'id_caja', 'estado', 'observacion', 'id_usuario', 'fecha'];
	}
?>