<?php
    use Cake\Routing\Router;
?>
<div class="div-container">
	<div class="row">
		<div class="col-sm-12">
			<!-- Accordion -->
			
				<!-- Login -->
				<div class="myaccordion" id="activeAcord">Datos de la Lección</div>
				<div class="panel">
					   <?php
						echo $this->Form->create(null, ['url' => ['controller' => 'Lessons', 'action' => 'addlesson']
									,'enctype' => 'multipart/form-data' , 'id' => 'paramForm', 'name' => 'paramForm']);
							?>                            
					<div class="form-group">
						<div class="row">
							<label class="col-sm-3 text-right form-label-style">Día:</label>
							<?php
								echo $this->Form->text('txtDay', ['required' => 'required', 'id' => 'txtDay', 'class' => 'col-sm-4 form-input-style', 'placeholder' => 'Día...', 'name' => 'txtDay', 'maxlength'=>'5', 'type'=>'number', 'value' => '']);
							?>
						</div>
					</div>  							
					<div class="form-group">
						<div class="row">
							<label class="col-sm-3 text-right form-label-style">Libro:</label>
							<?php
								echo $this->Form->select('cmbBook', $books, [
									'multiple' => false,
									'label' => false,	                                               
									'id' => 'cmbBook',
									'default' => 0,
									'empty' => 'Seleccione...', TRUE,
									'class' => 'col-sm-4 form-input-style'
								]);
							?>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-sm-3 text-right form-label-style">Estatus:</label>
							<div class="radio col-sm-6">
								<?php
								$selected = 1;
								$options = ['1' => 'Activo', '0' => 'Inactivo'];
								$attributes = ['legend' => false, 'label' => ['style' => 'font-weight:bold'], 'name' => 'rbStatus', 'id' => 'rbStatus', 'value'=>$selected];
								echo $this->Form->radio('rbAccountStatus', $options, $attributes);
							?>
							</div>
						</div>
					</div>  
					<!-- Boton de Update -->
					<div class="row">
						<!-- Mensaje de alerta de validacion de formulario -->
						<div class="col-sm-2 text-right">
							<?php
								echo $this->Form->button('Atrás', ['type' => 'button', 'class' => 'btn btn-submit', 'onclick' => 'window.history.back()']);
							?>
						</div>
						<div class="col-sm-8">
							<div class="alert alert-danger" id="alertForm" style="display:none;"></div>
						</div>
						<!-- Mensaje de alerta de validacion de formulario -->
						<div class="col-sm-2 text-right">
							<?php
								echo $this->Form->button('Agregar', ['type' => 'button', 'class' => 'btn btn-submit', 'onclick' => 'validateForm()']);
							?>
						</div>
					</div>
					<?php echo $this->Form->end(); ?>
								<!-- Boton de Update -->
					<script type="text/javascript">

					function validateForm() {
						var val = $("#txtDay").val();
						var cmbBook= $("#cmbBook").val();
						var alertForm = $("#alertForm");
						if (val == "") {
							alertForm.show(500);
							alertForm.text("El Día es requerido.");
							return false;
						}
						if (cmbBook == "" || cmbBook == "0") {
							alertForm.show(500);
							alertForm.text("El Libro es requerido.");
							return false;
						}
						var fi = document.getElementById('bannImgInput'); 
						// Check if any file is selected. 
						if (fi.files.length > 0) { 
							for (var i = 0; i <= fi.files.length - 1; i++) { 							  
								const fsize = fi.files.item(i).size; 
								const file = Math.round((fsize / 1024)); 
								console.log(file); 
								// The size of the file. 
								if (file >= 2048) { 
									alertForm.show(500);
									alertForm.text("El archivo no puede ser mayor a 2mb.");
									return false;
								} else { 
									console.log(file); 
								} 
							} 
						} 
						alertForm.hide(500);
						paramForm.submit();
					}
					
					function setpic(inp) {
						//var files = !!this.files ? this.files : [];
						var files = !!inp.files ? inp.files : [];
						//alert(files.length);
						//alert(window.FileReader);
						if (!files.length || !window.FileReader)
							return; // no file selected, or no FileReader support

						if (/^image/.test(files[0].type)) { // only image file
							var reader = new FileReader(); // instance of the FileReader
							reader.readAsDataURL(files[0]); // read the local file

							reader.onloadend = function() { // set image data as background of div
								$("#pubImg").attr("src", this.result);
							}
						}        
					}
				</script>
				</div>		
		</div>
	</div>
</div>
