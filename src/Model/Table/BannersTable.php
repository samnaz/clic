<?php
	namespace App\Model\Table;

	use App\Model\Entity\Banner;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class BannersTable extends Table{
		public function initialize(array $config):void{
                    
	        parent::initialize($config);

	        //Nombre de la tabla
	        $this->setTable('Banners');
	        $this->setDisplayField('Title');

	        //Clave primaria
	        $this->setPrimaryKey('Id');               
               
	    }
	}
?>