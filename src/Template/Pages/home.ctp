<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->layout = false;

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace src/Template/Pages/home.ctp with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'Clic';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>
    <link rel="icon" type="image/png" href="/clic/img/icon.png">
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('home.css') ?> 
    <?= $this->Html->css('styles.css') ?>
        <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
    <style>
        #toolbar{
            display:none !important;
        }
    </style>
</head>
<body>
    <div class="bgHome">
    <div class="scrollmenu">
        <a href="https://miedd.samnaz.org/clic/pages/home">Home</a>
        <a href="https://miedd.samnaz.org/clic/login">Login</a> 
    </div>
        <div class="row">        
            <div class="col-sm-12 col-md-12 col-xs-12 text-center " style="padding-top:40px">
                <div class="boxBF">
                    <img class="biblia animated fadeInLeft" src="/clic/img/biblia.png" alt="biblia">
                    <img class="flecha animated fadeInRight delay-1s" src="/clic/img/flecha.png" alt="flecha">
                </div> 
            </div>        
        </div>
        <img class="mouse animated fadeInRight " src="/clic/img/mouse.png" alt="mouse"> 
        <img class="telefonos animated fadeInUp " src="/clic/img/telefonos.png" alt="mouse">
        
    </div>
        <div class="row">
            <div class="seccion1">
                <div class="col-md-6">
                    <img class="tel-vertical animated fadeInUp " src="/clic/img/tel-vertical.png" alt="mouse">
                </div>
                <div class="col-md-6 boxBlue">
                    <h3>52 lecciones para adolescentes y jóvenes</h3>
                    <p>Clic es un material de 52 lecciones que te invita conectarte con Cristo y su Palabra. Este material cuenta con hojas de trabajo fotocopiables para 2 grupos de alumnos, adolescentes de 12 a 17 años y jóvenes de 18 a 25 años. A la vez este material contiene recursos para la enseñanza para cada grupo de edad.                      
                    </p>
                    <p>Clic está desarrollado para adolescentes de 12 a 17 años y jóvenes de 18 a 23 años.</p>
                    <p>Clic es una colección de seis libros que le permite tener el material completo desde los 12 hasta los 23 años. A su vez cada libro Clic es independiente, lo cual le permite ir adquiriendo cada libro según sus necesidades. </p>
                    <p>Clic es un material 100% bíblico.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="seccion2">
                <div class="col-md-6 boxBlue"> 
                    <p>Clic es preparado por escritores hispanos de los 24 países dónde se habla español en el mundo, y con experiencia en los temas y el trabajo con adolescentes y jóvenes. Esto lo hace un material rico en perspectivas y enfoques de diferentes contextos y experiencias.</p>
                    <p>Clic - Libro 1 contiene el material completo para un año calendario con 52 lecciones agrupadas en seis unidades de temáticas actuales y un enfoque práctico. Vea aquí los temas de cada lección. <a href="https://drive.google.com/file/d/1TVJEWp6mJ_0DAx72aAtE6dzP7yMxa-Ww/view" target="_blank" style="color:white;" rel="noopener noreferrer">Ver</a></p>
                </div>
                <div class="col-md-6">
                    <img class="tel-vertical animated fadeInUp " src="/clic/img/tel-vertical-2.png" alt="mouse">
                </div>
            </div>
        </div>
        <div class="bgfooter"> 
            <div class="row">
                <div class="col-md-3">&nbsp;</div>
                <div class="col-md-6 boxBlue" style="text-align: center;">
                    <h3 style="font-size:60px;">Clic</h3>
                    <p>Los libros Clic tienen como objetivo crear una relación entre los adolescentes y jóvenes con Dios por medio de su Palabra y desafiarlos a una vida de obediencia radical.
                    </p> 
                </div>
                <div class="col-md-3">&nbsp;</div>
            </div>
            <div class="row">
                <img class="tel-footer animated fadeInUp " src="/clic/img/telefonos-footer.png" alt="mouse">
            </div>
        </div>
</body>
</html>
