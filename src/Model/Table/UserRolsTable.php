<?php
	namespace App\Model\Table;

	use App\Model\Entity\UserRol;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class UserRolsTable extends Table
	{
		public function initialize(array $config)
	    {
	        parent::initialize($config);

	        //Nombre de la Tabla
	        $this->setTable('UserRols');
	        $this->setDisplayField('Name');

	        //Clave primaria
	        $this->setPrimaryKey('Id');

	        $this->addBehavior('Timestamp');

        	//Relacion 1:n con la tabla Users
	        $this->belongsTo('Users', [
	        	'foreignKey' => 'UserId',
	        	'type' => 'INNER'
        	]);
			
			/*$this->belongsToMany('Users', [
				'through' => 'UserRols',
			]);*/

        	//Relacion 1:n con la tabla Roles
	        $this->belongsTo('Roles', [
	        	'foreignKey' => 'RolId',
	        	'type' => 'INNER'
        	]);
	    }
	}
?>