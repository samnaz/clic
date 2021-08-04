<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Http\Middleware\CsrfProtectionMiddleware;


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	public $url;
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
		$this->url = 'http://miedd.samnaz.org/';
        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
		$this->loadComponent('Auth', [
	        'authenticate' => [
	            'Form' => [
	                'fields' => [
	                    'username' => 'Email',
	                    'password' => 'Password'
	                ]  ,
					'finder' => 'auth'				
	            ]
	        ],
	            
	        'loginAction' => [
	                'controller' => 'Login',
	                'action' => 'index'
	        ],

	        'loginRedirect' => [
			        'controller' => 'Dashboard',
			        'action' => 'index',
			        'plugin' => false,
		    ],

	        'logoutRedirect' => [
	                'controller' => 'Login', 
	                'action' => 'index'
	        ]
	        ]);
			
		// Pass settings in
		$this->Auth->setConfig('authenticate', [
			//'Basic' => ['userModel' => 'Users'],
			'Form' => ['userModel' => 'Users']
		]);
		//$this->Auth->allow('login');
		$this->Auth->allow(['all']);
    }
	
	/**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->getType(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
	
	 public function isAuthorized() {
		// Aquí se debe validar la url contra los permisos
        return true;
    }


    public function beforeFilter(Event $event) {
		$this -> set('user', $this->Auth->user());
		//$this->getEventManager()->makeMess($this->Csrf);
		
		//Configure::write('Config.timezone', 'America/Caracas');
		parent::beforeFilter($event);
    }
	
	public function middleware($middlewareQueue) {
		$options = [
			
		];
		$csrf = new CsrfProtectionMiddleware($options);		
		$middlewareQueue->add($csrf);
		/*if(strpos($_SERVER['REQUEST_URI'], 'Api')===false){
			$middlewareQueue->add($csrf);
		}*/
		
		/*$csrf->whitelistCallback(function (ServerRequestInterface $request) {
            $params = $request->getAttribute('params');
            return $params['controller'] !== 'Api';
        });*/
		
		return $middlewareQueue;
	}
}
