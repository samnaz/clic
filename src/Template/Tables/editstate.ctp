<?php
    use Cake\Routing\Router;
?>
<div class="div-container">
	<div class="row">
		<div class="col-sm-12">
			<!-- Accordion -->
			<div class="myaccordion" id="activeAcord">Datos de la Ubicación</div>
            <div class="panel">
						    <?php $stateId = $state['Id']?>                          
                               <?php
                                echo $this->Form->create(null, ['url' => ['controller' => 'Tables', 'action' => 'editstate', $stateId]
                                                                      , 'id' => 'paramForm', 'name' => 'paramForm']);
                            ?>                            
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-3 text-right form-label-style">Id:</label>
                                    <?php
                                        echo $this->Form->text('txtId', ['readonly' => 'readonly', 'id' => 'txtId', 'class' => 'col-sm-4 form-input-style', 'placeholder' => 'Nombre...', 'name' => 'txtId', 'maxlength'=>'20', 'value' => $state['Id']]);
                                    ?>
                                </div>
                            </div>   
							<div class="form-group">
                                <div class="row">
                                    <label class="col-sm-3 text-right form-label-style">Nombre:</label>
                                    <?php
                                        echo $this->Form->text('txtName', ['required' => 'required', 'id' => 'txtName', 'class' => 'col-sm-4 form-input-style', 'placeholder' => 'Valor...', 'name' => 'txtName', 'maxlength'=>'50', 'value' => $state['Name']]);
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

                                    var val = $("#txtName").val();
                                    var alertForm = $("#alertForm");
                                    if (val == "") {
                                        alertForm.show(500);
                                        alertForm.text("El nombre es requerido.");
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
