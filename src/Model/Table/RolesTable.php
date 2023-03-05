<?php
	namespace App\Model\Table;

	use App\Model\Entity\Rol;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class RolesTable extends Table
	{
		public function initialize(array $config):void
	    {
	        parent::initialize($config);

	        //Nombre de la Tabla
	        $this->setTable('Roles');
	        $this->setDisplayField('Name');

	        //Clave primaria
	        $this->setPrimaryKey('Id');

	        $this->addBehavior('Timestamp');

        	//Relacion 1:n con la tabla UserRols
	        $this->hasMany('UserRols', [
	        	'foreignKey' => 'RolId',
        	]);

	        //Relacion 1:n con la tabla ActionsRols
	        $this->hasMany('ActionsRols', [
	        	'foreignKey' => 'RolId',
        	]);

	    }
	}
?>