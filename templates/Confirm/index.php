<?php
    $this->layout = NULL;
    $cakeDescription = 'CakePHP: the rapid development php framework';
?><!DOCTYPE html>
<html>
<head>
<?= $this->Html->charset() ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic" rel="stylesheet" type="text/css">
    
    <title>
        Clic SAMNAZ - Administrador :: Home
    </title>

    <?= $this->Html->meta(
		'icon.png',
		'/img/icon.png',
		['type' => 'icon']
	); ?>

    <?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css') ?>
    <?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.16.0/bootstrap-table.min.css') ?>
    <?= $this->Html->css('glyphicon-regular.min.css') ?>
    <?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css') ?>
    <?= $this->Html->css('simple-sidebar.css') ?>
    <?= $this->Html->css('styles.css') ?>
    <?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css') ?>
    <?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css') ?>

    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js'); ?>
	<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/fontawesome.min.js'); ?>
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.js'); ?>
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js'); ?>
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.16.0/bootstrap-table.min.js'); ?>
	<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.16.0/locale/bootstrap-table-es-ES.min.js'); ?>
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'); ?>

    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.16.0/extensions/export/bootstrap-table-export.min.js'); ?>
    <?= $this->Html->script('tableExport.js'); ?>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

</head>
<body>

    <div class="container">

        <div class="row">

            <div class="col-sm-6 col-sm-offset-3 text-center" style="padding-top:40px">
                <!-- Logo -->
                <?= 
                    $this->Html->image("logo.png", [
                        "id" => "logo",
                        "class" => "img-responsive logo"
                    ]);
                ?>
                <!-- /Logo -->

                <br>
                <?= $this->Flash->render() ?>
				

            </div>

        </div>

    </div>
</body>
</html>