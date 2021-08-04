<?php
	namespace App\Model\Table;

	use App\Model\Entity\ActionsRol;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class ActionsRolsTable extends Table
	{
		public function initialize(array $config)
	    {
	        parent::initialize($config);

	        //Nombre de la Tabla
	        $this->setTable('ActionsRols');
	        $this->setDisplayField('Name');

	        //Clave primaria
	        $this->setPrimaryKey('Id');

	        $this->addBehavior('Timestamp');

	        //Relacion N:1 con la tabla Roles
	        $this->belongsTo('Roles', [
	        	'foreignKey' => 'RolId',
	        	'joinType' => 'INNER',
        	]);
	        
	        //Relacion N:1 con la tabla Actions
	        $this->belongsTo('Actions', [
	        	'foreignKey' => 'ActionId',
	        	'joinType' => 'INNER',
        	]);
	    }
	}
?>