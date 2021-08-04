<?php
namespace App\Controller;

use App\Controller\AppController;

class DashboardController extends AppController{

        public function index(){

                $userId = $this->Auth->user('Id');

		$pageTitle = "Módulo Administrativo";

                $breadcrumbs = '<li>Administrador</li>
                                <li class="active">Home</li>';

                $this->set('pageTitle', $pageTitle);
                $this->set('_serialize', ['pageTitle']);
                $this->set('breadcrumbs', $breadcrumbs);
                $this->set('_serialize', ['breadcrumbs']);

                $this->set('userId', $userId);
                $this->set('_serialize', ['userId']);
                
	}

}
?>
