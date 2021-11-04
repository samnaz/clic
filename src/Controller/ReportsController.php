<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

class ReportsController extends AppController {
    // Report
    public function userlessons() {
        $userId = $this->Auth->user('Id');

        $pageTitle = "Progreso de Lecciones";

        $breadcrumbs = '<li>Reportes</li>
                        <li>Lecciones</li>
                        <li class="active">Progreso de Lecciones</li>';

		$this->set('pageTitle', $pageTitle);
		$this->set('_serialize', ['pageTitle']);
		$this->set('breadcrumbs', $breadcrumbs);
		$this->set('_serialize', ['breadcrumbs']);
		$this->set('userId', $userId);
		$this->set('_serialize', ['userId']); 
		
		// Rol
		$this->loadModel('UserRols');
	    $rols = $this->UserRols
			->find('all')
			->where(['UserRols.UserId' => $userId])
			->first();
		
		//Se importa el modelo roles, estos se van a mostrar en la vista con un checkbox
        $this->loadModel('UserLessons');
		
		// Pastor
		if ($rols['RolId']==3)
			$this->set('users', $this->UserLessons
				->find('list')->contain('Users')->where(['Users.UserId' => $userId])
				->select(['Name' => 'concat(UserId,\'-\', Users.Name,\' \', Users.LastName)', 'Id' => 'UserId'])->distinct(['Name', 'Id'])
				->order(['Users.Name' => 'ASC'])
			);
		else if ($rols['RolId']==2)// Triaris
			$this->set('users', $this->UserLessons
				->find('list')->contain('Users')->where(['Users.TeacherId' => $userId])
				->select(['Name' => 'concat(UserId,\'-\', Users.Name,\' \', Users.LastName)', 'Id' => 'UserId'])->distinct(['Name', 'Id'])
				->order(['Users.Name' => 'ASC'])
			);
		else
			$this->set('users', $this->UserLessons
				->find('list')->contain('Users')
				->select(['Name' => 'concat(UserId,\'-\', Users.Name,\' \', Users.LastName)', 'Id' => 'UserId'])->distinct(['Name', 'Id'])
				->order(['Users.Name' => 'ASC'])
			);
    }
	
	// Report
    public function usercoins() {
        $userId = $this->Auth->user('Id');

        $pageTitle = "Uso de Monedas";

        $breadcrumbs = '<li>Reportes</li>
                        <li>Lecciones</li>
                        <li class="active">Uso de Monedas</li>';

		$this->set('pageTitle', $pageTitle);
		$this->set('_serialize', ['pageTitle']);
		$this->set('breadcrumbs', $breadcrumbs);
		$this->set('_serialize', ['breadcrumbs']);
		$this->set('userId', $userId);
		$this->set('_serialize', ['userId']); 
		
		// Rol
		$this->loadModel('UserRols');
	    $rols = $this->UserRols
			->find('all')
			->where(['UserRols.UserId' => $userId])
			->first();
		
		//Se importa el modelo roles, estos se van a mostrar en la vista con un checkbox
        $this->loadModel('UserLessons');
		
		// Pastor
		if ($rols['RolId']==3)
			$this->set('users', $this->UserLessons
				->find('list')->contain('Users')->where(['Users.UserId' => $userId])
				->select(['Name' => 'concat(UserId,\'-\', Users.Name,\' \', Users.LastName)', 'Id' => 'UserId'])->distinct(['Name', 'Id'])
				->order(['Users.Name' => 'ASC'])
			);
		else if ($rols['RolId']==2)// Triaris
			$this->set('users', $this->UserLessons
				->find('list')->contain('Users')->where(['Users.TeacherId' => $userId])
				->select(['Name' => 'concat(UserId,\'-\', Users.Name,\' \', Users.LastName)', 'Id' => 'UserId'])->distinct(['Name', 'Id'])
				->order(['Users.Name' => 'ASC'])
			);
		else
			$this->set('users', $this->UserLessons
				->find('list')->contain('Users')
				->select(['Name' => 'concat(UserId,\'-\', Users.Name,\' \', Users.LastName)', 'Id' => 'UserId'])->distinct(['Name', 'Id'])
				->order(['Users.Name' => 'ASC'])
			);
    }
	
	// funcion para ver progreso
    public function getuserlessons($userId=NULL) {

        $this->loadModel('UserLessons');

        $connection = ConnectionManager::get('default');
		$s = "SELECT U.Id AS UserId,
				  U.Name AS `Name`,U.LastName,
				  U.Email AS `Email`,
				  B.Name AS `Book`,
				  L.Day as Lesson,
				  CONVERT_TZ(UL.Created,'+00:00','-04:00') as Created, LessonId
				FROM
				  Users U                                      
				  INNER JOIN UserLessons UL ON U.Id = UL.UserId
				  INNER JOIN Lessons L ON L.Id = LessonId
					inner join Books B on B.Id = BookId 
					where UL.UserId = $userId
				ORDER BY
				  UL.Created desc";
		//echo $s;
        $userlessons = $connection->execute($s)
                        ->fetchAll('assoc');

        $this->set('userlessons', $userlessons);
        $this->set('serialize', ['userlessons']);
    }
	
	// funcion para ver progreso-pag.
    public function getuserpages($userId=NULL, $lessonId = NULL) {

        $this->loadModel('UserPages');

        $connection = ConnectionManager::get('default');
		$s = "SELECT UL.Id, Points,TeacherPoints, TeacherReview,
				  B.Name AS `Book`,
				  L.Day as Lesson, 
				  CONVERT_TZ(UL.Created,'+00:00','-04:00') as Created, UL.Description, P.Description as Task, UserId
				FROM
				  Users U                                      
				  INNER JOIN UserLessonTasks UL ON U.Id = UL.UserId inner join LessonTasks P on P.Id = TaskId
				  INNER JOIN Lessons L ON L.Id = LessonId
					inner join Books B on B.Id = BookId 
					where UL.UserId = $userId and LessonId = $lessonId
				ORDER BY
				  UL.Created desc";
		//echo $s;
        $userpages = $connection->execute($s)
                        ->fetchAll('assoc');

        $this->set('userpages', $userpages);
        $this->set('serialize', ['userpages']);
    }
	
	// funcion para ver monedas gastadas
    public function getusercoins($userId=NULL) {

        $this->loadModel('UserPages');
		$connection = ConnectionManager::get('default');
		$s = "SELECT U.Id AS UserId,
				  U.Name AS `Name`,U.LastName, UL.`Coins`, `Category`,
				  CONVERT_TZ(UL.Created,'+00:00','-04:00') as Created
				  FROM `UserCoins` UL
				  INNER JOIN Users U                                      
				  ON U.Id = UL.UserId
				  where UL.UserId = $userId
				ORDER BY
				  UL.Created desc";

		//echo $s;
        $rpt = $connection->execute($s)
                        ->fetchAll('assoc');
        $this->set('rpt', $rpt);
        $this->set('serialize', ['rpt']);
    }
	
	// Funcion para editar
    public function addTeacherPoints() {
        // Validamos que la peticion sea de tipo POST
        if($this->request->is('POST')){
			$pId = $this->request->getData('Id');
			$this->loadModel('UserLessonTasks');
            $bTable = TableRegistry::get('UserLessonTasks');
            $brnd = $this->UserLessonTasks->get($pId);
			$brnd->TeacherPoints = $this->request->getData('TeacherPoints');
			$brnd->TeacherComments = $this->request->getData('TeacherComments');
			$brnd->TeacherReview = date('Y-m-d H:i:s');

            // Guardamos el registro
            if ($bTable->save($brnd)) {
				// Talentos
				$this->set('userpages', $brnd->Id);
            }
		}
    }
}
?>
