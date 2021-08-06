<?php
namespace App\Model\Table;
use App\Model\Entity\UserRol;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class LessonTasksTable extends Table
{
	public function initialize(array $config):void
	{
		parent::initialize($config);

		// Nombre de la Tabla
		$this->setTable('LessonTasks');
		$this->setDisplayField('Description');

		// Clave primaria
		$this->setPrimaryKey('Id');
		$this->addBehavior('Timestamp');

		// Relacion 1:n con la tabla Lessons
		$this->belongsTo('Lessons', [
			'foreignKey' => 'LessonId',
			'type' => 'INNER'
		]);
	}
}
?>