<?php
	namespace App\View\Cell;

	use Cake\View\Cell;

	class PartialCell extends Cell{

		//Funcion para visualizar al usuario Loggeado
	    public function userlogin($user = null){
	    	$this->loadModel('Users');

            $username = $this->Users
            				->find('all')
            				->select(['Users.Name', 'Users.LastName'])
            				->where(['Users.Id' => $user])
            				->first();

            $this->set('username', $username);
            $this->set('_serialize', ['username']);
            
	    }

	    //Funcion para mostrar el menu segun el rol
	    public function menu($user = NULL){
	    	//Importamos el modelo UserRol para saber el rol del usuario activo
	    	$this->loadModel('UserRols');
	    	$rols = $this->UserRols
	    					->find('all')
	    					->where(['UserRols.UserId' => $user])
	    					->first();

	    	//Importamos el modelo ActionsRols para visualizar todas las acciones asociadas al rol
	    	$this->loadModel('ActionsRols');

	    	$actionsRol = $this->ActionsRols
	    					->find('all')
	    					->select(['Action' => 'Actions.Description'
	    							, 'SubModuleId' => 'Actions.SubModuled'
	    							, 'Submodule' => 'SubModules.Name'
	    							, 'Module' => 'Modules.Name'
	    							, 'Img' => 'Modules.Img'
	    							, 'Url' => 'Actions.Url'
	    							, 'UrlSub' => 'SubModules.Url'
	    							, 'UrlMod' => 'Modules.Url'
	    							, 'Menu' => 'Actions.Menu'])
	    					->contain(['Actions.SubModules.Modules', 'Roles'])
	    					->where(['ActionsRols.RolId' => $rols['RolId'], 'Actions.Menu' => 1])
							->order(['Modules.Id' => 'ASC'])
							->order(['SubModules.Url' => 'ASC'])
							->order(['SubModules.Sort' => 'ASC'])
							;
//echo $actionsRol;
	    	//Declaramos un array para los submodulos 
	    	/*$subModulesId = array();
	    	$subModules = array();

	    	//Recorrer el arreglo de sub modulos por acciones
	    	foreach($actionsRol as $action){
	    		
	    		//Si el arreglo esta vacio se agrega al arreglo  subModules
	    		if (count($subModulesId) == 0){
	    			array_push($subModulesId, $action['SubModuleId']);
	    			array_push($subModules, $action['Submodule']);
	    		}
	    		else{
	    			$exist = false;

	    			//Recorrer el arreglo subModules
	    			for ($i = 0; $i < count($subModulesId); $i++){
	    				//Validar si el subModuleId existe en el arreglo
	    				if ($subModulesId[$i] == $action['SubModuleId']){
	    					$exist = true;
	    				}
	    			}

	    			//Si el subModuleId no existe en el arreglo se agrega
	    			if ($exist == false){
	    				array_push($subModulesId, $action['SubModuleId']);	
	    				array_push($subModules, $action['Submodule']);			
	    			}
	    		}
            }
            //Declaramos un Arreglo para Modulos
            $modulesId = array();

            $modules = array();

            //Recorrer el arreglo de submodulos
            for ($i = 0; $i < count($subModules); $i++){
				$submodule = $this->SubModules
			    					->find('all')
			    					->select(['SubModule' => 'SubModules.Name'
			    							, 'Id' => 'SubModules.Id'
			    							, 'ModuleId' => 'SubModules.ModuleId'
			    							, 'Module' => 'Modules.Name'])
			    					->where(['SubModules.Id' => $subModulesId[$i]])
			    					->contain(['Modules'])
			    					->first();

			    //echo '<br>'.$submodule.'<br>';

				//Si el arreglo esta vacio se agrega al arreglo  Modules
	    		if (count($modulesId) == 0){
	    			array_push($modulesId, $submodule['ModuleId']);
	    			array_push($modules, $submodule['Module']);
	    		}
	    		else{
	    			$exist = false;

	    			//Recorrer el arreglo modulesId
	    			for ($j = 0; $j < count($modulesId); $j++){
	    				//Validar si el ModuleId existe en el arreglo
	    				if ($modulesId[$j] == $submodule['ModuleId']){
	    					$exist = true;
	    				}
	    			}

	    			//Si el ModuleId no existe en el arreglo se agrega
	    			if ($exist == false){
	    				array_push($modulesId, $submodule['ModuleId']);	
	    				array_push($modules, $submodule['Module']);				
	    			}
    			}
            }

            //Recorremos el arreglo de Modules
            for($j = 0; $j < count($modulesId); $j++){

				$modulos = $this->Modules
    					->find('all')
    					->select(['Module' => 'Modules.Name'
    							, 'Id' => 'Modules.Id'])
    					->where(['Modules.Id' => $modulesId[$j]])
    					->first();
				
					//echo '<br>'.$modulos.'<br>';
  
    		}*/

	    	$this->set(compact( 'actionsRol'));
            $this->set('_serialize', ['actionsRol']);

	    }
	}
?>