<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;

class ConfirmController extends AppController
{
    public function index(){
		if ($this->request->query('t') !='' && $this->request->query('seed')!=''){
			$connection = ConnectionManager::get('default');
			$sql = "update Users set UserStatusId=1 WHERE (Id = ". $this->request->query('t') ." AND UserStatusId = 3)";
			$r = $connection->execute($sql)->count();			
			
			// Si el usuario no existe
			if($r==0){
				$this->Flash->error("Usuario no activado. ");					
			}
			else{
				$this->Flash->error("Usuario activado. ");		
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
