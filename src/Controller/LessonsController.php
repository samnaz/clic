<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

class LessonsController extends AppController {
    public function listlessons() {
        $userId = $this->Auth->user('Id');

        $pageTitle = "Listar Lecciones";

        $breadcrumbs = '<li>Libros</li>
                        <li>Lecciones</li>
                        <li class="active">Listar Lecciones</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('serialize', ['userId']);
    }
	
	public function viewlesson($lessonId = NULL) {

        $userId = $this->Auth->user('Id');
        $pageTitle = "Ver Lección";

        $breadcrumbs = '<li>Tablas</li>
                        <li>Lecciónes</li>
                        <li><a href="../listlessons" title="Lecciones">Listar Lecciones</a></li>
                        <li class="active">Ver Lección</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('serialize', ['userId']);

        // De esta forma consultamos los datos de la Ubicacion
        $this->loadModel('Lessons');
        $lessons = $this->Lessons->find("all")->contain(['Books'])->where(['Lessons.Id' => $lessonId])->first();       
        $this->set(compact('lessons'));
    }
	
	// Funcion para editar
    public function editlesson($lessonId = NULL) {

        $userId = $this->Auth->user('Id');
        $pageTitle = "Editar Lección";

        $breadcrumbs = '<li>Tablas</li>
                        <li>Lecciónes</li>
                        <li><a href="../listlessons" title="Lecciones">Listar Lecciones</a></li>
                        <li class="active">Editar Lección</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('serialize', ['userId']);
		$this->loadModel('Lessons');
        
		// Validamos que la peticion sea de tipo POST
        if($this->request->is('POST')){
            $bTable = TableRegistry::get('Lessons');
            $brnd = $this->Lessons->get($lessonId);
            $brnd->Day = $this->request->getData('txtDay');
			$brnd->BookId = $this->request->getData('cmbBook');
            $brnd->Active = $this->request->getData('rbStatus');
            $brnd->Modified = date('Y-m-d H:i:s');
			
			// Si es img.
			$fileobject = $this->request->getData('Image');			
			
			// Img.
			if ($fileobject) {
				$ext = substr(strtolower(strrchr($fileobject->getClientFilename(), '.')), 1); //get the extension
				$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
				$setNewFileName = "lesson_" . $brnd->BookId . "_" . $brnd->Day; 
				
				// only process if the extension is valid
				if (in_array($ext, $arr_ext)) {					
					//prepare the filename for database entry 
					$imageFileName = $setNewFileName . '.' . $ext;
					//do the actual uploading of the file. First arg is the tmp name, second arg is 
					//where we are putting it
					$fileobject->moveTo(WWW_ROOT . '/img/lessons/' . $imageFileName);
					$brnd->CoverImage = "https://ccnninos.org/img/lessons/" . $imageFileName;
				}
				else{
					 $this->Flash->error(__('Imagen inválida.'),['clear'=> true]);
				}
			}

            // Guardamos el registro
            if ($bTable->save($brnd)) {
              $this->Flash->success(__('Lección actualizada.'),['clear'=> true]);
            }
		}
		
		// Combo libro
		$this->loadModel('Books');
		$this->set('books', $this->Books
			->find('list')->order(['Books.Sorting' => 'ASC'])->all()->toArray()
		);
		
        // De esta forma consultamos los datos
        $lesson = $this->Lessons->get($lessonId);
        $this->set(compact('lesson'));
    }
		
	public function addlesson(){
		// Header
        $userId = $this->Auth->user('Id');
        $pageTitle = "Agregar Lección";
        $breadcrumbs = '<li>Tablas</li>
                        <li>Lecciones</li>
                        <li class="active">Agregar Lección</li>';
        $this->set('pageTitle', $pageTitle);
        $this->set('serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('serialize', ['userId']);
       
        // Validamos que la peticion sea de tipo POST
        if($this->request->is('POST')){
            $ssTable = TableRegistry::get('Lessons');
            $exists = $ssTable->exists(['Day' => $this->request->getData('txtDay'), 'BookId' => $this->request->getData('cmbBook')]);
			if (!$exists){			
				$brnd = $ssTable->newEmptyEntity();
				$brnd->Day = $this->request->getData('txtDay');            
				$brnd->BookId = $this->request->getData('cmbBook');
				$brnd->Active = $this->request->getData('rbStatus');
				$brnd->Created = date('Y-m-d H:i:s');
				$brnd->Modified = date('Y-m-d H:i:s');

				// Img.
				if ($fileobject) {
					$ext = substr(strtolower(strrchr($fileobject->getClientFilename(), '.')), 1); //get the extension
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
					$setNewFileName = "lesson_" . $brnd->BookId . "_" . $brnd->Day; 
					
					// only process if the extension is valid
					if (in_array($ext, $arr_ext)) {					
						//prepare the filename for database entry 
						$imageFileName = $setNewFileName . '.' . $ext;
						//do the actual uploading of the file. First arg is the tmp name, second arg is 
						//where we are putting it
						$fileobject->moveTo(WWW_ROOT . '/img/lessons/' . $imageFileName);
						$brnd->CoverImage = $imageFileName;
					}
					else{
						 $this->Flash->error(__('Imagen inválida.'),['clear'=> true]);
						 $brnd->CoverImage = '';
					}
				}else
					$brnd->CoverImage = '';
				
				// Guardamos el registro
				if ($ssTable->save($brnd)) {
				   $newStId = $brnd->Id;
				   $this->Flash->success(__('Lección agregada.'),['clear'=> true]);
				   return $this->redirect(['action' => 'listlessons']); 
				}
			}
			else
				$this->Flash->error(__('Lección ya existe.'),['clear'=> true]);	
		}
		
		// Combo libro
		$this->loadModel('Books');
		$this->set('books', $this->Books
			->find('list')->order(['Books.Sorting' => 'ASC'])->all()->toArray()
		);
    }
	
	public function getlessons(){
        if($this->request->is('GET')){
			$this->loadModel('Lessons');
			$this->set('Lessons', $this->Lessons
				->find('all')
				->contain('Books')
				->select(['LessonId' => 'Lessons.Id'
						, 'Day' => 'Lessons.Day'
						, 'Book' => 'Books.Name',
						'Status' => 'If(Lessons.Active, \'Sí\', \'No\')'
						])
					->order(['Lessons.Day' => 'ASC']));
			$this->set('serialize', ['Lessons']);
        }
    }	
	
	// Funcion para eliminar
    public function deletelesson($id = NUll) {
        $result = "1";        
		$userTable = TableRegistry::get('UserLessons');
        $usrExists = $userTable->exists(['LessonId' => $id]);
          
		// Si existen paginas
		if ($usrExists)
		{
			$result=0;
		}else{
			$pTable = TableRegistry::get('Pages');
			$pExists = $userTable->exists(['LessonId' => $id]);
			  
			// Si existen paginas
			if ($pExists)
			{
				$result=0;
			}else{			
				$this->loadModel('Lessons');       
				$table = TableRegistry::get('Lessons');
				$query = $table->query();
				$query->delete()
				->where(['Id' => $id])
				->execute();
			}
		}
		
        // Resultado
        $this->set('result', $result);
        $this->set('serialize', ['result']);
    }
	
	public function listpages() {
        $userId = $this->Auth->user('Id');

        $pageTitle = "Listar Páginas";

        $breadcrumbs = '<li>Libros</li>
                        <li>Páginas</li>
                        <li class="active">Listar Páginas</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('serialize', ['userId']);
    }
	
	public function viewpage($pageId = NULL) {

        $userId = $this->Auth->user('Id');
        $pageTitle = "Ver Página";

        $breadcrumbs = '<li>Tablas</li>
                        <li>Páginaes</li>
                        <li><a href="../listpages" title="Páginas">Listar Páginas</a></li>
                        <li class="active">Ver Página</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('serialize', ['userId']);

        // De esta forma consultamos los datos de la Ubicacion
        $this->loadModel('Pages');
        $page = $this->Pages->find("all")->contain(['Lessons', 'PageTypes', 'Lessons.Books'])->where(['Pages.Id' => $pageId])->first();
        $this->set(compact('page'));
    }
	
	// Funcion para editar
    public function editpage($pageId = NULL) {

        $userId = $this->Auth->user('Id');
        $pageTitle = "Editar Página";

        $breadcrumbs = '<li>Tablas</li>
                        <li>Páginaes</li>
                        <li><a href="../listpages" title="Páginas">Listar Páginas</a></li>
                        <li class="active">Editar Página</li>';

        $this->set('pageTitle', $pageTitle);
        $this->set('serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('serialize', ['userId']);
		$this->loadModel('Pages');
        
		// Validamos que la peticion sea de tipo POST
        if($this->request->is('POST')){
            $bTable = TableRegistry::get('Pages');
            $brnd = $this->Pages->get($pageId);
            $brnd->Sort = $this->request->getData('txtSort');
            $brnd->Points = $this->request->getData('txtPoints');
			$brnd->LessonId = $this->request->getData('cmbLesson');
            $brnd->PageTypeId = $this->request->getData('cmbPageTypeId');
            $brnd->Modified = date('Y-m-d H:i:s');
			$brnd->Content = $this->request->getData('txtContent');
			$brnd->Title = $this->request->getData('txtTitle');
			
			// Si es img.
			$fileobject = $this->request->getData('Image');			
			
			// Img.
			if ($fileobject) {
				$ext = substr(strtolower(strrchr($fileobject->getClientFilename(), '.')), 1); //get the extension
				$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
				$setNewFileName = "lesson_" . $brnd->LessonId . "_page_" . $brnd->Sort; 
				
				// only process if the extension is valid
				if (in_array($ext, $arr_ext)) {					
					//prepare the filename for database entry 
					$imageFileName = $setNewFileName . '.' . $ext;
					//do the actual uploading of the file. First arg is the tmp name, second arg is 
					//where we are putting it
					$fileobject->moveTo(WWW_ROOT . '/img/lessons/' . $imageFileName);
					$brnd->Image = $imageFileName;
				}
				else{
					 $this->Flash->error(__('Imagen inválida.'),['clear'=> true]);
				}
			}
            
            // Guardamos el registro
            if ($bTable->save($brnd)) {
              $this->Flash->success(__('Página actualizada.'),['clear'=> true]);
            }
		}
		
		// Combo lecc.
		$this->loadModel('Lessons');
		$this->set('lessons', $this->Lessons
			->find()->contain('Books')->select(['id' => 'Lessons.Id'
						, 'Name' => "Books.Name"						
						, 'Day' => "Lessons.Day"						
						])->formatResults(function($results) {
       
			return $results->combine(
				'id',
				function($row) {
					return $row['Name'] . ' - ' . $row['Day'];
				}
			);
			})->toArray()
		);
		
		// Combo types.
		$this->loadModel('PageTypes');
		$this->set('pageTypes', $this->PageTypes->find('list')
			->all()->toArray()
		);
		
        // De esta forma consultamos los datos
        $page = $this->Pages->get($pageId);
        $this->set(compact('page'));
    }
		
	public function addpage(){
		// Header
        $userId = $this->Auth->user('Id');
        $pageTitle = "Agregar Página";
        $breadcrumbs = '<li>Tablas</li>
                        <li>Páginas</li>
                        <li class="active">Agregar Página</li>';
        $this->set('pageTitle', $pageTitle);
        $this->set('serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('serialize', ['userId']);
       
        // Validamos que la peticion sea de tipo POST
        if($this->request->is('POST')){
            $ssTable = TableRegistry::get('Pages');
            $exists = $ssTable->exists(['Sort' => $this->request->getData('txtSort'), 'LessonId' => $this->request->getData('cmbLesson')]);
			if (!$exists){			
				$brnd = $ssTable->newEmptyEntity();
				$brnd->Sort = $this->request->getData('txtSort');
				$brnd->Points = $this->request->getData('txtPoints');
				$brnd->LessonId = $this->request->getData('cmbLesson');
				$brnd->PageTypeId = $this->request->getData('cmbPageTypeId');
				$brnd->Modified = date('Y-m-d H:i:s');
				$brnd->Content = $this->request->getData('txtContent');            
				$brnd->Created = date('Y-m-d H:i:s');
				$brnd->Title = $this->request->getData('txtTitle');
			
				// Si es img.
				$fileobject = $this->request->getData('Image');			
				
				// Img.
				if ($fileobject) {
					$ext = substr(strtolower(strrchr($fileobject->getClientFilename(), '.')), 1); //get the extension
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
					$setNewFileName = "lesson_" . $brnd->LessonId . "_page_" . $brnd->Sort; 
					
					// only process if the extension is valid
					if (in_array($ext, $arr_ext)) {					
						//prepare the filename for database entry 
						$imageFileName = $setNewFileName . '.' . $ext;
						//do the actual uploading of the file. First arg is the tmp name, second arg is 
						//where we are putting it
						$fileobject->moveTo(WWW_ROOT . '/img/lessons/' . $imageFileName);
						$brnd->Image = $imageFileName;
					}
					else{
						 $this->Flash->error(__('Imagen inválida.'),['clear'=> true]);
						 $brnd->Image = '';
					}
				}else
					$brnd->Image = '';
				
				// Guardamos el registro
				if ($ssTable->save($brnd)) {
				   $newStId = $brnd->Id;
				   $this->Flash->success(__('Página agregada.'),['clear'=> true]);
				   return $this->redirect(['action' => 'listpages']); 
				}
			}
			else
				$this->Flash->error(__('Página ya existe.'),['clear'=> true]);	
		}
		
		// Combo lecc.
		$this->loadModel('Lessons');
		$this->set('lessons', $this->Lessons
			->find()->contain('Books')->select(['id' => 'Lessons.Id'
						, 'Name' => "Books.Name"						
						, 'Day' => "Lessons.Day"						
						])->formatResults(function($results) {
       
			return $results->combine(
				'id',
				function($row) {
					return $row['Name'] . ' - ' . $row['Day'];
				}
			);
			})->toArray()
		);
		
		// Combo types.
		$this->loadModel('PageTypes');
		$this->set('pageTypes', $this->PageTypes->find('list')
			->all()->toArray()
		);
    }
	
	public function getpages(){
        if($this->request->is('GET')){
			$contains = array('Lessons'=>array('Books'), 'PageTypes');
			$this->loadModel('Pages');
			$this->set('Pages', $this->Pages
				->find('all')
				//->contain('Books')
				->contain($contains)
				//->contain('PageTypes')
				->select(['PageId' => 'Pages.Id'
						, 'Day' => 'Lessons.Day'
						, 'Type' => 'PageTypes.Name'
						, 'Sort' => 'Pages.Sort'
						, 'Book' => 'Books.Name'
						])
					->order(['Pages.Sort' => 'ASC']));
			$this->set('serialize', ['Pages']);
        }
    }
	
	// Funcion para eliminar
    public function deletepage($id = NUll) {
        $result = "1";        
		$userTable = TableRegistry::get('UserPages');
        $usrExists = $userTable->exists(['PageId' => $id]);
          
		// Si existen paginas
		if ($usrExists)
		{
			$result=0;
		}else{
			$this->loadModel('Pages');       
			$table = TableRegistry::get('Pages');
			$query = $table->query();
			$query->delete()
			->where(['Id' => $id])
			->execute();
		}
		
        // Resultado
        $this->set('result', $result);
        $this->set('serialize', ['result']);
    }
}
?>
