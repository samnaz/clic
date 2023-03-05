<?php
namespace App\Model\Table;
use App\Model\Entity\Rol;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class BooksTable extends Table
{
	public function initialize(array $config):void:void
	{
		parent::initialize($config);

		//Nombre de la Tabla
		$this->setTable('Books');
		$this->setDisplayField('Name');

		//Clave primaria
		$this->setPrimaryKey('Id');

		$this->addBehavior('Timestamp');

		//Relacion 1:n con la tabla UserRols
		$this->hasMany('Lessons', [
			'foreignKey' => 'LessonId',
		]);

	}
}
?>