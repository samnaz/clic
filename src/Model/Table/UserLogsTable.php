<?php
	namespace App\Model\Table;

	use App\Model\Entity\UserLog;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class UserLogsTable extends Table
	{
		public function initialize(array $config):void
	    {
	        parent::initialize($config);

	        //Nombre de la Tabla
	        $this->setTable('UserLogs');
	        $this->setDisplayField('Action');

	        //Clave primaria
	        $this->setPrimaryKey('Id');

	        $this->addBehavior('Timestamp');

	        //Relacion N:1 con la tabla Users
	        $this->belongsTo('Users', [
	        	'foreignKey' => 'UserId',
                        'joinType' => 'INNER',
        	]);
	        
	    }
	}
?>