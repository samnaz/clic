<?php
	namespace App\Model\Table;

	use App\Model\Entity\State;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class StatesTable extends Table
	{
		public function initialize(array $config)
	    {
	        parent::initialize($config);

	        // Nombre de la Tabla
	        $this->setTable('States');
	        $this->setDisplayField('Name');

	        // Clave primaria
	        $this->setPrimaryKey('Id');

	        $this->addBehavior('Timestamp');
	        
			// Relacion N:1 con la tabla country
	        $this->belongsTo('Countries', [
	        	'foreignKey' => 'CountryId',
                        'joinType' => 'INNER',
        	]);
	    }
	}
?>