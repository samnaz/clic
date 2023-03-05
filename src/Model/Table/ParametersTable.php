<?php
	namespace App\Model\Table;

	use App\Model\Entity\Parameter;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class ParametersTable extends Table
	{
		public function initialize(array $config):void
	    {
	        parent::initialize($config);

	        // Nombre de la Tabla
	        $this->setTable('Parameters');
	        $this->setDisplayField('Value');

	        // Clave primaria
	        $this->setPrimaryKey('Id');

	        $this->addBehavior('Timestamp');
	        
	    }
	}
?>