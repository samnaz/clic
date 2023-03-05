<?php
use Cake\Routing\Router; 
?>
<div class="div-container">
     <?php 
        echo $this->Form->create(null);
    ?>
        <div class="row">
            <div class="col-sm-12">
                <table class="container-yellow">
                    <tr class="yellow-row">
                        <td>Editar Rol:</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="div-container" style="margin-bottom:10px;margin-top:10px;">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-2 text-right form-label-style">Rol a editar:</label>
                                            <?php

                                            echo $this->Form->select('cmbRoles', $roles, [
                                                'type' => 'select',
                                                'id' => 'cmbRoles',
                                                'name' => 'cmbRoles',
                                                'multiple' => false,
                                                'label' => false,                                                
                                                'empty' => 'Seleccione...', TRUE,
                                                'onchange' => 'LoadActionbyRol()',
                                                'class' => 'form-input-style col-sm-4']);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="tableRoles">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <!-- BOOTSTRAP TABLE -->
                                    <table class="table table-striped info-table" id="table-rols" data-url="" data-toggle="table" data-pagination="false">
                                        <thead>
                                            <tr>
                                                <th data-field="Description" data-align="Left" data-halign="Left" data-sortable="true">Acciones</th>
                                                <th data-formatter="actionAllow" data-align="Left" data-halign="Left" data-sortable="true">Permitir</th>
                                                <th data-formatter="actionDeny" data-align="Left" data-halign="Left" data-sortable="true">Denegar</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <!-- BOOTSTRAP TABLE -->
                                    <!-- Boton de Formulario -->
						            <div class="col-sm-12 text-right" style="padding:0;">
                                        <?php echo $this->Form->button('Asignar Acciones', ['type' => 'button', 'class' => 'btn btn-submit', 'onclick' => 'SendActionsByRol()']); ?>
						            </div>
						            <!-- Boton de Formulario -->
                                </div>
                            </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <!-- Boton de Formulario -->
            <div class="col-sm-12 text-right">
                <?php echo $this->Form->button('Agregar Nuevo Rol', ['type' => 'button', 'class' => 'btn btn-submit', 'onclick' => 'showModal()']); ?>
            </div>
            <!-- Boton de Formulario -->
        </div>
    <?php echo $this->Form->end(); ?>
</div>
<!-- Modal para agregar un Rol -->
<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar Rol</h4>
            </div>
            <div class="modal-body">
                <?php echo $this->Form->create(null, ['url' => ['controller' => 'Actions', 'action' => 'addrole'], 'id' => 'roleForm']); ?>
                    <div class="form-group">
                        <label>Rol:</label>
                        <?php
                        echo $this->Form->text('txtRoleName', ['id' => 'txtRoleName', 'class' => 'form-input-style', 'placeholder' => 'Role Name', 'name' => 'txtRoleName', 'style' => 'width:100%']);
                        ?>
                    </div>
                    <div class="form-group">
                        <!-- Mensaje de alerta de validacion de formulario -->
                        <div class="alert alert-danger" id="alertForm" style="display:none;"></div>
                        <!-- Mensaje de alerta de validacion de formulario -->
                    </div>
                    <div class="modal-footer">
                        <?php echo $this->Form->button('Cerrar', ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
                        <?php echo $this->Form->button('Aceptar', ['type' => 'button', 'class' => 'btn btn-primary', 'id' => 'ManagerRolsForm']); ?>
                    </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<!-- /Modal para agregar un Rol -->

<script type="text/javascript">
    var actions = [];
    
    var role = $('#cmbRoles');
    $("#ManagerRolsForm").click(function(){

        if ($("#txtRoleName").val() == "") {
            $("#alertForm").show(500);
            $("#alertForm").text("El nombre del rol es requerido");
            return false;
        }
        else {
            $("#alertForm").hide(500);
			$("#roleForm").submit();
        }
    });

    function showModal() {
        $('#addRoleModal').modal('show');
    }

    //Mostrar tabla 
    function showTableRoles() {

        if ($("#cmbRoles").val() != null) {
            $("#tableRoles").show(500);
        }
    } 

    //Mostrar el Listado de Acciones 
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    $(document).ready(function(){
        $("#cmbRoles option").attr("onclick", "showTableRoles()");

        //Lista de Acciones
        $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "Actions", "action" => "getactions")); ?>/' + $("#cmbRoles").val(),
        cache: false,
        contentType: "application/json; charset=utf-8",
        dataType: "json", 
        data: "",
            beforeSend: function(xhr){
                xhr.setRequestHeader('X-CSRF-Token', csrfToken)
        },success: function(data) {
                $('#table-rols').bootstrapTable('load', data.actions);
                actions = data.actions;
            }
        });
     });
    
    
    var actionsChecked = [];
    //Actiones de un Rol
    function LoadActionbyRol(){
       
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "Actions", "action" => "getactionsbyrol")); ?>/' + $("#cmbRoles").val(),
            cache: false,
            contentType: "application/json; charset=utf-8",
            dataType: "json", 
            data: "",
            beforeSend: function(xhr){
                xhr.setRequestHeader('X-CSRF-Token', csrfToken);
            },
            success: function(data) {
                ClearRadios();
                var actionsByRol = data.actionsbyrol;
                var option = 0;
                
                for(var i = 0; i < actions.length; i++){
					var enc = false;
                    for(var j = 0; j< actionsByRol.length; j++){
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

    //Radios para cada accion Allow
    function actionAllow(value, row, index, num) {
        var description = row.Description.replace(" ", "").toLowerCase();
            return [
                '<input type="radio" name="rbAction' + row.Id +'" value="A" id="rbAction' + row.Id +'-1" onclick="AddAction(' + row.Id + ')">',
            ].join('');
    }
    
    //Radios para cada accion Deny
    function actionDeny(value, row, index) {
        var description = row.Description.replace(" ", "").toLowerCase();
        return [
            '<input type="radio" name="rbAction' + row.Id +'" value="D" id="rbAction'+ row.Id +'-2" onclick="RemoveAction(' + row.Id + ')">',
        ].join('');
    }
    
    //Funcion para agregar una accion a un rol
    function AddAction(id){
        actionsChecked.push(id);
    }
    
    //Funcion enviar datos al formulario
    function SendActionsByRol(){
        if ($("#cmbRoles").val()=='')
		{
			alert('Debe seleccionar un Rol');
			return;
		}
		actionsChecked = [];
		//alert(actionsChecked.length);	
		for(var i = 0; i < actions.length; i++){			
			//alert($("#rbAction" + actions[i].Id + "-1").is(':checked'));
			if ($("#rbAction" + actions[i].Id + "-1").is(':checked'))
				actionsChecked.push(actions[i].Id);
		}
		
		// Tomar
		var actionss = '';  
//alert(actionsChecked.length);	
	
        for(var i=0; i < actionsChecked.length; i++){
           actionss += actionsChecked[i] + '-';             
        }
        actionss = actionss.substring(0, actionss.length - 1);
      
		// Si es vacio
        if (actionss=='')
			actionss='0';
        $.ajax({
            type: "POST",
            url: '/actions/addactionsbyrol/'+ $("#cmbRoles").val(),
            cache: false,
            contentType: "application/x-www-form-urlencoded",
            data: "actionsId=" + actionss,
            beforeSend: function(xhr){
                xhr.setRequestHeader('X-CSRF-Token', csrfToken)
			},
            success: function(data) {
				//alert(data);
				window.location.href=window.location.href;                    
            }
        });
    }
    
    //Funcion para eliminar una acction a un rol
    function RemoveAction(id){
        
        var index = actionsChecked.indexOf(id);
        
        if (index > -1) {
            actionsChecked.splice(index, 1);
        }
    }
    
    //Limpiar Radios
    function ClearRadios(){
        var listRadios = $(":radio");
        
        for(var i = 0; i < listRadios.length; i++){
            $("#" + listRadios[i].id).prop('checked', false);
        }
    }
      
</script>