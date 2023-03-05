<?php
	namespace App\Model\Table;

	use App\Model\Entity\Action;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class ActionsTable extends Table
	{
		public function initialize(array $config):void
	    {
	        parent::initialize($config);

	        //Nombre de la Tabla
	        $this->setTable('Actions');
	        $this->setDisplayField('Name');

	        //Clave primaria
	        $this->setPrimaryKey('Id');

	        $this->addBehavior('Timestamp');

	        //Relacion N:1 con la tabla ActionsRols
	        $this->hasMany('ActionsRols', [
	        	'foreignKey' => 'AccessId'
        	]);

        	//Relacion N:1 con la tabla SubModules
	        $this->belongsTo('SubModules', [
	        	'foreignKey' => 'SubModuled',
	        	'joinType' => 'INNER',
        	]);
	        
	    }
	}
?>