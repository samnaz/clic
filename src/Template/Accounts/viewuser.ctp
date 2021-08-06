<?php
    use Cake\Routing\Router; 
?>
<div class="div-container">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->Form->create($user); ?>
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
										$options2 = array('1' => 'Facebook');

                                        $attributes2 = array('legend' => false
                                        					, 'value' => $user['AuthenticationMethodId']
                                        					, 'disabled' => 'disabled'
                                        					, 'label' => array('style' => 'font-weight:bold'));
                                        									 //, 'class' => 'radioFb'


                                        $options3 = array( '2' => 'Twitter');

                                        $attributes3 = array('legend' => false
                                        					, 'value' => $user['AuthenticationMethodId']
                                        					, 'disabled' => 'disabled'
                                        					, 'label' => array('style' => 'font-weight:bold'));
                                        									 //, 'class' => 'radioTw'

                                        $options4 = array('3' => 'Interno');

                                        $attributes4 = array('legend' => false
                                        					, 'value' => $user['AuthenticationMethodId']
                                        					, 'disabled' => 'disabled'
                                        					, 'label' => array('style' => 'font-weight:bold'));
                                        									 //, 'class' => 'radioGp'

                                        echo $this->Form->radio('rbAuthenticationMethod'
                                        						, $options2, $attributes2);

                                        echo $this->Form->radio('rbAuthenticationMethod'
                                        						, $options3, $attributes3);

                                        echo $this->Form->radio('rbAuthenticationMethod'
                                        						, $options4, $attributes4);
                                     ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="col-sm-3 text-right form-label-style">Identificación:</label>
									<label class="col-sm-4 form-label-style">
										<b><?= $user["DocId"] ?></b>
									</label>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="col-sm-3 text-right form-label-style">Estatus:</label>
									<div class="radio col-sm-6">
										<?php
											$options = array('1' => 'Activo'
															, '2' => 'Inactivo');

											$attributes = array('legend' => false
																, 'value' => $user['UserStatusId']
																, 'disabled' => 'disabled'
																, 'label' => array('style' => 'font-weight:bold')
																);
											echo $this->Form->radio('StatusId', $options, $attributes);
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
										<label class="col-sm-6 text-right form-label-style">Nombre:</label>
										<label class="col-sm-4 form-label-style">
											<b><?= $user["Name"] ?></b>
										</label>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<label class="col-sm-6 text-right form-label-style">Apellido:</label>
										<label class="col-sm-4 form-label-style">
											<b><?= $user["LastName"] ?></b>
										</label>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<label class="col-sm-6 text-right form-label-style">Fecha de Nacimiento:</label>
										<label class="col-sm-4 form-label-style">
											<b><?= $user["BirthDate"] ?></b>
										</label>
									</div>
								</div>								
							</div>
							<div class="col-sm-6" style="padding:0;">								
								<div class="form-group">
									<div class="row">
										<label class="col-sm-3 text-right form-label-style">Email:</label>
										<label class="col-sm-4 form-label-style">
											<b><?= $user["Email"] ?></b>
										</label>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<label class="col-sm-3 text-right form-label-style">País:</label>
										<label class="col-sm-4 form-label-style">
											<b><?= $country['Countries']['Name']?></b>
										</label>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<label class="col-sm-3 text-right form-label-style">Teléfono:</label>
										<label class="col-sm-4 form-label-style">
											<b><?= $user["Phone"] ?></b>
										</label>
									</div>
								</div>
							</div>
						</div>
				</div>
				<!-- /General -->				
				<!-- Roles and Actions -->
				<div class="myaccordion">Roles y Acciones</div>
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
                                                    echo $this->Form->input('rbRolls', [
                                                        'id' => 'rbRolls',
                                                        'label' => FALSE,
                                                        'disabled' => 'disabled',
                                                        'type' => 'radio',
                                                        'multiple' => 'radio',
                                                        //'value' => $user[''],
                                                        'value' => $userRoles['RolId'],
                                                        'name' => 'rbRolls',
                                                        'options' => $roles
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
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	var actions = [];
    
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
					actions = data.actions;
                    LoadActionbyRol();
                }
        });
        
    });
    
  
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
                    for(var j = 0; j < actionsByRol.length; j++){
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