<?php
namespace App\Model\Table;
use App\Model\Entity\UserRol;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UserLessonsTable extends Table
{
	public function initialize(array $config):void
	{
		parent::initialize($config);

		// Nombre de la Tabla
		$this->setTable('UserLessons');
		$this->setDisplayField('Name');

		// Clave primaria
		$this->setPrimaryKey('Id');

		$this->addBehavior('Timestamp');

		// Relacion 1:n con la tabla Users
		$this->belongsTo('Users', [
			'foreignKey' => 'UserId',
			'type' => 'INNER'
		]);

		// Relacion 1:n con la tabla Lessons
		$this->belongsTo('Lessons', [
			'foreignKey' => 'LessonId',
			'type' => 'INNER'
		]);
	}
}
?>