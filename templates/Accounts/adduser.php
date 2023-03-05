<?php
use Cake\Routing\Router;
?>

<div class="div-container">
    <div class="row">
        <div class="col-sm-12">
        <?php echo $this->Form->create(NULL,['id' => 'sbLoginForm', 'name' => 'sbLoginForm','type' => 'file']); ?>

            <!-- Accordion -->
                <!-- Login -->
                <div class="myaccordion">Login</div>
                <div class="panel">
                    <div class="boxForm">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-3 text-right form-label-style">Método de Autenticación:</label>
                                    <div class="radio col-sm-6">
                                    <?php
                                        $options = ['1' => 'Facebook', '2' => 'Twitter', '3' => 'Interno'];
                                            $attributes = ['hiddenField' => false,'legend' => false, 'label' => ['style' => 'font-weight:bold']];

                                            echo $this->Form->radio('rbAuthenticationMethod', $options, $attributes);
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-3 text-right form-label-style">Identificación (C.I.):</label>
                                    <?php
                                    echo $this->Form->text('txtUsername', ['id' => 'txtUsername', 'name' => 'txtUsername', 'class' => 'col-sm-4 form-input-style','maxlength'=>'50', 'placeholder' => 'Identificación...']);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-3 text-right form-label-style">Contraseña:</label>
                                    <?php
                                    echo $this->Form->password('txtPassword', ['required' => 'required', 'id' => 'txtPassword','name' => 'txtPassword','class' => 'col-sm-4 form-input-style', 'maxlength'=>'30', 'placeholder' => '************']);
                                    ?>                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-3 text-right form-label-style">Estatus:</label>
                                    <div class="radio col-sm-6">
                                        <?php
                                            $options = array('1' => 'Activo',
                                                             '2' => 'Inactivo');
                                            $attributes = array('hiddenField' => false, 'legend' => false, 'label' => array('style' => 'font-weight:bold', 'id' => 'rbAccountStatus', 'name' => 'rbAccountStatus'));
                                            echo $this->Form->radio('rbAccountStatus', $options, $attributes);
                                        ?>
                                    </div>
                                </div>
                            </div> 
                    </div>                           
                </div>
                <!-- /Login -->
                <!-- General -->
                <div class="myaccordion">General</div>
                <div class="panel">
                    <div class="boxForm">
                            <div class="col-sm-6" style="padding:0;">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">Nombre:</label>
                                        <?php
                                        echo $this->Form->text('txtFirstName', ['required' => 'required', 'id' => 'txtFirstName', 'class' => 'col-sm-8 form-input-style','maxlength'=>'15', 'placeholder' => 'Peter']);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">Apellido:</label>
                                        <?php
                                        echo $this->Form->text('txtLastName', ['required' => 'required', 'id' => 'txtLastName', 'class' => 'col-sm-8 form-input-style','maxlength'=>'15', 'placeholder' => 'Newton']);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">Fecha de Nacimiento:</label>
                                        <?php
                                        echo $this->Form->text('txtBirthDate', ['required' => 'required', 'id' => 'txtBirthDate', 'class' => 'col-sm-8 form-input-style', 'placeholder' => 'dd-mm-aaaa', 'maxlength'=>'10']);
                                        ?>
                                    </div>
                                </div>                               
                            </div>
                            <div class="col-sm-6" style="padding:0;">                                
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">Email:</label>
                                        <?php
                                        echo $this->Form->text('txtEmail', ['required' => 'required', 'id' => 'txtEmail', 'class' => 'col-sm-8 form-input-style', 'placeholder' => 'youremail@mail.com', 'maxlength'=>'50',  'name' => 'txtEmail']);
                                        ?>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">País:</label>
                                        <?php
                                        echo $this->Form->select('cmbCountry', 
                                            $countries,[
                                            'class' => 'col-sm-8 form-input-style',
                                            'id' => 'cmbCountry',
                                            'name' => 'cmbCountry',
                                            'multiple' => false,
                                            'label' => false,
                                            'empty' => 'Seleccione...']
                                            );
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 text-right form-label-style">Teléfono:</label>
                                        <?php
                                        echo $this->Form->text('txtCellPhoneNumber', ['id' => 'txtCellPhoneNumber', 'class' => 'col-sm-8 form-input-style','type'=>'number', 'placeholder' => '1234567890', 'name' => 'txtCellPhoneNumber', 'maxlength'=>'20', 'min' =>'1']);
                                        ?>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <!-- /General -->              
                
                <!-- Roles and Actions -->
                <div class="myaccordion">Rol y Acciones</div>
                <div class="panel">
                    <div class="boxForm">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-6 text-right form-label-style">Rol Asignado:
                                                <br>
                                            </label>
                                            <div class="col-sm-6">
                                                <?php
                                                echo $this->Form->select('rbRolls', 
                                                    $roles,[
													'onchange'=> 'LoadActionbyRol($("#rbRolls").val())',
                                                    'class' => 'col-xs-4',
                                                    'id' => 'rbRolls',
                                                    'name' => 'rbRolls',
                                                    'class' => 'lbl-profiles',
                                                    'multiple' => false,
                                                    'label' => false,'empty' => 'Seleccione...'
                                                ]);
                                                ?>
                                            </div>
                                        </div>
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
                    </div>                           
                </div>
                <!-- /Roles and Actions -->
            <!-- Accordion -->
            <!-- Mensaje de alerta de validacion de formulario -->
            <div class="col-sm-12">
                <div class="alert alert-danger" id="alertForm" style="display:none;"></div>
            </div>
            <!-- Mensaje de alerta de validacion de formulario -->
            <!-- Boton de Formulario -->
            <div class="col-sm-12 text-right">
                <?php echo $this->Form->button('Agregar', ['type' => 'button', 'class' => 'btn btn-submit', 'id'=> 'validateForm']); ?>
            </div>
            <!-- Boton de Formulario -->
        <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        showDrop();
    })
	var actions = [];
	
    function showDrop(){
        $('.btn-group,span.dropup').click(function(){
           $(this).toggleClass('open');
        })
    }

    $("#manageProfiles").bootstrapSwitch();

    $(function() {
        $("#txtBirthDate").datepicker({
            showOtherMonths: true,
           dateFormat: 'dd-mm-yy',
           selectOtherMonths: true,
            changeMonth: true,
            changeYear: true, yearRange: '1900:2000'
        });
		
		$.ajax({
                type: "GET",
                url: "/Actions/getactions/1",
                cache: false,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: "",
                success: function(data) {
					$('#table-rols').bootstrapTable('load', data.actions);
                    actions = data.actions;
                }
        });
    });

    $(function() {
        $("#profile-pic").on("change", function()
        {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader)
                return; // no file selected, or no FileReader support

            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function() { // set image data as background of div
                    $("#current-image").attr("src", this.result);
                }
            }
        });
    });

    $("#validateForm").click(function(){

        var username = $("#txtUsername").val();
        var pass = $("#txtPassword").val();
        var firstName = $("#txtFirstName").val();
        var lastName = $("#txtLastName").val();
        var birthdate = $("#txtBirthDate").val();
        var country = $("#cmbCountry").val();
        var cellPhone = $("#txtCellPhoneNumber").val();
        var email = $("#txtEmail").val();
        var city = $("#txtCity").val();
        var image = $("#current-image").val();
        var otherPhone = $("#txtOtherPhoneNumber").val();
        var errorAlert = $("#alertForm");

        if(!$('input:radio[name=rbAuthenticationMethod]:checked').val()){
            errorAlert.show(500);
            errorAlert.text("Seleccione el método de Autenticación.");
            return false;
        }
        if (username == "") {
            errorAlert.show(500);
            errorAlert.text("La identificación es requerida.");
            return false;
        }
        if (pass == "") {
            errorAlert.show(500);
            errorAlert.text("La contraseña es requerida.");
            return false;
        }
        if (pass.length < 6) {
            errorAlert.show(500);
            errorAlert.text("La contraseña debe tener más de 6 caracteres.");
            return false;
        }
        if(!$('input:radio[name=rbAccountStatus]:checked').val()){
            errorAlert.show(500);
            errorAlert.text("Seleccione un estatus.");
            return false;
        }
        if (firstName == "") {
            errorAlert.show(500);
            errorAlert.text("El nombre es requerido.");
            return false;
        }
        if (lastName == "") {
            errorAlert.show(500);
            errorAlert.text("El apellido es requerido.");
            return false;
        }
        if (birthdate == "") {
            errorAlert.show(500);
            errorAlert.text("La fecha de nacimiento es requerida.");
            return false;
        }
        if (country == "") {
            errorAlert.show(500);
            errorAlert.text("Seleccione un País.");
            return false;
        }
        if (cellPhone == 0) {
            errorAlert.show(500);
            errorAlert.text("El teléfono es requerido.");
            return false;
        }
        if (email == "") {
            errorAlert.show(500);
            errorAlert.text("El Email es requerido.");
            return false;
        }
        if(IsEmail(email)==false){
            errorAlert.show(500);
            errorAlert.text("El Email es inválido.");
            return false;
        }
        if($('#rbRolls').val()==''){
            errorAlert.show(500);
            errorAlert.text("Seleccione un Rol.");
            return false;
        }
		errorAlert.hide(500);
        sbLoginForm.submit();
    });

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
           return false;
        }else{
           return true;
        }
      }
	  
	  function getCookie(name) {
		  var value = "; " + document.cookie;
		  var parts = value.split("; " + name + "=");
		  if (parts.length == 2) return parts.pop().split(";").shift();
		}

	// Actiones de un Rol
	var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    function LoadActionbyRol(rolId){

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "Actions", "action" => "getactionsbyrol")); ?>/' + rolId,
            cache: false,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: "",
            beforeSend: function(xhr){
                xhr.setRequestHeader('X-CSRF-Token', csrfToken);
            },
            success: function(data) {
                var actionsByRol = data.actionsbyrol;
                for(var i = 0; i < actions.length; i++){
					var enc = false;
                    for(var j = 0; j < actionsByRol.length; j++){
                        if(actionsByRol[j].Id == actions[i].Id){
                            $("#" + $("#rbAction" + actions[i].Id + "-1[name=rbAction" + actions[i].Id + "]")[0].id).prop('checked', true);
							enc = true;
                        }                        
                    }					
					if (!enc){
						$("#" + $("#rbAction" + actions[i].Id + "-2[name=rbAction" + actions[i].Id + "]")[0].id).prop('checked', true);
					}
                }
            }
        });
    }
	
    // Radios para cada accion Allow
    function actionAllow(value, row, index, num) {
        var description = row.Description.replace(" ", "").toLowerCase();
            return [
                '<input type="radio" name="rbAction' + row.Id +'" value="A" id="rbAction' + row.Id +'-1" disabled>',
            ].join('');
    }

    // Radios para cada accion Deny
    function actionDeny(value, row, index) {
        var description = row.Description.replace(" ", "").toLowerCase();
        return [
            '<input type="radio" name="rbAction' + row.Id +'" value="D" id="rbAction'+ row.Id +'-2" disabled>',
        ].join('');
    }

</script>
