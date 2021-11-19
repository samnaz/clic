<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;

class LoginadminController extends AppController
{
    public function index(){
		if ($this->request->query('id') !='' && $this->request->query('email')!='' && $this->request->query('userId')!=''){
			$connection = ConnectionManager::get('default');
			$sql = "SELECT U.UserId FROM UserRols U inner JOIN ActionsRols A ON A.RolId = U.RolId 
			inner join Users Us on Us.Id = U.UserId
			WHERE (Us.Id = ". $this->request->query('userId') ." AND ActionId = 34 and Email='". $this->request->query('email') ."')";
			$r = $connection->execute($sql)->count();			
				
			// Si el usuario no existe
			if($r==0){
				$this->Flash->error("Usuario no existe. ");					
			}
			else{
				$this->loadModel('Users');
       			$user = $this->Users->get($this->request->query('userId'));
				$this->Auth->setUser($user);
				return $this->redirect('/Dashboard');
			}
		}else{
				$this->Flash->error("Parámetros inválidos. ");		
		}
    }
	
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('index');
    }
	
}
