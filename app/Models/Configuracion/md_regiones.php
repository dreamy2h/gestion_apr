<?php namespace App\Models\Configuracion;

	use CodeIgniter\Model;

	class md_regiones extends Model {
		protected $table = 'regiones';
	    protected $primaryKey = 'id';

	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id', 'nombre'];
	}
?>