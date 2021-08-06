<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
 //use App\Model\Table\UsersTable $Usuarios;
/**
 * Path File: \App\Controller\LoginController.php
 * Usuarios Controller
 *
 * @property \App\Model\Table\UsersTable $Usuarios
 */
class LoginController extends AppController
{
    public function index(){
		// Login
        if ($this->request->is(['POST'])) {
            $user = $this->Auth->identify();

			// Si funciona
            if ($user){                
				// Verificar si tiene permiso de login admin
				/*$this->loadModel('UserRols');
				$data2 = $this->UserRols->find('all')
				->contain('ActionsRols')
				->where(['UserRols.UserId' => $user['Id']])
				->where(['Action.Id' => 34])
				->first();*/
				
				$connection = ConnectionManager::get('default');
				$sql = "SELECT UserId FROM UserRols U inner JOIN ActionsRols A ON A.RolId = U.RolId WHERE (UserId = ". $user['Id'] ." AND ActionId = 34)";
				$r = $connection->execute($sql)->count();			
				
				// Si el usuario no existe
				if($r==0){
					$this->Flash->error("Usuario no tiene permiso de ingresar al Admin. ");					
				}
				else{
					$this->Auth->setUser($user);
					$usersTable = TableRegistry::get('UserLogs');
					$user = $usersTable->newEntity();
					$user->UserId = $this->Auth->user('Id');
					$user->Action = 'Login Admin';
					$user->IpAddress = $this->request->clientIp();
					$user->Created = date('Y-m-d H:i:s');
					
					//Guardamos el usuario
					if ($usersTable->save($user)) {
						return $this->redirect('/Dashboard');
					}
				}
            }else { // user no identified
                $this->Flash->error("Usuario o Contraseña inválidos. Por favor intenta nuevamente. ");               
            }
        } 
    }

    public function logout(){
        //$this->Flash->success('You are now Logged Out.');
        return $this->redirect($this->Auth->logout());
    } 
}
