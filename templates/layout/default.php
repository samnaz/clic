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
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <!-- Collapse Menu Icon -->
            <div class="collapse-icon">
                <a href="javascript:void(0)" id="toggle-btn" onclick="collapseMenu()"><i class="glyphicon glyphicon-chevron-left"></i></a>
            </div>
            <!-- /Collapse Menu Icon -->
            <!-- Logo -->
            <?= 
                $this->Html->image("/img/logo.png", [
                    "id" => "logo",
                    "class" => "img-responsive logo",
                    'url' => ['controller' => 'Dashboard', 'action' => 'index']
                ]);
            ?>
            <!-- /Logo -->
            <!-- Menu -->  
            <?= $this->cell('Partial::menu', [$userId]); ?>
            <!-- /Menu -->
        </div>
        <!-- /Sidebar -->
                <div class="web-header">
                    <div class="row">
                        <!-- Icon Section -->
                        <div class="col-sm-1">
                            <h1><i class="glyphicon glyphicon-user top-icon"></i></h1>
                        </div>
                        <!-- /Icon Section -->
                        <div class="col-sm-6">
                            <!-- Title Section -->
                            <div class="section-sitemap-div">
                                <h1 class="section-title"> <?= $pageTitle ?></h1>
                                <ol class="breadcrumb page-navigation">
                                    <?= $breadcrumbs; ?>
                                </ol>
                            </div>
                            <!-- /Title Section -->                           
                        </div>
                        <div class="col-sm-5">                            
                            <div class="float-right">
                                <div class="user-login">
                                    

                                    Bienvenido, 
                                    <?= 
                                    $this->Html->link($this->cell('Partial::userlogin', [$userId]),[
                                                            'controller' => 'Accounts', 
                                                            'action' => 'myaccount', @$userId]);
                                    ?>
                                </div>
                                <div class="logout text-right">
                                        <?= $this->Html->link('Cerrar Sesión',[
                                                    'controller' => 'Login', 
                                                    'action' => 'logout']
                                            );
                                        ?>
                                        <span class="glyphicon glyphicon-log-out"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <!-- Content -->
        <div id="page-content-wrapper">
            <?= $this->Flash->render() ?>

            <?= $this->fetch('content') ?>
        </div>
        <footer>
            </div>
            <!-- /Wrapper -->
        </footer>
    </div>
    <script type="text/javascript">

        $(document).ready(function(){
            var menu = window.localStorage.getItem("menu");
            
            if(menu == null){
                menu = "open";
            }

            if(menu == "open"){
                $("#wrapper").addClass("toggled");
                $("#sidebar-wrapper").addClass("open");
                $(".glyphicon-chevron-left").css("transform","rotate(180deg)");
                $("#logo").attr("src","/img/logo-collapsed.png");
                $("#logo").addClass("open");
                $("#menu").addClass("open");
                $(".submenu").hide(500);
            }
            else if(menu == "close"){
                $("#wrapper").removeClass("toggled");
                $("#sidebar-wrapper").removeClass("open");
                $(".glyphicon-chevron-left").css("transform","rotate(0deg)");
                $("#logo").attr("src","/img/logo.png");
                $("#logo").removeClass("open");
                $("#menu").removeClass("open");
                $(".submenu").show(500);
            }
        });

        function collapseMenu(){

            if($("#wrapper").hasClass("toggled")){
                $("#wrapper").removeClass("toggled");
                $("#sidebar-wrapper").removeClass("open");
                $(".glyphicon-chevron-left").css("transform","rotate(0deg)");
                $("#logo").attr("src","/img/logo.png");
                $("#logo").removeClass("open");
                $("#menu").removeClass("open");
                $(".submenu").show(500);
                window.localStorage.removeItem("menu");
                window.localStorage.setItem("menu", "close");
            }
            else{
                $("#wrapper").addClass("toggled");
                $("#sidebar-wrapper").addClass("open");
                $(".glyphicon-chevron-left").css("transform","rotate(180deg)");
                $("#logo").attr("src","/img/logo-collapsed.png");
                $("#logo").addClass("open");
                $("#menu").addClass("open");
                $(".submenu").hide(500);
                window.localStorage.removeItem("menu");
                window.localStorage.setItem("menu", "open");
            }

        }

        function ShowSubMenu(id){

            var menuLinks = $("ul [name=subMenu]");

            $.each(menuLinks,function(itemIndex,itemData){

                if($(itemData).attr("id") == "submenu" + id){

                    if($("#submenu" + id).hasClass("open")){
                        $("#submenu" + id).removeClass("open");
                    }
                    else{
                        $("#submenu" + id).addClass("open");
                    }

                }
                else{
                    if($(itemData).hasClass("open")){
                        $(itemData).removeClass("open");
                    }
                }

            });

        }

        function ShowSonSubMenu(id){

            var menuLinks = $("ul [name=sonSubMenu]");

            $.each(menuLinks,function(itemIndex,itemData){

                if($(itemData).attr("id") == "sonsubmenu" + id){

                    if($("#sonsubmenu" + id).hasClass("open")){
                        $("#sonsubmenu" + id).removeClass("open");
                    }
                    else{
                        $("#sonsubmenu" + id).addClass("open");
                    }

                }
                else{
                    if($(itemData).hasClass("open")){
                        $(itemData).removeClass("open");
                    }
                }

            });

        }

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })

    </script>
    <!-- acordion -->
    <script>
        var acc = document.getElementsByClassName("myaccordion");
        var i;
        $( ".myaccordion" ).append( "<div class='up'></div>" );
        for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("activeCord");
            var panel = this.nextElementSibling;
            var up = panel.nextElementSibling;
            if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
            } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
            } 
        });
        }
        $('#activeAcord').click()
    </script>
    <!-- acordion -->

</body>
</html>
