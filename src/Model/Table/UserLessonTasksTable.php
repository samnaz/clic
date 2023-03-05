<?php
namespace App\Model\Table;
use App\Model\Entity\UserRol;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UserLessonTasksTable extends Table
{
	public function initialize(array $config):void:void
	{
		parent::initialize($config);

		// Nombre de la Tabla
		$this->setTable('UserLessonTasks');
		$this->setDisplayField('Description');

		// Clave primaria
		$this->setPrimaryKey('Id');
		$this->addBehavior('Timestamp');

		// Relacion 1:n con la tabla Users
		$this->belongsTo('Users', [
			'foreignKey' => 'UserId',
			'type' => 'INNER'
		]);

		// Relacion 1:n con la tabla Lessons
		$this->belongsTo('LessonTasks', [
			'foreignKey' => 'TaskId',
			'type' => 'INNER'
		]);
	}
}
?>