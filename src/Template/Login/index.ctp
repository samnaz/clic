<?php
    $this->layout = NULL;
    $cakeDescription = 'CakePHP: the rapid development php framework';
?>
<?=$this->Html->docType();?>
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
    <?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css'); ?>    
    <?= $this->Html->css('responsive.css') ?>

    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js'); ?>
	<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/fontawesome.min.js'); ?>
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.js'); ?>
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js'); ?>
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.16.0/bootstrap-table.min.js'); ?>
	<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.16.0/bootstrap-table-locale-all.min.js'); ?>
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'); ?>

    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.16.0/extensions/export/bootstrap-table-export.min.js'); ?>
    <?= $this->Html->script('tableExport.js'); ?>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

</head>
<body>

    <div class="bgLogin">

        <div class="row">

            <div class="col-sm-12 col-md-12 col-xs-12 text-center " style="padding-top:40px">
            <div class="boxBF">
                <img class="biblia animated fadeInLeft" src="/clic/img/biblia.png" alt="biblia">
                <img class="flecha animated fadeInRight delay-1s" src="/clic/img/flecha.png" alt="flecha">
            </div> 
            <img class="mouse animated fadeInRight " src="/clic/img/mouse.png" alt="mouse">
                <!-- Logo -->
                <?= 
                    $this->Html->image("logo.png", [
                        "id" => "logo",
                        "class" => "img-responsive logo animated zoomIn"
                    ]);
                ?>
                <!-- /Logo -->

                <br>
                <?= $this->Flash->render() ?>
				<?= $this->Flash->render('auth');?>
                <!-- Login Form -->
                <div class="form-login">

                    <?php echo $this->Form->create();?>

                        <div class="form-group">
                            <div>
                                <div class="input-group">
                                    <span class="input-group-addon no-radius"><span class="glyphicon glyphicon-user"></span></span>
                                    <?php echo $this->Form->text('Email', ['class' => 'form-control no-radius', 'placeholder' => 'Email...','type'=>'Email', 'oninput' => 'InvalidMsg(this)', 'oninvalid' => 'InvalidMsg(this)' ,'required']);?>                                
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <div class="input-group">
                                    <span class="input-group-addon no-radius"><span class="glyphicon glyphicon-lock"></span></span>
                                    <?php echo $this->Form->password('Password', ['class' => 'form-control no-radius','oninput' => 'InvalidMsg(this)','type'=>'password', 'oninvalid' => 'InvalidMsg(this)', 'placeholder' => 'Password...', 'required']);?>                                                                
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0px">
                            <div class="clearfix">
                                <div class="pull-right" style="width: 100%;">
                                    <button type="submit" style="width: 100%;" class="btn btn-success " id="login">Login</button>                               
                                </div>
                            </div>
                        </div>
                    <?= $this->Form->end(); ?>

                </div>
                <!-- END Login Form -->

            </div>

        </div>

    </div>
                    <div style="position: absolute;margin: auto;left: 0;right: 0;bottom: 15px;text-align: center;"><a href="https://miedd.samnaz.org/clic/pages/privacity" target="_blank" rel="noopener noreferrer">Política de privacidad</a></div>
    <script type="text/javascript">

        function InvalidMsg(textbox) {
    
            if (textbox.value == '') {
                textbox.setCustomValidity('This field is required.');
            }
            else if(textbox.validity.typeMismatch){
                textbox.setCustomValidity('please enter a valid email address.');
            }
            else {
                textbox.setCustomValidity('');
            }
            return true;
        }
    </script>

</body>
</html>