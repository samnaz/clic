<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

class TablesController extends AppController {
   // public $components = ['Aws'];

	// Funcion para Visualizar la lista de estados
    public function liststates() {
        $userId = $this->Auth->user('Id');

        $pageTitle = "Listar Estados";

        $breadcrumbs = '<li>Tablas</li>
                        <li>Estados</li>
                        <li class="active">Listar Estados</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);
    }
	
	 public function listcountries() {
        $userId = $this->Auth->user('Id');

        $pageTitle = "Listar Países";

        $breadcrumbs = '<li>Tablas</li>
                        <li>Países</li>
                        <li class="active">Listar Países</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);
    }
		
	public function listbanners(){
         $userId = $this->Auth->user('Id');

        $pageTitle = "Listar Publicidades";

        $breadcrumbs = '<li>Tablas</li>
                        <li>Publicidades</li>
                        <li class="active">Listar Publicidades</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']); 
    }
	
	// Funcion para ver detalle de estado
    public function viewstate($stateId = NULL) {

        $userId = $this->Auth->user('Id');
        $pageTitle = "Ver Estado";

        $breadcrumbs = '<li>Tablas</li>
                        <li>Estados</li>
                        <li><a href="../liststates" title="Ubicaciones">Listar Estados</a></li>
                        <li class="active">Ver Estado</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);

        // De esta forma consultamos los datos de la Ubicacion
        $this->loadModel('States');
        $state = $this->States->get($stateId);
        $this->set(compact('state'));
    }
	
	public function viewcountry($countryId = NULL) {

        $userId = $this->Auth->user('Id');
        $pageTitle = "Ver País";

        $breadcrumbs = '<li>Tablas</li>
                        <li>Países</li>
                        <li><a href="../listcountries" title="Ubicaciones">Listar Países</a></li>
                        <li class="active">Ver País</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);

        // De esta forma consultamos los datos de la Ubicacion
        $this->loadModel('Countries');
        $country = $this->Countries->get($countryId);
        $this->set(compact('country'));
    }
	
	// Funcion para ver detalle de banners
    public function viewbanner($bannerId = NULL) {

        $userId = $this->Auth->user('Id');
        $pageTitle = "Ver Publicidad";

        $breadcrumbs = '<li>Tablas</li>
                        <li>Publicidad</li>
                        <li><a href="../listbanners" title="Publicidad">Listar Publicidad</a></li>
                        <li class="active">Ver Publicidad</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);

        // De esta forma consultamos los datos de la Ubicacion
        $this->loadModel('Banners');
        $banner = $this->Banners->get($bannerId);
        $this->set(compact('banner'));
    }
	
	// Funcion para editar un estado
    public function editstate($stateId = NULL) {

        $userId = $this->Auth->user('Id');
        $pageTitle = "Editar Ubicación";

        $breadcrumbs = '<li>Tablas</li>
                        <li>Ubicaciones</li>
                        <li><a href="../liststates" title="Ubicaciones">Listar Ubicaciones</a></li>
                        <li class="active">Editar Ubicación</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);
		$this->loadModel('States');
        
		// Validamos que la peticion sea de tipo POST
        if($this->request->is('POST')){
            $bTable = TableRegistry::get('States');
            $brnd = $this->States->get($stateId);
            $brnd->CountryId = $this->request->getData('cmbCountry');
			$brnd->Name = $this->request->getData('txtName');
            $brnd->Created = date('Y-m-d H:i:s');
            $brnd->Modified = date('Y-m-d H:i:s');

            // Guardamos el registro
            if ($bTable->save($brnd)) {
              $this->Flash->success(__('Ubicación actualizada.'),['clear'=> true]);
            }
		}
		
        // De esta forma consultamos los datos
        $state = $this->States->get($stateId);
        $this->set(compact('state'));
    }
	
	// Funcion para editar un estado
    public function editcountry($countryId = NULL) {

        $userId = $this->Auth->user('Id');
        $pageTitle = "Editar País";

        $breadcrumbs = '<li>Tablas</li>
                        <li>Países</li>
                        <li><a href="../listcountries" title="Países">Listar Países</a></li>
                        <li class="active">Editar País</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);
		$this->loadModel('Countries');
        
		// Validamos que la peticion sea de tipo POST
        if($this->request->is('POST')){
            $bTable = TableRegistry::get('Countries');
            $brnd = $this->Countries->get($countryId);
            $brnd->Name = $this->request->getData('txtName');
            //$brnd->Created = date('Y-m-d H:i:s');
            $brnd->Modified = date('Y-m-d H:i:s');

            // Guardamos el registro
            if ($bTable->save($brnd)) {
              $this->Flash->success(__('País actualizado.'),['clear'=> true]);
            }
		}
		
        // De esta forma consultamos los datos
        $country = $this->Countries->get($countryId);
        $this->set(compact('country'));
    }
	
	// Funcion para editar banners
    public function editbanner($bannerId = NULL){
		// Header
        $userId = $this->Auth->user('Id');
        $pageTitle = "Editar Publicidad";
        $breadcrumbs = '<li>Tablas</li>
                        <li>Publicidad</li>
                      <li><a href="../listbanners" title="Tipos">Listado</a></li>
                         <li class="active">Editar Publicidad</li>';
        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);
        $this->loadModel('Banners');
        
        // Validamos que la peticion sea de tipo POST
        if($this->request->is('POST')){
            $vTable = TableRegistry::get('Banners');
            $vt = $this->Banners->get($bannerId);
			$vt->Title = $this->request->getData('txtTitle');
			
			// Si es img.
			if (!empty($this->request->getData('Image')['name'])) {
				$file = $this->request->getData('Image'); //put the data into a var for easy use
				$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
				$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
				$setNewFileName = rand(0000000, 9999999);

				// only process if the extension is valid
				if (in_array($ext, $arr_ext)) {					
					//prepare the filename for database entry 
					$imageFileName = $setNewFileName . '.' . $ext;
					//do the actual uploading of the file. First arg is the tmp name, second arg is 
					//where we are putting it
					move_uploaded_file($file['tmp_name'], WWW_ROOT . '/img/Banners/' . $imageFileName);
					$vt->Description = '<img title="'.$this->request->getData('txtTitle').'" src="http://www.compratucarro.net.ve/img/Banners/' . $imageFileName.'">';
				}
				else
					 $this->Flash->error(__('Imagen inválida.'),['clear'=> true]);
			}
			else
				$vt->Description = $this->request->getData('txtBanner');
            $vt->Modified = date('Y-m-d H:i:s');

            // Guardamos el registro
            if ($vTable->save($vt)) {
               $newBrandId = $vt->Id;
               $this->Flash->success(__('Publicidad modificada.'),['clear'=> true]);
			 }
		}
		
		// Banner
		$banner = $this->Banners->get($bannerId);
        $this->set(compact('banner'));
    }

	// Método para agregar Ubicación
	public function addstate(){
		// Header
        $userId = $this->Auth->user('Id');
        $pageTitle = "Agregar Ubicación";
        $breadcrumbs = '<li>Tablas</li>
                        <li>Ubicaciones</li>
                        <li class="active">Agregar Ubicación</li>';
        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);
		
       
        // Validamos que la peticion sea de tipo POST
        if($this->request->is('POST')){
            $ssTable = TableRegistry::get('States');
            $exists = $ssTable->exists(['name' => $this->request->getData('txtName')]);
			if (!$exists){			
				$ss = $ssTable->newEntity();
				$ss->Name = $this->request->getData('txtName');
				$ss->CountryId = $this->request->getData('cmbCountry');
				$ss->Created = date('Y-m-d H:i:s');
				$ss->Modified = date('Y-m-d H:i:s');

				// Guardamos el registro
				if ($ssTable->save($ss)) {
				   $newStId = $ss->Id;
				   $this->Flash->success(__('Estado agregado.'),['clear'=> true]);
				   return $this->redirect(['action' => 'liststates']); 
				}
			}
			else
				$this->Flash->error(__('Estado ya existe.'),['clear'=> true]);	
		}
		
		$this->loadModel('Countries');
		$this->set('countries', $this->Countries
									->find('list')->all()->toArray()
		);
            
		// Se importa el modelo de marcas para utilizarlos en un select options en la vista
		/*$this->loadModel('Countri');
		$this->set('brands', $this->Brands
									->find('list')
		);*/
    }	
	
	public function addcountry(){
		// Header
        $userId = $this->Auth->user('Id');
        $pageTitle = "Agregar País";
        $breadcrumbs = '<li>Tablas</li>
                        <li>Países</li>
                        <li class="active">Agregar País</li>';
        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);
       
        // Validamos que la peticion sea de tipo POST
        if($this->request->is('POST')){
            $ssTable = TableRegistry::get('Countries');
            $exists = $ssTable->exists(['name' => $this->request->getData('txtName')]);
			if (!$exists){			
				$ss = $ssTable->newEntity();
				$ss->Name = $this->request->getData('txtName');
				$ss->Id = $this->request->getData('txtCountryId');
				$ss->Created = date('Y-m-d H:i:s');
				$ss->Modified = date('Y-m-d H:i:s');

				// Guardamos el registro
				if ($ssTable->save($ss)) {
				   $newStId = $ss->Id;
				   $this->Flash->success(__('País agregado.'),['clear'=> true]);
				   return $this->redirect(['action' => 'listcountries']); 
				}
			}
			else
				$this->Flash->error(__('País ya existe.'),['clear'=> true]);	
		}
    }	
	
	// Funcion para agregar banners
    public function addbanner(){
		// Header
        $userId = $this->Auth->user('Id');
        $pageTitle = "Agregar Publicidad";
        $breadcrumbs = '<li>Tablas</li>
                        <li>Publicidad</li>
                        <li class="active">Agregar Publicidad</li>';
        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
         $this->set('userId', $userId);
        $this->set('_serialize', ['userId']);
       
        // Validamos que la peticion sea de tipo POST
        if($this->request->is('POST')){
            $vTable = TableRegistry::get('Banners');
            $vt = $vTable->newEntity();
			$vt->Title = $this->request->getData('txtTitle');
			
			// Si es img.
			if (!empty($this->request->getData('Image')['name'])) {
				$file = $this->request->getData('Image'); //put the data into a var for easy use
				$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
				$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
				$setNewFileName = rand(0000000, 9999999);

				// only process if the extension is valid
				if (in_array($ext, $arr_ext)) {					
					//prepare the filename for database entry 
					$imageFileName = $setNewFileName . '.' . $ext;
					//do the actual uploading of the file. First arg is the tmp name, second arg is 
					//where we are putting it
					move_uploaded_file($file['tmp_name'], WWW_ROOT . '/img/Banners/' . $imageFileName);
					$vt->Description = '<img title="'.$this->request->getData('txtTitle').'" src="http://mieddsam.com/clic/img/Banners/' . $imageFileName.'">';
				}
				else
					 $this->Flash->error(__('Imagen inválida.'),['clear'=> true]);
			}
			else
				$vt->Description = $this->request->getData('txtBanner');
            $vt->Created = date('Y-m-d H:i:s');
            $vt->Modified = date('Y-m-d H:i:s');

            // Guardamos el registro
            if ($vTable->save($vt)) {
               $newBrandId = $vt->Id;
               $this->Flash->success(__('Publicidad agregada.'),['clear'=> true]);
			   return $this->redirect(['action' => 'listbanners']); 
            }
		}
    }

	public function getstates(){
        if($this->request->is('GET')){			
			$this->loadModel('States');
			$this->set('States', $this->States
				->find('all')
				 ->select(['StateId' => 'States.Id'
						, 'Name' => 'States.Name'
						, 'Country' => 'Countries.Name'
						])
					->contain(['Countries'])
					//->where(['Countries.Id' => $countryId])
					->order(['States.Name' => 'ASC']));
			$this->set('_serialize', ['States']);
        }        
    }
	
	public function getcountries(){
        if($this->request->is('GET')){
			$this->loadModel('Countries');
			$this->set('Countries', $this->Countries
				->find('all')
				 ->select(['CountryId' => 'Countries.Id'
						, 'Name' => 'Countries.Name'
						])
					->order(['Countries.Name' => 'ASC']));
			$this->set('_serialize', ['Countries']);
        }        
    }
	
	public function getbanners(){
        if($this->request->is('GET')){
			$this->loadModel('Banners');
			$this->set('Banners', $this->Banners
								->find('all')->select(['BannerId' => 'Id', 'Description' => 'Description', 'Title' => 'Title'])
										->order(['Title' => 'ASC'])); 
			
		  $this->set('_serialize', ['Banners']);
        }        
    }
	
	// Funcion para eliminar estados
    public function deletestate($id = NUll) {
        $this->loadModel('States');       
        $table = TableRegistry::get('States');
        $query = $table->query();
		$query->delete()
		->where(['Id' => $id])
		->execute();

        // Res.
        $this->Flash->success('Ubicación eliminada.',['clear'=> true]);
        return $this->redirect(['action' => 'liststates']); 
    }
	
	// Funcion para eliminar países
    public function deletecountry($id = NUll) {
        $this->loadModel('Countries');       
        $table = TableRegistry::get('Countries');
        $query = $table->query();
		$query->delete()
		->where(['Id' => $id])
		->execute();

        // Res.
        $this->Flash->success('País eliminado.',['clear'=> true]);
        return $this->redirect(['action' => 'listcountries']); 
    }
	
	// Funcion para eliminar banners
    public function deletebanner($id = NUll) {
        $this->loadModel('Banners');       
        $table = TableRegistry::get('Banners');
        $query = $table->query();
		$query->delete()
		->where(['Id' => $id])
		->execute();

        // Res.
        $this->Flash->success('Publicidad eliminada.',['clear'=> true]);
        return $this->redirect(['action' => 'listbanners']); 
    }
}
?>
