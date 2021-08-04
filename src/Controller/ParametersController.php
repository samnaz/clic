<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

class ParametersController extends AppController {
   public function listparameters(){
         $userId = $this->Auth->user('Id');

        $pageTitle = "Listar Parámetros";

        $breadcrumbs = '<li>Parámetros</li>
                        <li>Configuración</li>
                        <li class="active">Listar Parámetros</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']); 
    }

    // Funcion para ver detalle de param.
    public function viewparameter($parameterId = NULL) {

        $userId = $this->Auth->user('Id');
        $pageTitle = "Ver Parámetros";

        $breadcrumbs = '<li>Parámetros</li>
                        <li>Configuración</li>
                        <li><a href="../listparameters" title="Listar Parámetros">Listar Parámetros</a></li>
                        <li class="active">Ver Parámetro</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);

        // De esta forma consultamos los datos de la marca
        $this->loadModel('Parameters');
        $p = $this->Parameters->get($parameterId);
        $this->set(compact('p'));

    }

	public function editparameter($prId = NULL){
        $userId = $this->Auth->user('Id');
        $pageTitle = "Editar Parámetro";

		// Títulos
        $breadcrumbs = '<li>Parámetros</li>
                        <li>Configuración</li>
						 <li><a href="../listparameters" title="Listar Parámetros">Listar Parámetros</a></li>                       
                        <li class="active">Editar Parámetro</li>';
        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);

		// Modelo
        $this->loadModel('Parameters');
		
		// Actualizar
		// Validamos que la peticion sea de tipo POST
        if($this->request->is('POST')){
			$rec = $this->Parameters->get($prId);
            $pTable = TableRegistry::get('Parameters');
			$param = $pTable->patchEntity($rec, $this->request->getData());
			$param->Id = $prId;
			$param->Value = $this->request->getData('txtValue');
			$param->Modified = date('Y-m-d H:i:s');		

            //Guardamos los datos de Logueo del Usuario
            if($pTable->save($param)){
                $this->Flash->success('Información del Parámetro actualizada.');
                //return $this->redirect($this->referer());               
            }
		}
		
		// Mostrar data
        $p = $this->Parameters->get($prId);
        $this->set(compact('p'));
        $this->set('prId', $prId);
        $this->set('_serialize', ['userId']);
    }
	
	public function getparameters(){
        if($this->request->is('GET')){
			$this->loadModel('Parameters');
			$this->set('Parameters', $this->Parameters
								->find('all')
								->select(['ParameterId' => 'Id', 'Value' => 'Value'])
										->order(['Id' => 'ASC'])); 
			
		  $this->set('_serialize', ['Parameters']);
        }        
    }
}
?>
