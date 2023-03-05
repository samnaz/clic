<?php
	namespace App\Model\Table;

	use App\Model\Entity\Access;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class AccessTable extends Table
	{
		public function initialize(array $config):void
	    {
	        parent::initialize($config);

	        //Nombre de la Tabla
	        $this->setTable('Access');
	        $this->setDisplayField('Name');

	        //Clave primaria
	        $this->setPrimaryKey('Id');

	        $this->addBehavior('Timestamp');

	        //Relacion 1:N con la tabla Users
	        $this->hasMany('Users', [
	        	'foreignKey' => 'AccessId'
        	]);
	        
	    }
	}
?>