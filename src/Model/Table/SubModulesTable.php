<?php
	namespace App\Model\Table;

	use App\Model\Entity\SubModule;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class SubModulesTable extends Table
	{
		public function initialize(array $config):void
	    {
	        parent::initialize($config);

	        //Nombre de la Tabla
	        $this->setTable('SubModules');
	        $this->setDisplayField('Name');

	        //Clave primaria
	        $this->setPrimaryKey('Id');

	        $this->addBehavior('Timestamp');

	        //Relacion N:1 con la tabla Permissions
	        $this->belongsTo('Modules', [
	        	'foreignKey' => 'ModuleId',
	        	'joinType' => 'INNER',
        	]);
	        
	        //Relacion 1:N con la tabla Users
	        $this->hasMany('Actions', [
	        	'foreignKey' => 'SubModuled'
        	]);
	    }
	}
?>