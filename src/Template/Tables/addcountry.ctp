<?php
    use Cake\Routing\Router;
?>
<div class="div-container">
	<div class="row">
		<div class="col-sm-12">
			<!-- Accordion -->
			
				<!-- Login -->
				<div class="myaccordion" id="activeAcord">Datos del País</div>
				<div class="panel">
						       <?php
                                echo $this->Form->create(null, ['url' => ['controller' => 'Tables', 'action' => 'addcountry']
                                                                      , 'id' => 'paramForm', 'name' => 'paramForm']);
                                    ?>                            
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-3 text-right form-label-style">Id:</label>
                                   <?php
                                        echo $this->Form->text('txtCountryId', ['required' => 'required', 'id' => 'txtCountryId', 'class' => 'col-sm-4 form-input-style', 'placeholder' => 'Código...', 'txtCountryId' => 'txtCountryId', 'maxlength'=>'3', 'value' => '', 'step' => '1', 'min' => '1', 'type' => 'number']);
                                    ?>
                                </div>
                            </div>   
							<div class="form-group">
                                <div class="row">
                                    <label class="col-sm-3 text-right form-label-style">Nombre:</label>
                                    <?php
                                        echo $this->Form->text('txtName', ['required' => 'required', 'id' => 'txtName', 'class' => 'col-sm-4 form-input-style', 'placeholder' => 'Nombre...', 'name' => 'txtName', 'maxlength'=>'50', 'value' => '']);
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
                                        echo $this->Form->button('Agregar', ['type' => 'button', 'class' => 'btn btn-submit', 'onclick' => 'validateForm()']);
                                    ?>
                                </div>
                            </div>
                            <?php echo $this->Form->end(); ?>
								<!-- Boton de Update -->
									<script type="text/javascript">

                                function validateForm() {
									var id = $("#txtCountryId").val();                                    
                                    var val = $("#txtName").val();
                                    var alertForm = $("#alertForm");
                                    if (val == "") {
                                        alertForm.show(500);
                                        alertForm.text("El nombre es requerido.");
                                        return false;
                                    }
                                    if (id == "") {
                                        alertForm.show(500);
                                        alertForm.text("El código es requerido.");
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
