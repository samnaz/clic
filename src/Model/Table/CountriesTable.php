<?php
	namespace App\Model\Table;

	use App\Model\Entity\Country;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class CountriesTable extends Table{
		public function initialize(array $config):void{
                    
	        parent::initialize($config);

	        //Nombre de la tabla
	        $this->setTable('Countries');
	        $this->setDisplayField('Name');

	        //Clave primaria
	        $this->setPrimaryKey('Id');
                
                //Relacion 1:N con la tabla Users
	        $this->hasMany('Users', [
	        	'foreignKey' => 'CountryId'
        	]);
	    }
	}
?>