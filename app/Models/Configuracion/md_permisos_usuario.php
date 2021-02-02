<?php namespace App\Models\Configuracion;

	use CodeIgniter\Model;

	class md_permisos_usuario extends Model {
		protected $table = 'permisos_usuario';
	    protected $returnType = 'array';
	    // protected $useSoftDeletes = true;

	    protected $allowedFields = ['id_usuario', 'id_permiso', 'estado', 'usuario', 'fecha'];
	}
?>