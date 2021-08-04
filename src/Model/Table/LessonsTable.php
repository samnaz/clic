<?php
namespace App\Model\Table;
use App\Model\Entity\SubModule;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class LessonsTable extends Table
{
	public function initialize(array $config):void
	{
		parent::initialize($config);

		//Nombre de la Tabla
		$this->setTable('Lessons');
		$this->setDisplayField('Day');

		//Clave primaria
		$this->setPrimaryKey('Id');
		$this->addBehavior('Timestamp');

		//Relacion N:1 con la tabla Permissions
		$this->belongsTo('Books', [
			'foreignKey' => 'BookId',
			'joinType' => 'INNER',
		]);
		
		//Relacion 1:N con la tabla Users
		$this->hasMany('Pages', [
			'foreignKey' => 'LessonId'
		]);
		
		//Relacion 1:N con la tabla UserLessons
		$this->hasMany('UserLessons', [
			'foreignKey' => 'LessonId'
		]);
	}
	/*
	function beforeDelete(Event $event, EntityInterface $entity, ArrayObject $options) {
		$event->stopPropagation();
		$event->setResult(false);
        return;
	}*/
}
?>