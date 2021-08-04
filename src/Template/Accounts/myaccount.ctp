<?php
    use Cake\Routing\Router;
?>

<div class="div-container">
    <div class="row">
        <div class="col-sm-12">
            <!-- Accordion -->
                <!-- Login -->
                <div class="myaccordion">Login</div>
                <div class="panel">
                                <?php $userId = $user['Id']?>
                                <?php
                                    echo $this->Form->create(null, [
                                                        'url' => ['controller' => 'Accounts', 'action' => 'editlogin', $userId]
                                                        , 'id' => 'sbLoginForm', 'name' => 'sbLoginForm', 'type' => 'file']);

                                ?>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">Método de Autenticación:</label>
                                        <div class="radio col-sm-6">
                                            <?php
                                                $options = ['1' => 'Facebook', '2' => 'Twitter', '3' => 'Interno'];
                                                $attributes = ['legend' => false, 'label' => ['style' => 'font-weight:bold'],'name'=>'rbAuthenticationMethod', 'value'=>$user['AuthenticationMethodId']];

                                                echo $this->Form->radio('rbAuthenticationMethod', $options, $attributes);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">Identificación:</label>
                                        <?php
                                            echo $this->Form->text('txtUsername', ['required' => 'required', 'id' => 'txtUsername', 'class' => 'col-sm-4 form-input-style', 'placeholder' => 'Username...', 'name' => 'txtUsername', 'maxlength'=>'20', 'value' => $user['Username']]);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">Contraseña Nueva:</label>
                                        <?php
                                            echo $this->Form->hidden('hdPassword', ['id' => 'hdPassword', 'name' => 'hdPassword','value' => $user['Password']]);

                                            echo $this->Form->password('txtPassword', ['id' => 'txtPassword', 'class' => 'col-sm-4 form-input-style', 'placeholder' => '************','maxlength'=>'20', 'name' => 'txtPassword']);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">Verificar Contraseña:</label>
                                        <?php
                                            echo $this->Form->password('txtPasswordOld', ['id' => 'txtPasswordOld', 'name'=>'txtPasswordOld', 'class' => 'col-sm-4 form-input-style', 'placeholder' => '************','maxlength'=>'20', 'name' => 'txtPasswordOld']);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">Estatus:</label>
                                        <div class="radio col-sm-6">
                                            <?php
                                                $selected = $user['UserStatusId'];
                                                $options = ['1' => 'Activo', '2' => 'Inactivo'];
                                                $attributes = ['legend' => false, 'label' => ['style' => 'font-weight:bold'], 'name' => 'rbAccountStatus', 'id' => 'rbAccountStatus', 'value'=>$user['UserStatusId']];
                                                echo $this->Form->radio('rbAccountStatus', $options, $attributes);
                                            ?>
                                        </div>
                                    </div>
                                </div>                            
                                <!-- Boton de Update -->
                                <div class="row">
                                    <!-- Mensaje de alerta de validacion de formulario -->
                                    <div class="col-sm-12">
                                        <div class="alert alert-danger" id="alertForm" style="display:none;"></div>
                                    </div>
                                    <!-- Mensaje de alerta de validacion de formulario -->
                                    <div class="col-sm-12 text-right">
                                        <?php
                                            echo $this->Form->button('Actualizar', ['type' => 'button', 'class' => 'btn btn-submit', 'onclick' => 'validateLoginForm()']);
                                        ?>
                                    </div>
                                </div>
                                <?php echo $this->Form->end(); ?>
                                <!-- Boton de Update -->
                                <script type="text/javascript">

                                    function validateLoginForm() {

                                        var username = $("#txtUsername").val();
                                        var password = $("#hdPassword").val();
                                        var pass = $("input[name='txtPassword']").val();
                                        var passconfirm = $("input[name='txtPasswordOld']").val();
                                        var alertForm = $("#alertForm");

                                        if(!$('input:radio[name=rbAuthenticationMethod]:checked').val()){
                                        alertForm.show(500);
                                        alertForm.text("Debe elegir el método de autenticación.");
                                        return false;
                                        }
                                        if (username == "") {
                                            alertForm.show(500);
                                            alertForm.text("La identificación es requerida.");
                                            return false;
                                        }

                                        if(pass != "" & pass != passconfirm){
                                            //if (pass != passconfirm) {
                                            alertForm.show(500);
                                            alertForm.text('Las contraseñas no coinciden.');
                                            return false;
                                        // }
                                        }

                                        if(!$('input:radio[name=rbAccountStatus]:checked').val()){
                                            alertForm.show(500);
                                            alertForm.text("Debe elegir un estatus.");
                                            return false;
                                        }

                                        alertForm.hide(500);
                                        sbLoginForm.submit();
                                    }
                                </script>
                </div>
                <!-- /Login -->
                <!-- General -->
                <div class="myaccordion">General</div>
                <div class="panel">

                            <?php echo $this->Form->create(null, [
                                        'url' => ['controller' => 'Accounts',
                                                  'action' => 'editgeneral', $userId]
                                        , 'id' => 'editgeneralForm'
                                        , 'name' => 'editgeneralForm']); ?>

                            <div class="col-sm-6" style="padding:0;">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">Nombre:</label>
                                        <?php
                                            echo $this->Form->text('txtFirstName', ['required' => 'required', 'id' => 'txtFirstName', 'class' => 'col-sm-8 form-input-style', 'placeholder' => 'Peter','maxlength'=>'15', 'value' => $user['Name']]);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">Apellido:</label>
                                        <?php
                                            echo $this->Form->text('txtLastName', ['required' => 'required', 'id' => 'txtLastName', 'class' => 'col-sm-8 form-input-style', 'placeholder' => 'Newton','maxlength'=>'15', 'value' => $user['LastName']]);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">Fecha de Nacimiento:</label>
                                        <?php
                                            echo $this->Form->text('txtBirthDate', ['required' => 'required', 'id' => 'txtBirthDate', 'class' => 'col-sm-8 form-input-style', 'placeholder' => 'yyyy/mm/dd', 'maxlength'=>'10', 'value' => $brithdate]);
                                        ?>
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-sm-6" style="padding:0;">                                
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">Email:</label>
                                        <?php
                                            echo $this->Form->text('txtEmail', ['required' => 'required', 'id' => 'txtEmail'
                                            , 'class' => 'col-sm-8 form-input-style', 'placeholder' => 'youremail@mail.com','maxlength'=>'30', 'value' => $user['Email']]);
                                        ?>
                                    </div>
                                </div>
                               <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">País:</label>
                                        <?php
                                            echo $this->Form->input('cmbCountry', [
                                                'multiple' => false,
                                                'label' => false,
                                                'options' => $countries,
                                                'default' => $user['CountryId'],
                                                'empty' => 'Select an option...', TRUE,
                                                'class' => 'col-sm-8 form-input-style'
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">Teléfono:</label>
                                        <?php
                                            echo $this->Form->text('txtCellPhoneNumber', ['id' => 'txtCellPhoneNumber', 'class' => 'col-sm-8 form-input-style', 'placeholder' => '1234567890', 'maxlength'=>'20','type' => 'number', 'value' => $user['CelPhone']]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Boton de Update -->
                            <div class="row">
                                <!-- Mensaje de alerta de validacion de formulario -->
                                <div class="col-sm-12">
                                    <div class="alert alert-danger" id="alertForm2" style="display:none;"></div>
                                </div>
                                <!-- Mensaje de alerta de validacion de formulario -->
                                <div class="col-sm-12 text-right">
                                    <?php
                                        echo $this->Form->button('Actualizar', ['type' => 'button', 'class' => 'btn btn-submit', 'onclick' => 'validateGeneralForm()']);
                                    ?>
                                </div>
                            </div>
                            <!-- Boton de Update -->
                            <?php echo $this->Form->end(); ?>
                            <script type="text/javascript">

                                function validateGeneralForm() {

                                    var firstName = $("#txtFirstName").val();
                                    var lastName = $("#txtLastName").val();
                                    var birthdate = $("#txtBirthDate").val();
                                    var cellPhone = $("#txtCellPhoneNumber").val();
                                    var email = $("#txtEmail").val();
                                    var alertForm = $("#alertForm2");
                                    var generalForm = $("#generalForm");

                                    if (firstName == "") {
                                        alertForm.show(500);
                                        alertForm.text("El nombre es requerido.");
                                        return false;
                                    }
                                    if (lastName == "") {
                                        alertForm.show(500);
                                        alertForm.text("El apellido es requerido.");
                                        return false;
                                    }
                                    if (birthdate == "") {
                                        alertForm.show(500);
                                        alertForm.text("La fecha de nacimiento es requerida.");
                                        return false;
                                    }
                                    if (cellPhone == "") {
                                        alertForm.show(500);
                                        alertForm.text("El teléfono es requerido.");
                                        return false;
                                    }
                                    if (email == "") {
                                        alertForm.show(500);
                                        alertForm.text("El email es requerido.");
                                        return false;
                                    }
                                    if(IsEmail(email)==false){
                                        alertForm.show(500);
                                        alertForm.text("El email es inválido.");
                                        return false;
                                    }                                  
                                    alertForm.hide(500);
                                    editgeneralForm.submit();
                                }

                                function IsEmail(email) {
                                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                                    if(!regex.test(email)) {
                                       return false;
                                    }else{
                                       return true;
                                    }
                                  }
                            </script>
                </div>
                <!-- /General -->                
                <!-- Roles and Actions -->
                <div class="myaccordion">Rol y Acciones</div>
                <div class="panel">
                    <div class="boxForm">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <?php
                                        echo $this->Form->create(null, [
                                                            'url' => ['controller' => 'Accounts'
                                                                    , 'action' => 'editrol', $userId]
                                                            , 'id' => 'RolesForm'
                                                            , 'name' => 'RolesForm'
                                                    ]);
                                    ?>
                                        <div class="row">
                                            <label class="col-sm-6 text-right form-label-style">Role assigned:
                                            <br>
                                           </label>
                                            <div class="col-sm-6" style="display: table-caption;">
                                                <?php
                                                    echo $this->Form->input('rbRolls', [
                                                        'options' => $roles,
                                                        'class' => 'col-xs-4',
                                                        'type' => 'radio',
                                                        'id' => 'rbRolls',
                                                        'name' => 'rbRolls',
                                                        'class' => 'lbl-profiles',
                                                        'multiple' => 'radio',
                                                        'value' => $userRoles['RolId'],
                                                        'label' => false,
                                                        'disabled' => 'disabled',
                                                    ]);
                                                ?>
                                            </div>
                                        </div>
                                    <?php echo $this->Form->end(); ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- TABLE -->
                                    <table class="table table-striped info-table" id="table-rols" data-toggle="table" data-show-columns="false" data-search="false" data-show-export="false" data-pagination="false">
                                        <thead>
                                            <tr>
                                                <th data-field="Description" data-align="Left" data-halign="center" data-sortable="true">Permisos</th>
                                                <th data-formatter="actionAllow" data-align="Left" data-halign="Left" data-sortable="true">Permitir</th>
                                                <th data-formatter="actionDeny" data-align="Left" data-halign="Left" data-sortable="true">Denegar</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <!-- TABLE -->
                                </div>
                            </div>
                            <hr>
                            <!-- Boton de Update -->

                            <div class="col-sm-12">
                                    <div class="alert alert-danger" id="alertFormiOS" style="display:none;"></div>
                                </div>
                            <div class="row">
                                <div class="col-sm-12 text-right">

                                    <?php
                                        echo $this->Form->button('Actualizar', ['type' => 'button', 'class' => 'btn btn-submit', 'id' => 'validateRolesForm']);
                                    ?>
                                </div>
                            </div>
                            <!-- Boton de Update -->
                    </div>
                </div>
                <script type="text/javascript">
                     $("#validateRolesForm").click(function(){

                        if(!$('input:radio[name=rbRolls]:checked').val()){
                            $("#alertFormiOS").show(500);
                            $("#alertFormiOS").text("Debe asignar un Rol.");
                            return false;
                        }
                        $("#alertFormiOS").hide(500);
                        $("#RolesForm").submit();
                    });
                    </script>
                <!-- /Roles and Actions -->
                
            <!-- Accordion -->
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function(){
        showDrop();
    })

    $("[name='manage-profiles']").bootstrapSwitch();

    $(function() {

        $("#txtBirthDate").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            changeMonth: true,
            changeYear: true
        });
    });

      function actionFormatter(value, row, index) {
        console.log(row);

        return [
            '<input type="radio" name="rbAction" value="1">',

        ].join('');
    }

    function showDrop(){
        $('.btn-group,span.dropup').click(function(){
           $(this).toggleClass('open');
        })
    }

    //Funcion para cargar listado de acciones asociadas a un Rol
    $(document).ready(function(){
       
        $.ajax({
                type: "GET",
                url: "<?php echo Router::url(['controller' => 'Actions', 'action' => 'getactions']); ?>/" + "<?= $userRoles['RolId']?>",
                cache: false,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: "",
                success: function(data) {
                    $('#table-rols').bootstrapTable('load', data.actions);
                    LoadActionbyRol();
					actions=data.actions;
                }
        });

    }) ;

    var actions = [];
    var actionsChecked = [];

    //Actiones de un Rol
	var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;   
    function LoadActionbyRol(){

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "Actions", "action" => "getactionsbyrol")); ?>/' + "<?= $userRoles['RolId']?>",
            cache: false,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: "",
            beforeSend: function(xhr){
                xhr.setRequestHeader('X-CSRF-Token', csrfToken);
            },
            success: function(data) {

                var actionsByRol = data.actionsbyrol;
                var option = 0;

                for(var i = 0; i < actions.length; i++){
                    for(var j = 0; j< actionsByRol.length; j++){
                        if(actionsByRol[j].Id == actions[i].Id){
                            $("#" + $("#rbAction" + actions[i].Id + "-1[name=rbAction" + actions[i].Id + "]")[0].id).prop('checked', true);

                            //actionsChecked = actionsChecked + "-" + actions[i].Id;

                            actionsChecked.push(actions[i].Id);
                        }
                        else {
                            if (option != actions[i].Id){
                                $("#" + $("#rbAction" + actions[i].Id + "-2[name=rbAction" + actions[i].Id + "]")[0].id).prop('checked', true);;
                            }
                        }
                        option = actions[i].Id;
                    }
                }
            }
        });
    }

      //Radios para cada accion Allow
    function actionAllow(value, row, index, num) {
        var description = row.Description.replace(" ", "").toLowerCase();
            return [
                '<input type="radio" name="rbAction' + row.Id +'" value="A" id="rbAction' + row.Id +'-1" disabled>',
            ].join('');
    }

    //Radios para cada accion Deny
    function actionDeny(value, row, index) {
        var description = row.Description.replace(" ", "").toLowerCase();
        return [
            '<input type="radio" name="rbAction' + row.Id +'" value="D" id="rbAction'+ row.Id +'-2" disabled>',
        ].join('');
    }

</script>
