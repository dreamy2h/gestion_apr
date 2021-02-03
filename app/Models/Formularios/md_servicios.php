<?php namespace App\Models\Formularios;

	use CodeIgniter\Model;

	class md_servicios extends Model {
		protected $table = 'servicios';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'glosa', 'estado'];
	}
?>