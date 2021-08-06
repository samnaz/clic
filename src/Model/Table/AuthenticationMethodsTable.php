<?php
	namespace App\Model\Table;

	use App\Model\Entity\AuthenticationMethod;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class AuthenticationMethodsTable extends Table
	{
		public function initialize(array $config)
	    {
	        parent::initialize($config);

	        //Nombre de la tabla
	        $this->setTable('AuthenticationMethodsTable');
	        $this->setDisplayField('Name');

	        //Clave primaria
	        $this->setPrimaryKey('Id');

	        $this->addBehavior('Timestamp');

	        //Relacion N:1 con la tabla Users
	        $this->belongsTo('Users', [
	        	'foreignKey' => 'AuthenticationMethodId',
                        'joinType' => 'INNER',
        	]);
        }	
	        
             
	}
?>