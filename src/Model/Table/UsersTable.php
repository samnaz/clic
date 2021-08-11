<?php
	namespace App\Model\Table;

	use App\Model\Entity\User;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;
    use Burzum\FileStorage\Model\Table\ImageStorageTable;//Usado para plugin de amazon S3

	class UsersTable extends Table
	{
		public function initialize(array $config)
	    {
	        parent::initialize($config);

	        //Nombre de la tabla
	        $this->setTable('Users');
	        $this->setDisplayField('Name');

	        //Clave primaria
	        $this->setPrimaryKey('Id');

	        $this->addBehavior('Timestamp');
        	
	        //Relacion 1:N con la tabla AuthenticationMethods
	        $this->hasMany('AuthenticationMethods',[
	        	'foreignKey' => 'AuthenticationMethodId'
        	]);


	        //Relacion 1:N con la tabla UserStatus
	        $this->hasMany('UserStatus', [
				'foreignKey' => 'UserStatusId'
        	]);

	        //Relacion N:1 con la tabla Countries
	        $this->belongsTo('Countries', [
	        	'foreignKey' => 'CountryId',
                        'joinType' => 'INNER',
        	]);                
            
        	//Relacion 1:n con la tabla UserRols
	        $this->hasMany('UserRols', [
	        	'foreignKey' => 'UserId',
        	]);
			
			/*$this->belongsToMany('Users', [
				'through' => 'UserRols',
			]);*/
			
			$this->belongsToMany('Roles', [
				'through' => 'UserRols',
			]);	        
        	
        	//Relacion 1:n con la tabla UserLogs
	        $this->hasMany('UserLogs', [
	        	'foreignKey' => 'UserId',
        	]);

			//Relacion 1:n con la tabla UserLessonTasks
	        $this->hasMany('UserLessonTasks', [
	        	'foreignKey' => 'UserId',
        	]);
	    }

	    public function validationDefault(Validator $validator)
	    {
	        $validator
	            ->add('id', 'valid', ['rule' => 'numeric'])
	            ->allowEmpty('id', 'create');

            $validator
            	->notEmpty('Name', 'The file Name is required.')
            	->notEmpty('LastName', 'The file LastName is required.');

	        $validator
	            ->add('Email', 'valid', ['rule' => 'email'])
	            ->requirePresence('email', 'create')
	            ->notEmpty('email');

	        $validator
	            ->requirePresence('password', 'create')
	            ->notEmpty('password');

	        $validator
	            ->add('Username',        
        					'unique', [
	          					'rule'=>'isUnique', //usuario debe ser unico
	          					'provider' => 'table',
	          					'message' => __('The Username already exists')],
				       'Email', 
				       		'unique', [
				    			'rule' => 'isUnique',  //El email debe ser unico
				    			'provider' => 'table',
				    			'message' => __('The Email already exists')]
				    );

	        return $validator;
	    }
		
		public function findAuth(\Cake\ORM\Query $query, array $options)
		{
			/*
			select 'Id', 'Name', 'LastName', 'Password'
					from Users inner join
				UserRols 'UserRols'on UserRols.UserId = Users.id
				inner join ActionsRols ActionsRolson ActionsRols.RolId = UserRols.RolId
				where Users.UserStatusId = 1 and ActionId = 34;
			*/
			
			$query
				->select(['Id', 'Name', 'LastName', 'Password'])
					->join([
				'UserRols' => [
					'table' => 'UserRols',
					'type' => 'inner',
					'conditions' => 'UserRols.UserId = Users.id'
				],
				'ActionsRols' => [
					'table' => 'ActionsRols',
					'type' => 'inner',
					'conditions' => 'ActionsRols.RolId = UserRols.RolId'
				]
			])->where(['Users.UserStatusId' => 1 /*,'ActionId' => 34*/]); // Action.Id = 34 es login admin /*,'ActionId' => 34*/
                        
			return $query;
		}
        
        public function uploadImage($userId, $entity) {
        $entity = $this->patchEntity($entity, [
            'adapter' => 'Local',
            'model' => 'Users',
            'foreign_key' => $userId
        ]);
        return $this->save($entity);
    }
        
        
	}
?>