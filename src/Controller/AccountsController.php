<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

class AccountsController extends AppController {
   // public $components = ['Aws'];

    //Funcias para Visualizar la lista de uauarios
    public function listusers() {
        $userId = $this->Auth->user('Id');

        $pageTitle = "Listar Usuarios";

        $breadcrumbs = '<li>Control de Usuarios</li>
                        <li>Cuentas</li>
                        <li class="active">Listar Usuarios</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);

    }

    //Funcion para ver detalle de usuario
    public function viewuser($usersId = NULL) {

        $userId = $this->Auth->user('Id');
        $pageTitle = "Ver Usuarios";

        $breadcrumbs = '<li>Control de Usuarios</li>
                        <li>Cuentas</li>
                        <li><a href="../listusers" title="Listar Usuarios">Listar Usuarios</a></li>
                        <li class="active"><a href="/Accounts/viewuser/'.$usersId.'" title="Ver Usuario">Ver Usuario</a></li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);

        //De esta forma consultamos los datos del usuario seleccionado
        $this->loadModel('Users');
        $user = $this->Users->get($usersId);
        $brith = $user['BirthDate'];
        $brithdate = date("d-m-Y", strtotime($brith));
		$user->BirthDate =$brithdate;

        //Realizamos la consulta del pais asociado al usuario
        $country = $this->Users
                        ->find('all')
                        ->select(['Countries.Name'])
                        ->contain(['Countries'])
                        ->where(['Users.Id' => $usersId])
                        ->first();

        //Se importa el modelo roles, estos se van a mostrar en la vista con un checkbox
        $this->loadModel('Roles');
        $this->set('roles', $this->Roles
                        ->find('list')
                        ->where(['Roles.AppRol' => 0])
        );
        $this->set('rols', $this->Roles
                        ->find('list')
                        ->where(['Roles.AppRol' => 1])
        );

        //Importamos el Modelo UserRoles Para obtener el rol del usuario
        $this->loadModel('UserRols');
        $userRoles =  $this->UserRols
                        ->find('all')
                        ->where(['UserRols.UserId' => $usersId, 'Roles.AppRol' => 0])
                        ->contain(['Roles'])
                        ->first();

        $userRols =  $this->UserRols
                        ->find('all')
                        ->where(['UserRols.UserId' => $usersId, 'Roles.AppRol' => 1])
                        ->contain(['Roles'])
                        ->first();
       
        $this->set('rol', $this->Roles
                        ->find('all')
                        ->select(['Description' => 'Actions.Description'])
                        ->contain(['ActionsRols.Actions', 'UserRols'])
                        ->matching('ActionsRols.Actions')
                        //->where(['UserRols.UserId' => $user['Id']])
                  );

        $this->set('_serialize', ['rol']);

        $this->set('_serialize', ['actionsbyrol']);

        $this->set(compact('user', 'country', 'userRoles', 'userRols', 'brithdate'));

    }

    //Funcion para agregar usuario
    public function adduser(){

        $userId = $this->Auth->user('Id');

        $pageTitle = "Agregar Usuario";

        $breadcrumbs = '<li>Usuarios</li>
                        <li>Cuentas</li>
                        <li class="active">Agregar Usuario</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        //$this->loadModel('Users');

        //Validamos que la peticion sea de tipo POTS
        if($this->request->is('POST')){

            $usersTable = TableRegistry::get('Users');

            $user = $usersTable->newEntity();

            $user->AuthenticationMethodId = $this->request->getData('rbAuthenticationMethod');
            $user->Username = $this->request->getData('txtEmail');
            $user->DocId = $this->request->getData('txtUsername');
            $user->Password = $this->request->getData('txtPassword');
            $user->ChangePassword = 0;
            $user->UserStatusId = $this->request->getData('rbAccountStatus');
            $user->AccessId = 1;
            $user->Name = $this->request->getData('txtFirstName');
            $user->LastName = $this->request->getData('txtLastName');
            $brith = $this->request->getData('txtBirthDate');
            $brithdate = date("Y-m-d", strtotime($brith));
            $user->BirthDate = $brithdate;
            $user->CountryId = $this->request->getData('cmbCountry');
            $user->CelPhone = $this->request->getData('txtCellPhoneNumber');
            $user->SecondName = '';
            $user->SecondLastName = '';
            $user->Email = $this->request->getData('txtEmail');
            $user->City = '';
            $user->Phone = '';
            $user->Created = date('Y-m-d H:i:s');
            $user->Modified = date('Y-m-d H:i:s');
			
            //Guardamos el usuario
            if ($usersTable->save($user)) {
               $newUserId = $user->Id;
               $this->Flash->success(__('Usuario agregado.'));
			   
			   //Recibimos los datos de UsersRols
			  $userRolTable = TableRegistry::get('UserRols');

			  $userRols = $userRolTable->newEntity();
			  $userRols->UserId = $newUserId;
			  $userRols->RolId = $this->request->getData('rbRolls');

			  //Guardamos los datos
			  if($userRolTable->save($userRols)){
				 $userRolId = $userRols->Id;
			  }
			   return $this->redirect(['action' => 'listusers']);
            }

            
		}
            
		//Se importa el modelo de paises para utilizarlos en un select options en la vista
		$this->loadModel('Countries');
		$this->set('countries', $this->Countries
									->find('list')->all()->toArray()
		);

		//Se importa el modelo roles, estos se van a mostrar en la vista con un checkbox
		$this->loadModel('Roles');
		$this->set('roles', $this->Roles
									->find('list')
									->where(['Roles.AppRol' => 0])->all()->toArray()
		);
		$this->set('rols', $this->Roles
									->find('list')
									->where(['Roles.AppRol' => 1])->all()->toArray()
		);

		//$this->set(compact('User'));
		//$this->set('_serialize', ['User']);
		//$this->set(compact('user'));
		//$this->set('_serialize', ['user']);

		$this->set('userId', $userId);
		$this->set('_serialize', ['userId']);
    }

    //funcion para ver lista de usuarios
    public function getusers() {

        $this->loadModel('Users');

        $connection = ConnectionManager::get('default');
        $users = $connection->execute("SELECT distinct Users.Id AS UserId,
                                          Users.Name AS `Name`,
                                          Users.UserStatusId AS `UserStatusId`,
                                          Users.LastName AS `LastName`,
                                          Users.Email AS `Email`,
                                          Roles.Name AS `Roles`,
                                          (select DATE_SUB(UserLogs.Created, INTERVAL 4 HOUR) from UserLogs where Users.Id = UserLogs.UserId and (Action ='Login' or Action = 'Login Admin') order by Created desc limit 0,1) AS `LastLogin`,
										  S.Status
                                        FROM
                                          Users Users                                          
                                          INNER JOIN UserRols UserRols ON Users.Id = UserRols.UserId
                                          INNER JOIN Roles Roles ON Roles.Id = UserRols.RolId       
										  inner join UserStatus S on S.Id = Users.UserStatusId
                                        ORDER BY
                                          Users.Name Asc")
                        ->fetchAll('assoc');

        $this->set('users', $users);
        $this->set('_serialize', ['users']);
    }

    public function getroles($rolId = NUll) {
        //Consultamos las acciones del Rol seleccionado
        $this->loadModel('Roles');

        $this->set('roles', $this->Roles
                        ->find('all')
                        ->select(['Description' => 'Actions.Description'])
                        ->contain(['ActionsRols.Actions'])
                        ->matching('ActionsRols.Actions')
                        ->where(['Roles.Id' => $rolId])
        );

        $this->set('_serialize', ['roles']);
    }

    //funcion para activar y desactivar usuario
    public function status($id = NUll) {
        $this->loadModel('Users');
        $statusObj = $this->Users->find()
                            ->select(['UserStatusId'])
                            ->where(['Users.Id' => $id])->first();

        $status =  $statusObj["UserStatusId"];

        if($status == "3"){
            $status = "1";
        }
        else if($status == "2"){
            $status = "3";
        }
        else {
            $status = "2";
        }

        $users = TableRegistry::get('Users');
        $query = $users->query();
                        $query->update()
                        ->set(['Users.UserStatusId' => $status])
                        ->where(['Users.Id' => $id])
                        ->execute();

        // muestra del estado actual del usuario
        $this->set('status', $status);
        $this->set('_serialize', ['status']);
    }

    //Consultado del estado del usuario, en éste caso habilitado
    public function statusEnabled() {
        $this->loadModel('Users');
        $enabled = $this->Users->find()
                              ->select(['UserStatusId'])
                              ->where(['Users.UserStatusId' => '1'])
                              ->count();

        $this->set('enabled', $enabled);
        $this->set('_serialize', ['enabled']);
    }

    //Consultado del estado del usuario, en éste caso desabilitado
    public function statusDisabled() {
        $this->loadModel('Users');
        $disabled = $this->Users->find()
                               ->select(['UserStatusId'])
                               ->where(['Users.UserStatusId' => '2'])
                               ->count();

        $this->set('disabled', $disabled);
        $this->set('_serialize', ['disabled']);
    }

    //Funcion para ver Datos del Usuario
    public function myaccount($userId = null){

        $userId = $this->Auth->user('Id');

        $pageTitle = "Mi Cuenta";

        $breadcrumbs = '<li>Control de Usuarios</li>
                        <li>Cuentas</li>
                        <li class="active">Mi Cuenta</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);

        //Importamos el Modelo Users
        $this->loadModel('Users');
        //Recibimos todos los datos del usuario
        $user = $this->Users->get($userId);

        $brith = $user['BirthDate'];
        $brithdate = date("d-m-Y", strtotime($brith));

        //Se importa el modelo de paises para utilizarlos en un select options en la vista
        $this->loadModel('Countries');
        $this->set('countries', $this->Countries
                        ->find('list')
        );

        //Se importa el modelo roles, estos se van a mostrar en la vista con un checkbox
        $this->loadModel('Roles');
        $this->set('roles', $this->Roles
                                    ->find('list')
                                    ->where(['Roles.AppRol' => 0])
        );

        $this->set('rols', $this->Roles
                                    ->find('list')
                                    ->where(['Roles.AppRol' => 1])
        );

        //Importamos el Modelo UserRoles Para obtener el rol del usuario
        $this->loadModel('UserRols');
        $userRoles =  $this->UserRols
                        ->find('all')
                        ->where(['UserRols.UserId' => $userId, 'Roles.AppRol' => 0])
                        ->contain(['Roles'])
                        ->first();

        $userRols =  $this->UserRols
                        ->find('all')
                        ->where(['UserRols.UserId' => $userId, 'Roles.AppRol' => 1])
                        ->contain(['Roles'])
                        ->first();

        //Funcion para ver acciones asociadas al rol del usuario
        $this->set('rolesActions', $this->Roles
                        ->find('all')
                        ->select(['Description' => 'Actions.Description'])
                        ->contain(['ActionsRols.Actions', 'UserRols'])
                        ->matching('ActionsRols.Actions')
                        ->matching('UserRols')
                        ->where(['UserRols.UserId' => $userId])
        );


         $this->set(compact('user', 'userRoles', 'userRols', 'brithdate'));
    }

    //Funcion para editar datos referentes a Login
    public function editlogin($userId = NULL) {

        $this->loadModel('Users');
        $Id = $this->Users->get($userId);
        
		//Validamos que la peticion sea de tipo POST
        if($this->request->is('POST')){
            if($this->request->getData('txtPassword') == ''){
                //Recibimos los datos
                $userLoginTable = TableRegistry::get('Users');

                $userLogin = $userLoginTable->patchEntity($Id, $this->request->getData());
                $userLogin->AuthenticationMethodId = $this->request->getData('rbAuthenticationMethod');
                $userLogin->DocId = $this->request->getData('txtUsername');
                $userLogin->UserStatusId = $this->request->getData('rbAccountStatus');
                $userLogin->AccessId = 1;
                $userLogin->Modified = date('Y-m-d H:i:s');

            } else {
                //Recibimos los datos
                $userLoginTable = TableRegistry::get('Users');

                $userLogin = $userLoginTable->patchEntity($Id, $this->request->getData());
                $userLogin->AuthenticationMethodId = $this->request->getData('rbAuthenticationMethod');
                $userLogin->DocId = $this->request->getData('txtUsername');
                $userLogin->Password = $this->request->getData('txtPassword');
                $userLogin->UserStatusId = $this->request->getData('rbAccountStatus');
                $userLogin->AccessId = 1;
                $userLogin->Modified = date('Y-m-d H:i:s');

            }

            //Guardamos los datos de Logueo del Usuario
            if($userLoginTable->save($userLogin)){
                $this->Flash->success('Información del Login actualizada.');
                return $this->redirect($this->referer());
                //return $this->redirect(['action' => 'myaccount']);
            }
        }
        $this->set(compact('userLogin'));
    }

    public function editgeneral($userId = NULL){

        $this->loadModel('Users');
        $Id = $this->Users->get($userId);

        //Validamos que la peticion sea de tipo POST
        if ($this->request->is('POST')) {

            //Recibimos los datos que vienen desde el formulario
            $userGeneralTable = TableRegistry::get('Users');

            $userGeneral = $userGeneralTable->patchEntity($Id, $this->request->getData());
            $userGeneral->Name = $this->request->getData('txtFirstName');
            $userGeneral->LastName = $this->request->getData('txtLastName');

            $brith = $this->request->getData('txtBirthDate');
            $brithdate = date("Y-m-d", strtotime($brith));

            $userGeneral->BirthDate = $brithdate;
            $userGeneral->CountryId = $this->request->getData('cmbCountry');
            $userGeneral->CelPhone = $this->request->getData('txtCellPhoneNumber');
            $userGeneral->SecondName = '';
            $userGeneral->SecondLastName = '';
            $userGeneral->Email = $this->request->getData('txtEmail');
            $userGeneral->City = '';
            $userGeneral->Phone = '';
            $userGeneral->Modified = date('Y-m-d H:i:s');

            //Guardamos los datos que acabamos de editar
            if ($userGeneralTable->save($userGeneral)) {
                $this->Flash->success('Datos actualizados');
                return $this->redirect($this->referer());
            }
        }
        $this->set(compact('userGeneral'));
    }

    public function editrol($userId = NULL){
        //Validamos que la peticon sea de tipo Post
        if ($this->request->is('POST')) {
            //Hacemos el registro de la Tabla
            $userRolTable = TableRegistry::get('UserRols');

            // Borramos rol anterior
			$query = $userRolTable->query();
			$query->delete()
			->where(['UserId' => $userId])
			->execute();
			
			// Insertamos nuevo
			$userRols = $userRolTable->newEntity();
			$userRols->UserId = $userId;
			$userRols->RolId = $this->request->getData('rbRolls');

			// Guardamos los datos
			if($userRolTable->save($userRols)){
				$userRolId = $userRols->Id;
			}
			
            //Guardamos los datos
            $this->Flash->success('Rol actualizado.');
            return $this->redirect($this->referer());              
        }
    }

    public function edituser($usersId = NULL){
        $userId = $this->Auth->user('Id');
        $pageTitle = "Editar Usuario";

        $breadcrumbs = '<li>Control de Usuarios</li>
                        <li>Cuentas</li>
                        <li><a href="../listusers" title="Listar Usuarios">Listar Usuarios</a></li>
                        <li class="active"><a href="/Accounts/edituser/'.$usersId.'" title="Editar Usuario">Editar Usuario</a></li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);


        $this->loadModel('Users');
        $user = $this->Users->get($usersId);

        $brith = $user['BirthDate'];
        $brithdate = date("d-m-Y", strtotime($brith));

        //Se importa el modelo de paises para utilizarlos en un select options en la vista
        $this->loadModel('Countries');
        $this->set('countries', $this->Countries
                                    ->find('list'));

        //Se importa el modelo roles, estos se van a mostrar en la vista con un checkbox
        $this->loadModel('Roles');
        $this->set('roles', $this->Roles
                                    ->find('list')
                                    ->where(['Roles.AppRol' => 0])
        );

        $this->set('rols', $this->Roles
                                    ->find('list')
                                    ->where(['Roles.AppRol' => 1])
        );

        //Importamos el Modelo UserRoles Para obtener el rol del usuario
        $this->loadModel('UserRols');
        $userRoles =  $this->UserRols
                        ->find('all')
                        ->where(['UserRols.UserId' => $usersId, 'Roles.AppRol' => 0])
                        ->contain(['Roles'])
                        ->first();

        $userRols =  $this->UserRols
                        ->find('all')
                        ->where(['UserRols.UserId' => $usersId, 'Roles.AppRol' => 1])
                        ->contain(['Roles'])
                        ->first();

        $this->set(compact('user', 'userRoles', 'userRols', 'brithdate'));
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);

    }

    //Funcion para eliminar logicamente un usuario
    public function deleteuser($id = NUll) {
        $this->loadModel('Users');
        $status = "1";        
		$users = TableRegistry::get('Users');
		$query = $users->query();
        $query->delete()->where(['Users.Id' => $id])
                        ->execute();		
		
        // Resultado
        $this->set('status', $status);
        $this->set('_serialize', ['status']);
    }
}

?>
