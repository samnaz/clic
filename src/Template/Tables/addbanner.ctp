<?php
    use Cake\Routing\Router;
?>
<div class="div-container">
	<div class="row">
		<div class="col-sm-12">
			<!-- Accordion -->
				<!-- Login -->
				<div class="myaccordion" id="activeAcord">Datos de la Publicidad</div>
				<div class="panel">
						       <?php
                                echo $this->Form->create(null, ['url' => ['controller' => 'Tables', 'action' => 'addbanner']
                                                    ,'enctype' => 'multipart/form-data', 'id' => 'bannForm', 'name' => 'bannForm']);
							?>                            
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-3 text-right form-label-style">Id:</label>
                                    Autogenerado
                                </div>
                            </div>   
							<div class="form-group">
                                <div class="row">
                                    <label class="col-sm-3 text-right form-label-style">Tipo de Banner:</label>
                                    <div class="radio col-sm-6">
                                    <?php
                                        $options = ['1' => 'Html', '2' => 'Imagen'];
                                            $attributes = ['value' => '1', 'onclick' => 'rbClick(this.value)','legend' => false, 'label' => ['style' => 'font-weight:bold']];
                                            echo $this->Form->radio('rbType', $options, $attributes);
                                    ?>
                                    </div>
                                </div>
                            </div>
							<div class="form-group">
                                <div class="row">
                                    <label class="col-sm-3 text-right form-label-style">Título:</label>
                                    <?php
                                        echo $this->Form->text('txtTitle', ['required' => 'required', 'id' => 'txtTitle', 'class' => 'col-sm-4 form-input-style', 'placeholder' => 'Título...', 'name' => 'txtTitle', 'maxlngth'=>'50', 'value' => '']);
                                    ?>
                                </div>
                            </div>  
							<div class="form-group" id='rowHtml'>
                                <div class="row">
                                    <label class="col-sm-3 text-right form-label-style">Html del Banner:</label>
                                    <?php
                                        echo $this->Form->text('txtBanner', ['rows' => '5', 'required' => 'required', 'id' => 'txtBanner', 'class' => 'col-sm-4', 'placeholder' => 'Html...', 'name' => 'txtBanner', 'type'=>'textarea', 'value' => '']);
                                    ?>
                                </div>
                            </div>  
							<div class="form-group" id='rowUpload' style='display:none'>
								<div class="row">
									<label class="col-sm-5 text-right form-label-style">Click para seleccionar la imagen:</label>
									<div class="col-sm-7" style="padding-left: 0px">
										<div class="btn-upload2" style="margin:0;">
											<?php
											echo $this->Form->file('Image', ['id' => 'bannImgInput', 'name' => 'Image', 'onchange' => 'setpic(this)']);
											?>
										</div>
										<?=
										$this->Html->image("/img/car.jpg", [
											"height" => "100",
											"id" => "pubImg"
										]);
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
                                        echo $this->Form->button('Agregar', ['type' => 'button', 'class' => 'btn btn-submit', 'onclick' => 'validateForm()']);
                                    ?>
                                </div>
                            </div>
                            <?php echo $this->Form->end(); ?>
								<!-- Boton de Update -->
								<script type="text/javascript">
                                function validateForm() {
									var files = !!$("#bannImgInput").files ? $("#bannImgInput").files : [];
                                    var val = $("#txtTitle").val();
									var alertForm = $("#alertForm");
									if (val == "") {
                                        alertForm.show(500);
                                        alertForm.text("La publicidad es requerida.");
                                        return false;
                                    }
                                    alertForm.hide(500);
                                    bannForm.submit();
                                }
                            </script>
				</div>
			<!-- Accordion -->			
		</div>
	</div>
</div>
<script type="text/javascript">
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

function rbClick(v){
	if(v=='1'){
		$("#rowHtml").show();
		$("#bannImgInput").val('');
		$("#rowUpload").hide();
	}else{
		$("#rowHtml").hide();
		$("#txtBanner").val('');
		$("#rowUpload").show();
	}
}
</script>
