<?php


namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Controller\AppController;

class ActionsController extends AppController {

    public function manageroles() {
        $userId = $this->Auth->user('Id');

        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);
        
        $pageTitle = "Listado de Roles";

        $breadcrumbs = '<li>Control de Acceso</li>
                        <li>Permisología</li>
                        <li class="active">Administrar Roles</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);

        $this->loadModel('Roles');
        $this->set('roles', $this->Roles
                        ->find('list')
                        ->select(['Name' => 'Name']));

        $this->set('_serialize', ['roles']);
    }

    public function addrole() {
        if ($this->request->is('post')) {

            $roleTable = TableRegistry::get('Roles');

            $role = $roleTable->newEntity();
            $role->Name = $this->request->getParam['txtRoleName'];

            if ($roleTable->save($role)) {
                  $this->Flash->success("Rol agregado.");
                return $this->redirect(['action' => 'manageroles']);
            }
            $this->Flash->error(__('no se guardó.'));
        }
    }


    //Esta funcion permite ver la permisologia de el rol seleccionado
    public function getactions() {
        //Consultamos las acciones del Rol seleccionado
        $this->loadModel('Actions');

        $this->set('actions', $this->Actions
                        ->find('all')
                        ->select(['Description' => 'Actions.Description'
                                , 'Id' => 'Actions.Id'])
                        
        );

        $this->set('_serialize', ['actions']);
    }
    
     // Esta funcion permite ver la permisologia de el rol seleccionado
    public function getactionsbyrol($rolId = NUll) {
        //Consultamos las acciones del Rol seleccionado
        $this->loadModel('ActionsRols');

        $this->set('actionsbyrol', $this->ActionsRols
                        ->find('all')
                        ->select(['Id' => 'ActionsRols.ActionId'])
                        ->where(['ActionsRols.RolId' => $rolId])
                        
        );

        $this->set('_serialize', ['actionsbyrol']);
    }

    // Asignar acciones a un rol
    public function addactionsbyrol($rolId = NULL){
        // Validamos que la peticion sea de tipo POST
        if ($this->request->is('POST')) {
			$actionsId = $this->request->getData('actionsId');     
			//$rolId = $this->request->getParam['rolId'];	
            $actions = explode("-", $actionsId);
            
            // Borramos anteriores
			$actionsRolsTable = TableRegistry::get('ActionsRols');
            $query = $actionsRolsTable->query();
			$query->delete()
			->where(['RolId' => $rolId])
			->execute();
           
            for ($i=0; $i < count($actions) ; $i++) { 
				// Si viene cero, no tiene acciones
				if ($actions[$i] == 0)
					break;
               
			    // Verificamos si ya existe el registro en la base de datos
                $exists = $actionsRolsTable->exists(['ActionsRols.RolId' => $rolId, 'ActionsRols.ActionId' => $actions[$i]]);
                
                if(!$exists){
                   
                    $action = $actionsRolsTable->newEntity();
                    $action->RolId = $rolId;
                    $action->ActionId = $actions[$i];

                    //Guardamos el registro
                    if($actionsRolsTable->save($action)){
                        $actionId = $action->Id;
                    }
                }
            }
        }
       /*$this->Flash->success(__('El Rol ha sido actualizado.'),['clear'=> true]);       
		 // Resultado
        $this->set('status', 'El Rol ha sido actualizado.');
        $this->set('_serialize', ['status']);*/
		$this->Flash->success('El Rol ha sido actualizado');
        return $this->redirect($this->referer());
			
    }
}

?>