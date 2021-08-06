<?php
	namespace App\Model\Table;

	use App\Model\Entity\Module;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class ModulesTable extends Table
	{
		public function initialize(array $config)
	    {
	        parent::initialize($config);

	        //Nombre de la Tabla
	        $this->setTable('Modules');
	        $this->setDisplayField('Name');

	        //Clave primaria
	        $this->setPrimaryKey('Id');

	        $this->addBehavior('Timestamp');

	        //Relacion 1:N con la tabla SubModules
	        $this->hasMany('SubModules', [
	        	'foreignKey' => 'ModuleId'
        	]);

        	
	        
	    }
	}
?>