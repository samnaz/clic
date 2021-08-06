<?php
namespace App\Model\Table;
use App\Model\Entity\UserRol;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class LessonChatsTable extends Table
{
	public function initialize(array $config):void
	{
		parent::initialize($config);

		// Nombre de la Tabla
		$this->setTable('LessonChats');
		$this->setDisplayField('Description');

		// Clave primaria
		$this->setPrimaryKey('Id');
		$this->addBehavior('Timestamp');

		// Relacion 1:n con la tabla Lessons
		$this->belongsTo('Lessons', [
			'foreignKey' => 'LessonId',
			'type' => 'INNER'
		]);

        // Relacion 1:n con la tabla user
		$this->belongsTo('Users', [
			'foreignKey' => 'UserId',
			'type' => 'INNER'
		]);
	}
}
?>