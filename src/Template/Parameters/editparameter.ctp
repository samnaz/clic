<?php
    use Cake\Routing\Router;
?>
<div class="div-container">
	<div class="row">
		<div class="col-sm-12">
			<!-- Accordion -->
			<div class="panel-group add-user-accordion" id="accordion" role="tablist" aria-multiselectable="true">
				<!-- Login -->
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								<span class="caret"></span> Datos del Parámetro
							</a>
						</h4>
					</div>
					<div id="collapseOne" class="panel-collapse" aria-expanded='true' role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
						<?php $prId = $p['Id']?>                          
                               <?php
                                echo $this->Form->create(null, ['url' => ['controller' => 'Parameters', 'action' => 'editparameter', $prId]
                                                                      , 'id' => 'paramForm', 'name' => 'paramForm']);
  ?>                            
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-3 text-right form-label-style">Clave:</label>
                                    <?php
                                        echo $this->Form->text('txtUsername', ['readonly' => 'readonly', 'id' => 'txtId', 'class' => 'col-sm-4 form-input-style', 'placeholder' => 'Clave...', 'name' => 'txtId', 'maxlength'=>'20', 'value' => $p['Id']]);
                                    ?>
                                </div>
                            </div>   
							<div class="form-group">
                                <div class="row">
                                    <label class="col-sm-3 text-right form-label-style">Valor:</label>
                                    <?php
                                        echo $this->Form->text('txtValue', ['required' => 'required', 'id' => 'txtValue', 'class' => 'col-sm-4 form-input-style', 'placeholder' => 'Valor...', 'name' => 'txtValue', 'maxlength'=>'250', 'value' => $p['Value']]);
                                    ?>
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
                                        echo $this->Form->button('Actualizar', ['type' => 'button', 'class' => 'btn btn-submit', 'onclick' => 'validateForm()']);
                                    ?>
                                </div>
                            </div>
                            <?php echo $this->Form->end(); ?>
								<!-- Boton de Update -->
									<script type="text/javascript">

                                function validateForm() {

                                    var val = $("#txtValue").val();
                                    var alertForm = $("#alertForm");
                                    if (val == "") {
                                        alertForm.show(500);
                                        alertForm.text("El valor es requerido.");
                                        return false;
                                    }
                                    alertForm.hide(500);
                                    paramForm.submit();
                                }
                            </script>
						</div>
					</div>
				</div>				
			</div>			
		</div>
	</div>
</div>
