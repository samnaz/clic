<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Controller\Component;
use Cake\Controller\Component\AuthComponent;
use Cake\Network\Email\Email;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;
use Cake\Filesystem\Folder;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
class ApiController extends AppController {

    public function initialize() {

        parent::initialize();
        $this->loadComponent('RequestHandler');
		//$this->loadComponent('Security');
    }

    public function beforeFilter(Event $event) {
        $this->Auth->allow(['countries', 'teachers','edituser', 'liststates', 'index', 'listbanners', 'contact',
						  'register', 'forgotuser', 'logoutuser', 'getparameter', 'login', 'getuser',
						  'updateuser', 'changepassword', 'books','lessons', 'setuserlesson', 'userlessons', 'setusercoins'
						, 'usercoins', 'lessontasks', 'lessonchats', 'setlessonchat', 'setuserlessontasks', 
						'lessonchatusers', 'userlessontasks']);
		$this->response->withHeader('Access-Control-Allow-Origin','*');
        $this->response->withHeader('Access-Control-Allow-Methods','*');
		//this->getEventManager()->off($this->Csrf);
		// $this->Security->setConfig('unlockedActions', ['Api']);
		parent::beforeFilter($event);
    }
	
/**
  * Purpose: obtener el listado de estados por país
  *
  * Request method: GET.
  *
  * Use example:
  * http://miedd.samnaz.org/clic/Api/liststates/58.json
  *
  * Result example:
  * {
  *  "States": [
  *      {
  *         "Id": 10,
  *         "Name": "Amazonas"
  *     },
  *     {
  *         "Id": 3,
  *        "Name": "Anzoategui"
  *     }]}
  *
 * @param Integer $countryId El id por el que se va a filtrar (país).
  *
  * @return 2|Id, Name
  */
	public function liststates($countryId = NULL){
        if($this->request->is('GET')){

			// Si existe cache
			//Cache::delete('liststates'.$countryId);
			if (($States = Cache::read('liststates'.$countryId)) === false) {
               $this->loadModel('States');
			   $this->set('States', $this->States
                                ->find('all')
                                 ->select(['Id' => 'States.Id'
                                        , 'Name' => 'States.Name'
                                        ])
                                    ->contain(['Countries'])
                                    ->where(['Countries.Id' => $countryId])
                                    ->order(['States.Name' => 'ASC']));

				// Crear cache
                Cache::write('liststates'.$countryId, $States);
			}
			$this->set('_serialize', ['States']);
        }
    }	
	
	/*
	Purpose: listado de países
	*
	* Request Mehod: GET
	*
	* Use example
	* http://miedd.samnaz.org/clic/Api/countries.json
	*
	* Result example:
	*	{
    *"countries": [
    *    {
    *       "Id": 1,
    *       "Name": "Venezuela"
     *   }
    *]
	*}
	*
	* @return 2|Name, Id
    */
    public function countries(){       
		$this->loadModel('Countries');
		$recipes = $this->Countries->find('all')->order(['Countries.Name' => 'ASC']);
        $this->set('listc', $recipes);
        $this->set('_serialize', ['listc']);
    }
	
	/*
	Purpose: listado de libros
	*
	* Request Mehod: GET
	*
	* Use example
	* http://miedd.samnaz.org/clic/Api/books.json
	*
	* Result example:
	{
		"listb": [
			{
				"Id": 1,
				"Name": "Libro 1",
				"Sorting": 1
			}
		]
	}
	*
	* @return 2|Name, Id
    */
    public function books(){       
		$this->loadModel('Books');
		$recipes = $this->Books->find('all')->order(['Books.Name' => 'ASC']);
        $this->set('listb', $recipes);
        $this->set('_serialize', ['listb']);
    }
	
	/**
	  * Purpose: Obtener las lecciones del libro
	  *
	  * Request method: get.
	  *
	  * Use example:
	  * "https://miedd.samnaz.org/lessons/1.json",
	  *
	  * Result example:
	  {
			"lessons": [
				{
					"Id": 2,
					"BookId": 1,
					"Day": 1,
					"Active": true,
					"Created": "2020-09-09T02:49:44+00:00",
					"Modified": "2020-09-09T02:49:44+00:00",
					"book": {
						"Id": 1,
						"Name": "Mi Conexión con Dios"
					},
					"pages": [
						{
							"Id": 1,
							"LessonId": 2,
							"Sort": 14,
							"PageTypeId": 1,
							"Content": "test",
							"Created": null,
							"Modified": null
						}
					]
				},
				{
					"Id": 3,
					"BookId": 1,
					"Day": 2,
					"Active": false,
					"Created": "2020-09-09T02:51:21+00:00",
					"Modified": "2020-09-09T03:04:46+00:00",
					"book": {
						"Id": 1,
						"Name": "Mi Conexión con Dios"
					},
					"pages": []
				}
			]
		}*
	  *
	  * @param Integer $bookId El id del libro
	  *
	  * @return 8|UserId, Name, LastName, City, BirthDate, TipoID, ID, Email
	  */
	public function lessons($bookId = NULL, $userId = NULL) {
		$this->request->allowMethod(['get']);
		
		// Importar el modelo
		$this->loadModel('UserLessons');
		$this->set('UserLessons', $this->UserLessons
							->find('all')->select(['Day' => 'Day'])
							->contain('Lessons')->where(['UserLessons.UserId' => $userId ])							
							->where(['BookId' => $bookId ])->order(['Lessons.Day' => 'DESC'])
							->first());
		
		// Importar el modelo
		$this->loadModel('Lessons');
		$associated = ['Books'/*, 'Districts' => ['Countries' => ['Regions']], 'Countries' => ['Regions'], 'UserContacts', 'DcpiRoles', 'Teams'*/];
    
		$this->set('lessons', $this->Lessons
							->find('all')							
							->where(['Books.Id' => $bookId ])
							->contain($associated)->toArray());		
        $this->set('_serialize', ['lessons', 'UserLessons']);
    }

	/*
	Purpose: listado profesores del home
	*
	* Request Mehod: GET
	*
	* Use example
	* http://miedd.samnaz.org/clic/Api/teachers.json
	*
	* Result example:
	*{
    "teachers": [
			{
				"Id": "3",
				"Name": "Lember",
				"LastName": "Romero"
			}
		]
	}
	*}
	*
	* @return 3| Id, Name, LastName
    */
    public function teachers(){
        if($this->request->is('GET')){
			//Cache::delete('listbanners');
			if (($listrates = Cache::read('teachers')) === false) {
				/*$this->loadModel('Users');
			    $this->loadModel('Users.UserRols');
			    $this->set('teachers', $this->Users
                                ->find('all')
                                 ->select(['Id' => 'Users.Id'
                                        , 'RolId' => 'UserRols.RolId'
                                        , 'Name' => 'Users.Name'
                                        , 'LastName' => 'Users.LastName'
                                        ])
                                    ->contain(['UserRols'])
                                    ->where(['UserRols.RolId' => 2])
                                    ->order(['Users.Name' => 'ASC']));
				*/
				$connection = ConnectionManager::get('default');
				$pl = $connection->execute("SELECT U.Id, Name,LastName
						FROM Users U inner join UserRols UR on U.Id = UR.UserId
						where RolId = 2
						ORDER BY
						  Name, LastName")
				->fetchAll('assoc');
				$this->set('teachers', $pl);
     
				// Crear cache
                Cache::write('teachers', $listrates);
		  }
		  $this->set('_serialize', ['teachers']);
        }
    }

	/*
	Purpose: recibir data para enviar email
	*
	* Request Mehod: POST
	*
	* Use example
	* http://miedd.samnaz.org/clic/Api/contact.json
	*
	* Result example:
	*	{
    *		"response": {
    *    	"Respuesta": "lromero@medianet.com.ve",
    *    	"enviado": "lromero@medianet.com.ve"
    *		}
	*	}
	*
	* @return 2|Messaage, Response
    */
    public function contact(){
        if($this->request->is('POST')){
			$message = "<h2>".$this->request->getData("Titulo")."</h2>";
			$message .= "<br><b>Nombre: " . $this->request->getData("Nombre");
			$message .= "<br><b>Apellido: " . $this->request->getData("Apellido");
			$message .= "<br><b>Email: " . $this->request->getData("Email");
			$message .= "<br><b>Comentarios: " . $this->request->getData("Comentarios")."</p>";

			// Buscar el email destino
			$this->loadModel('Parameters');
			$p = $this->Parameters->find('all')
				   ->select(['Id' => 'Parameters.Id'
											, 'Value' => 'Parameters.Value'
						])
				   ->where(['Parameters.Id' => 'Email_Contacto'])
				   ->order(['Parameters.Id' => 'ASC'])->first();

			// Enviar
			$email = new Email();
			$r = $email->from([$this->request->getData("Email") => "Clic"])
			//$r = $email->from(["info@compratucarro.net.ve" => "Compra Tu Carro"])
             ->to($p->Value)
			 //->to('lromero@medianet.com.ve')
			 ->emailFormat('html')
             ->subject('Mensaje en Clic app')
             ->send($message);
			$response = ['Respuesta' => $r, 'enviado' => $p->Value];

			// Respuesta
			$this->set(compact('response'));
            $this->set('_serialize', ["response"]);
		}
    }

	/*
	Purpose: recibir data para enviar email recordando clave al usuario
	*
	* Request Mehod: POST
	*
	* Use example
	* http://miedd.samnaz.org/clic/Api/forgotuser.json
	*
	* Result example:
	* {
    *"response": {
    *   "Respuesta": 1,
    *    "enviado": 506
    *}
	*}
	*
	* @return 2|Respuesta, enviado
    */
    public function forgotuser(){
        if($this->request->is('POST')){
			// Buscar el usuario
			$userTable = TableRegistry::get('Users');
            $usrExists = $userTable->exists(['Email' => $this->request->getData("Email")]);

			// Si no existe
			if (!$usrExists)
			{
				$response = ['Respuesta' => 0, 'enviado' => 0];
			}
			else
			{
				// Validar si el usuario está activo
				$usrExists = $userTable->exists(['Email' => $this->request->getData("Email"), 'UserStatusId' => 1]);

				// Si no esta activo
				if (!$usrExists)
				{
					$response = ['Respuesta' => -1, 'enviado' => -1];
				}
				else
				{
					// Consultar los datos del usuario
					$this->loadModel('Users');
					$queryUser = $this->Users
							->find('all')
							->where(['Users.Email' => $this->request->getData("Email")])
							->select(['UserId' => 'Users.Id','Name' => 'Users.Name'])
							->first();
					$userId = $queryUser['UserId'];

					// Cambiar clave
					$newPass= str_replace(" ", "", substr($queryUser['Name'],0,2).rand($userId, 10000000));
					$Id = $this->Users->get($userId);
					$Id->Password = $newPass;
					$Id->Modified = date('Y-m-d H:i:s');

					// Guardamos los datos del Usuario
					$userTable->save($Id);

					// Salvar en db
					$message = "<div align='center'><img width='300px' src='http://miedd.samnaz.org/clic/img/logo.png' alt='Clic'/></div><p>Estimad@: <b>". $queryUser['Name'] ."</b>";
					$message .= "</p><p>Usted ha solicitado que le sea enviada su contraseña al <b>Email</b>: " . $this->request->getData("Email");
					$message .= "<br>Su contraseña es: <b>" . $newPass ."</b></p><p>Si usted no hizo esta solicitud contáctenos inmediatamente.</p>";

					// Enviar mail
					$email = new Email();
					$r = $email->from(["no-reply@miedd.samnaz.org" => "Clic"])
					 ->to($this->request->getData("Email"))
					 ->emailFormat('html')
					 ->subject('Recuperación de contraseña')
					 ->send($message);
					$response = ['Respuesta' => 1, 'enviado' => $userId];
				}
			}

			// Respuesta
			$this->set(compact('response'));
            $this->set('_serialize', ["response"]);
		}
    }

/**
  * Purpose: obtener un parámetro
  *
  * Request method: GET.
  *
  * Use example:
  * http://miedd.samnaz.org/clic/Api/getparameter/Email_Contacto.json
  *
  * Result example:
  *{
  *  "Parameters": [
  *      {
  *          "Id": "Email_Contacto",
  *          "Value": "info@clic.com"
  *      }
  *  ]
  *}
  *
  * @param Integer $parameterId El id por el que se va a filtrar
  *
  * @return 2|Id, Value
  */
	public function getparameter($parameterId = NULL){
        if($this->request->is('GET')){

			// Si existe cache
			//Cache::delete('listmodels'.$brandId);
			if (($Models = Cache::read('getparameter'.$parameterId)) === false) {
               $this->loadModel('Parameters');
			   $this->set('Parameters', $this->Parameters
                                ->find('all')
                                 ->select(['Id' => 'Parameters.Id'
                                        , 'Value' => 'Parameters.Value'
                                        ])
                                   ->where(['Parameters.Id' => $parameterId])
                                   );

				// Crear cache
                Cache::write('getparameter'.$parameterId, $Models);
			}
			$this->set('_serialize', ['Parameters']);
        }
    }

	/*
	Purpose: iniciar sesión
	*
	* Request Mehod: POST
	*
	* Use example
	* http://miedd.samnaz.org/clic/Api/login.json
	*
	* Result example:
	* {
    *"response": {
    *   "Respuesta": 1,
    *    "enviado": 506
    *}
	*}
	*
	* @return 2|Respuesta, enviado
    */
    public function login(){
        if($this->request->is('POST')){
			// Buscar el usuario
			$userTable = TableRegistry::get('Users');

			// Model
			$this->loadModel('Users');

			// Encriptar password
			/*$usr = $this->Users->newEntity();
			//
			$usr->Password = (new DefaultPasswordHasher)->hash($this->request->getParam("Password"));
			//$usr->Password=$this->request->getParam("Password")

			// Consultar los datos del usuario
			$queryUser = $this->Users
					->find('all')
					->select('Id')
					->where(['Users.Email' => $this->request->getParam("Email"), 'Password' => (new DefaultPasswordHasher)->hash($this->request->getParam("Password"))])
					->first();
			$userId = $queryUser['Id'];*/
			$user = $this->Auth->identify();

            if ($user){
                // Log
				$usersTable = TableRegistry::get('UserLogs');
				$userl = $usersTable->newEntity();
				$userl->UserId = $user['Id'];
				$userl->Action = 'Login';
				$userl->IpAddress = $this->request->clientIp();
				$userl->Created = date('Y-m-d H:i:s');
				$usersTable->save($userl);

				// Resp.
				$response = ['UserId' => $user['Id'], 'Name' => $user['Name'], 'LastName' => $user['LastName']];
            }else {
				$name='';
				$lastName = '';
				$userId=0;
				$response = ['UserId' => $userId, 'Name' => $name, 'LastName' => $lastName];
			}

			// Respuesta json
			$this->set(compact('response'));
            $this->set('_serialize', ["response"]);
		}
    }

	/**
	* Purpose: Registrar un usuario nuevo en la plataforma
	*
	* Request method: POST.
	*
	* Use example:
	* http://miedd.samnaz.org/clic/Api/register.json
	*
	* Result example:
	* {"response": { "UserId": 438,"Name": "Tst", "LastName": "rr"}}
	*
	* @return 3| UserId, Name, LastName
	*/
	public function register() {
		// Validar que la peticion sea de tipo POST
		if ($this->request->is('POST')) {
			$usersTable = TableRegistry::get('Users');
			$userExists = $usersTable->exists(['Users.Username' => $this->request->getData("Email")]);

			// Si el usuario no existe
			if(!$userExists){
				$name=$this->request->getData("Name");
				$lastName=$this->request->getData("LastName");
				$email = $this->request->getData("Email");

				//Se registra el nuevo usuario
				$userdocid = $this->request->getData("DocTypeId").$this->request->getData("DocId");
				$userRec = $usersTable->newEntity();
				$userRec->Name = $name;
				$userRec->LastName = $lastName;

				// Si no es interno
				if ($this->request->getData("AuthenticationMethodId") !='3'){
					// Si no vino email de la red social
					$pos = strrpos($email, "@facebook");
					$pos2 = strrpos($email, "@google");
					if ($pos || $pos2)
						$userRec->Email = '';
					else
						$userRec->Email = $email;
				}
				else
					$userRec->Email = $email;
				$userRec->Password = $this->request->getData("Password");
				$userRec->CountryId = $this->request->getData("CountryId");
				$userRec->City = $this->request->getData("City");
				$userRec->Username = $this->request->getData("Email");
				$userRec->DocId = $userdocid;
				$userRec->Phone = $this->request->getData("Phone");
				$userRec->BirthDate = $this->request->getData("BirthDate");
				$userRec->Gender = $this->request->getData("Gender");
				$userRec->UserStatusId = $this->request->getData("AuthenticationMethodId")=="3"?3:1; // Si es interno por confirmar
				$userRec->AuthenticationMethodId = $this->request->getData("AuthenticationMethodId");
				$userRec->Created = date('Y-m-d H:i:s');
				$userRec->Modified = date('Y-m-d H:i:s');

				// Se guarda el nuevo usuario
				if ($usersTable->save($userRec)) {
					// Obtener el Id del usuario registrado
					$userId = $userRec->Id;

					// Rol - 3 cliente
					$urolsTable = TableRegistry::get('UserRols');
					$urolRec = $urolsTable->newEntity();
					$urolRec->RolId = 3;
					$urolRec->UserId = $userId;

					// Guardar rol
					if ($urolsTable->save($urolRec)) {
						// Email
						if ($this->request->getData("AuthenticationMethodId") =='3'){
							$varURL = $this->url;
							$link = "<a href='".$varURL."confirm?code=".$userdocid."&id=".$this->request->getData("Email")."&sec=".strlen($name)."&seed=".date('YmdHis')."&t=".$userId."&x=".($userId*10)."'>aquí</a>";
							$message = "<div align='center'><img width='300px' src='http://miedd.samnaz.org/clic/img/logo.png' alt='Clic'/></div>Estimad@: <b>". $name . " ". $lastName."</b>";
							$message .= "<p>Usted se ha registrado en Clic con el <b>Email</b>: " . $this->request->getData("Email");
							$message .= "<br>Para confirmar su registro haga click <b>" . $link ."</b></p><p>Si usted no hizo este registro contáctenos inmediatamente.</p>";

							// Enviar mail
							$email = new Email();
							$r = $email->from(["no-reply@miedsam.com" => "Clic"])
							 ->to($this->request->getData("Email"))
							 ->emailFormat('html')
							 ->subject('Registro en Clic')
							 ->send($message);

							// Cero para que proceda a confirmar su registro
							$userId = 0;
						}
						else
						{
							// Log
							$usersTable = TableRegistry::get('UserLogs');
							$user1 = $usersTable->newEntity();
							$user1->UserId = $userId;
							$user1->Action = 'Login';
							$user1->IpAddress = $this->request->clientIp();
							$user1->Created = date('Y-m-d H:i:s');
							$usersTable->save($user1);
						}
					}
				}

			// Si el usuario existe y no es registro interno
			} else if ($this->request->getData("AuthenticationMethodId") !='3') {
				// Actualizamos los datos del usuario con la nueva informacion que suministra.
				$usersTable->updateAll(['Name' => $this->request->getData("Name")],
									  ['LastName' =>  $this->request->getData("LastName")],
									  ['Modified' => date('Y-m-d H:i:s')]);

				// Consultar los datos
				$this->loadModel('Users');
				$user = $this->Users
						->find('all')
						->select(['Id', 'Name', 'LastName'])
						->where(['Users.Username' => $this->request->getData("Email")])
						->first();
				$userId = $user->Id;
				$name = $user->Name;
				$lastName = $user->LastName;

				// Log
				$usersTable = TableRegistry::get('UserLogs');
				$user1 = $usersTable->newEntity();
				$user1->UserId = $userId;
				$user1->Action = 'Login';
				$user1->IpAddress = $this->request->clientIp();
				$user1->Created = date('Y-m-d H:i:s');
				$usersTable->save($user1);
			}
			else{
				$name='Usuario ya existe';
				$lastName='';
				$userId = -1;
			}

			// Resp.
			$response = array("UserId" => $userId, "Name" => $name, "LastName" => $lastName);
			$this->set(compact('response'));
			$this->set('_serialize', ["response"]);
		}
	}

	/**
  * Purpose: Obtener los datos del usuario
  *
  * Request method: get.
  *
  * Use example:
  * "http://miedd.samnaz.org/clic/Api/getuser/506.json",
  *
  * Result example:
  * {
  *    "user": [
  *        {
  *           "UserId": 506,
  *           "Name": "Lember",
  *            "LastName": "Romero",
  *            "Phone": "1",
  *            "BirthDate": "2017-03-30T00:00:00",
  *			   "Email": "lromero@medianet.com.ve",
  *            "ID": "13727387"
  *       }
  *    ]
  *}
  *
  * @param Integer $userId El id del usuario
  *
  * @return 8|UserId, Name, LastName, City, BirthDate, TipoID, ID, Email
  */
	public function getuser($userId = NULL) {

		//Cache::delete('getuser'.$userId);
        //Validar que la peticion sea de tipo get
        if ($this->request->is('GET')) {
			// Importar el modelo
			$this->loadModel('Users');
			$this->set('user', $this->Users
								->find('all')
								->select(['UserId' => 'Users.Id'
									, 'Name' => 'Users.Name'
									, 'LastName' => 'Users.LastName'
									, 'Phone' => 'Users.Phone'
								   , 'Email' => 'Users.Email'
									, 'TipoID' => 'SUBSTRING(Users.DocId,1,1)'
									, 'ID' => 'SUBSTRING(Users.DocId, 2)' 
									, 'TeacherId' => 'Users.TeacherId'
									, 'TeacherName' => "(Select concat(Name, ' ', LastName) from Users U where U.Id = Users.TeacherId)"
									, 'CountryId' => 'Users.CountryId'
									, 'CountryName' => "(Select concat(Name) from Countries U where U.Id = Users.CountryId)"
									, 'Coins' => 'Users.Coins'
									, 'Gender' => 'Users.Gender'
									, 'Image' => 'Users.Image'
									 , 'BirthDate' => 'Users.BirthDate'])
								 ->where(['Users.Id' => $userId ])
								);
            $this->set('_serialize', ['user']);
        }
    }

	/**
	* Purpose: guardar datos del usuario
	*
	* Request method: POST.
	*
	* Use example:
	* http://miedd.samnaz.org/clic/Api/updateuser.json
	*
	* Result example:
	* {"response": { "UserId": 1}}
	*
	* @return 2| UserId
	*/
	public function updateuser() {
		// Validar que la peticion sea de tipo POST
		if ($this->request->is('POST')) {
			$this->loadModel('Users');

			// Cambiar datos
			$userTable = TableRegistry::get('Users');
            $Id = $this->Users->get($this->request->getData("UserId"));
			$Id->Name = $this->request->getData("Name");
			$Id->LastName = $this->request->getData("LastName");
			$Id->BirthDate =$this->request->getData("BirthDate");
			$Id->Phone = $this->request->getData("Phone");
			$Id->DocId = $this->request->getData("ID");
			$Id->Email = $this->request->getData("Email");
			$Id->Gender = $this->request->getData("Gender");
			$Id->CountryId = $this->request->getData("CountryId");
			$Id->TeacherId = $this->request->getData("TeacherId");
			$Id->Image = $this->request->getData("Image"); 
			$Id->Modified = date('Y-m-d H:i:s');

			// Guardamos los datos del Usuario
			$userTable->save($Id);
			$response = array("UserId" => $this->request->getData("UserId"));

			$this->set(compact('response'));
			$this->set('_serialize', ["response"]);
		}
	}
	
	/*
	Purpose: actualizar clave del usuario
	*
	* Request Mehod: POST
	*
	* Use example
	* http://miedd.samnaz.org/clic/Api/changepassword.json
	*
	* Result example:
	* {
    *"response": {
    *   "Respuesta": 506
    *}
	*}
	*
	* @return 2|Respuesta, enviado
    */
    public function changepassword(){
        if($this->request->is('POST')){
			// Consultar los datos del usuario
			$this->loadModel('Users');
			$pTable = TableRegistry::get('Users');

			// Cambiar clave
			$newPass = $this->request->getData("Password");
			$Id = $this->Users->get($this->request->getData("UserId"));
			$Id->Password = $newPass;
			$Id->Modified = date('Y-m-d H:i:s');

			// Guardamos los datos del Usuario
			$pTable->save($Id);
			$response = array("Respuesta" => $this->request->getData("UserId"));

			// Respuesta
			$this->set(compact('response'));
            $this->set('_serialize', ["response"]);
		}
    }
	
	/**
	* Purpose: Registrar un usuario - lección
	*
	* Request method: POST.
	*
	* Use example:
	* https://miedd.samnaz.org/setuserlesson.json
	*
	* Result example:
	{
		"response": {
			"userLessonId": 4
		}
	}
	*
	* @return 1| UserLessonId
	*/
	public function setuserlesson() {
		$this->request->allowMethod(['post']);
		$userLessonId=0;
		
		// Usr. Id 
		$userId = $this->request->getData('UserId');
		
		// Table
		$connection = ConnectionManager::get('default');					
		$usersTable = TableRegistry::get('UserLessons');
		$pl = $connection->execute("delete from UserLessons where UserId=$userId and LessonId = " . $this->request->getData('LessonId'));
				
		// New rec.
		$userRec = $usersTable->newEntity();
		$userRec->UserId = $userId;			
		$userRec->Created = date('Y-m-d H:i:s');		
		$userRec->LessonId = $this->request->getData('LessonId');
		$userRec->Coins = $this->request->getData('Coins');
		$userRec->Stars = $this->request->getData('Stars');
		$userRec->Correct = $this->request->getData('Correct');
		$userRec->Incorrect = $this->request->getData('Incorrect');
				
		// Se guarda el reg.
		if ($usersTable->save($userRec)) {
			// Obtener el Id del registro
			$userLessonId = $userRec->Id;
			$pl = $connection->execute("update Users set Coins = Coins + ".$this->request->getData('Coins') ." where Id=$userId");
		
		} else {
			throw new Exception('Error al guardar');
		}

		// Resp.
		$response = array("userLessonId" => $userLessonId);
		$this->set(compact('response'));
		//$this->viewBuilder()->setOption('serialize', ["response"]);		
		$this->set('_serialize', ["response"]);
	}

	/*
	  * @param Integer $bookId El id del libro
	  *
	  * @return 8|UserId, Name, LastName, City, BirthDate, TipoID, ID, Email
	  */
	public function userlessons($bookId = NULL, $userId = NULL) {
		$this->request->allowMethod(['get']);
		
		// Importar el modelo
		$this->loadModel('UserLessons');
		$this->set('userLessons', $this->UserLessons
							->find('all')							
							->contain('Lessons')->contain('Lessons.Books')
							->contain('Lessons.LessonTasks')->contain('Lessons.LessonTasks.UserLessonTasks')
							->where(['Books.Id' => $bookId ])->where(['UserLessons.UserId' => $userId ])
							->order(['Lessons.Day' => 'ASC'])->toArray());
		$this->set('_serialize', ["userLessons"]);
    }

	/**
	* Purpose: Registrar un usuario - monedas
	*
	* Request method: POST.
	*
	* Use example:
	* https://miedd.samnaz.org/setusercoins.json
	*
	* Result example:
	{
		"response": {
			"userCoinId": 4
		}
	}
	*
	* @return 1| userCoinId
	*/
	public function setusercoins() {
		$this->request->allowMethod(['post']);
		$userCoinId=0;
		
		// Usr. Id 
		$userId = $this->request->getData('UserId');
		
		// Table
		$connection = ConnectionManager::get('default');					
		$usersTable = TableRegistry::get('UserCoins');
				
		// New rec.
		$userRec = $usersTable->newEntity();
		$userRec->UserId = $userId;			
		$userRec->Created = date('Y-m-d H:i:s');		
		$userRec->Category = $this->request->getData('Category');
		$userRec->Coins = $this->request->getData('Coins');
				
		// Se guarda el reg.
		if ($usersTable->save($userRec)) {
			// Obtener el Id del registro
			$userCoinId = $userRec->Id;
			$pl = $connection->execute("update Users set Coins = Coins - ".$this->request->getData('Coins') ." where Id=$userId");
		
		} else {
			throw new Exception('Error al guardar');
		}

		// Resp.
		$response = array("userCoinId" => $userCoinId);
		$this->set(compact('response'));
		//$this->viewBuilder()->setOption('serialize', ["response"]);		
		$this->set('_serialize', ["response"]);
	}

	/*
	  * @param Integer $userId El id del usuario
	  *
	  * @return 2|Quant, Category
	  */
	  public function usercoins($userId = NULL) {
		$this->request->allowMethod(['get']);
		
		// Importar el modelo
		$this->loadModel('UserCoins');
		$query = $this->UserCoins
							->find('all')							
							->where(['UserId' => $userId ]);

		$this->set('UserCoins', $query->select(['Quant' => $query->func()->sum('Coins'),
			'Category' => 'Category'])->group('Category')->toArray());
		$this->set('_serialize', ["UserCoins"]);
    }

	/*
	  * @param Integer $lessonId El id de lección
	  *
	  * @return 2|Id, Description
	  */
	  public function lessontasks($lessonId = NULL) {
		$this->request->allowMethod(['get']);
		
		// Importar el modelo
		$this->loadModel('LessonTasks');
		$this->set('LessonTasks', $this->LessonTasks
							->find('all')							
							->where(['LessonId' => $lessonId ])->toArray());
		$this->set('_serialize', ["LessonTasks"]);
    }

	/*
	  * @param Integer $lessonId El id de lección
	  *
	  * @return 2|Id, Description
	  */
	  public function lessonchats($lessonId = NULL, $teacherId=NULL, $date = NULL) {
		$this->request->allowMethod(['get']);
		
		// Importar el modelo
		$this->loadModel('LessonChats');
		$this->set('LessonChats', $this->LessonChats
					->find('all')->contain('Users')->select(['Id' => 'LessonChats.Id',  'UserId' => 'Users.Id', 'Name' => 'Name','LastName' => 'LastName',
					'Image' => 'Image', 'Created' => 'LessonChats.Created', 'Description' => 'LessonChats.Description'])					
					->where(['LessonChats.Created >' => $date ])->where(['LessonId' => $lessonId ])
					->andWhere(['OR' => [['Users.TeacherId' => $teacherId ], ['Users.Id' => $teacherId ]]])
					->order(['LessonChats.Created' => 'DESC'])->toArray());
		$this->set('_serialize', ["LessonChats"]);
    }

	/**
	* Purpose: Registrar un usuario - monedas
	*
	* Request method: POST.
	*
	* Use example:
	* https://miedd.samnaz.org/setusercoins.json
	*
	* Result example:
	{
		"response": {
			"userCoinId": 4
		}
	}
	*
	* @return 1| userCoinId
	*/
	public function setlessonchat() {
		$this->request->allowMethod(['post']);
		$lessonchatId=0;
		
		// Usr. Id 
		$userId = $this->request->getData('UserId');
		
		// Table
		$connection = ConnectionManager::get('default');					
		$usersTable = TableRegistry::get('LessonChats');
				
		// New rec.
		$userRec = $usersTable->newEntity();
		$userRec->UserId = $userId;
		$userRec->Created = date('Y-m-d H:i:s');
		$userRec->LessonId = $this->request->getData('LessonId');
		$userRec->Description = $this->request->getData('Description');
				
		// Se guarda el reg.
		if ($usersTable->save($userRec)) {
			// Obtener el Id del registro
			$lessonchatId = $userRec->Id;
		
		} else {
			throw new Exception('Error al guardar');
		}

		// Resp.
		$response = array("lessonchatId" => $lessonchatId);
		$this->set(compact('response'));
		//$this->viewBuilder()->setOption('serialize', ["response"]);		
		$this->set('_serialize', ["response"]);
	}

	/**
	* Purpose: Registrar un usuario - tareas
	*
	* Request method: POST.
	*
	* Use example:
	* https://miedd.samnaz.org/setuserlessontasks.json
	*
	* Result example:
	{
		"response": {
			"userCoinId": 4
		}
	}
	*
	* @return 1| userCoinId
	*/
	public function setuserlessontasks() {
		$this->request->allowMethod(['post']);
		$userLessonTaskId=0;
		
		// Usr. Id 
		$userId = $this->request->getData('UserId');
		
		// Table
		$connection = ConnectionManager::get('default');					
		$usersTable = TableRegistry::get('UserLessonTasks');
				
		// New rec.
		$userRec = $usersTable->newEntity();
		$userRec->UserId = $userId;			
		$userRec->Created = date('Y-m-d H:i:s');		
		$userRec->Description = $this->request->getData('Description');
		$userRec->TaskId = $this->request->getData('TaskId');
		$pl = $connection->execute("delete from UserLessonTasks where Id=$userId and TaskId =" . $this->request->getData('TaskId'));
			
		// Se guarda el reg.
		if ($usersTable->save($userRec)) {
			// Obtener el Id del registro
			$userLessonTaskId = $userRec->Id;
		} else {
			throw new Exception('Error al guardar');
		}

		// Resp.
		$response = array("userLessonTaskId" => $userLessonTaskId);
		$this->set(compact('response'));
		$this->set('_serialize', ["response"]);
	}

	/*
	  * @param Integer $lessonId El id de lección
	  *
	  * @return 2|Id, Description
	  */
	  public function lessonchatusers($lessonId = NULL, $teacherId=NULL) {
		$this->request->allowMethod(['get']);
		
		// Importar el modelo
		$this->loadModel('LessonChats');
		$this->set('LessonChats', $this->LessonChats
							->find('all')->contain('Users')->select(['Name' => 'Name','LastName' => 'LastName','Image' => 'Image'])					
							->distinct(['Name', 'LastName', 'Image'])->where(['LessonId' => $lessonId ])
							->andWhere(['OR' => [['Users.TeacherId' => $teacherId ], ['Users.Id' => $teacherId ]]])
							->order(['LessonChats.Created' => 'DESC'])->toArray());
		$this->set('_serialize', ["LessonChats"]);
    }

	/*
	  * @param Integer $lessonId El id de lección
	  * @param Integer $userId El id de user
	  *
	  * @return 2|D, Created
	  */
	  public function userlessontasks($lessonId = NULL, $userId = NULL) {
		$this->request->allowMethod(['get']);
		
		// Importar el modelo
		$this->loadModel('UserLessonTasks');
		$this->set('userLessonsTasks', $this->UserLessonTasks
							->find('all')							
							->contain('LessonTasks')
							->where(['LessonId' => $lessonId ])->where(['UserLessonTasks.UserId' => $userId ])
							->order(['TaskId' => 'ASC'])->toArray());
		$this->set('_serialize', ["userLessonsTasks"]);
    }
	
}

?>
