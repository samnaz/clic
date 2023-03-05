<?php
    use Cake\Routing\Router; 
?>
<div class="div-container">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->Form->create($lessons); ?>
			<!-- Accordion -->
			<div class="myaccordion" id="activeAcord">Datos de la Lección</div>
			<div class="panel">
				<div class="boxForm">
					<div class="form-group">
						<div class="row">
							<label class="col-sm-3 text-right form-label-style">Id:</label>
							<div class="col-sm-6">
							<?php
								echo $lessons['Id'];                                        					
							 ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-sm-3 text-right form-label-style">Día:</label>
							<label class="col-sm-4 form-label-style">
								<b><?= $lessons["Day"] ?></b>
							</label>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-sm-3 text-right form-label-style">Libro:</label>
							<label class="col-sm-4 form-label-style">
								<b><?= $lessons["book"]["Name"] ?></b>
							</label>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-sm-3 text-right form-label-style">Activo:</label>
							<label class="col-sm-4 form-label-style">
								<b><?= $lessons["Active"] ?></b>
							</label>
						</div>
					</div>	
					<?if ($lessons["CoverImage"] !=''){?>
						<div class="form-group">
							<div class="row">
								<label class="col-sm-3 text-right form-label-style">Pregunta:</label>
								<label class="col-sm-4 form-label-style">
								<b><?= $lessons["Question"] ?></b>
								</label>
							</div>
						</div>
					<?}?>					
				</div>
				<div class="row">
					<!-- Mensaje de alerta de validacion de formulario -->
					<div class="col-sm-2 text-right">
						<?php
							echo $this->Form->button('Atrás', ['type' => 'button', 'class' => 'btn btn-submit', 'onclick' => 'window.history.back()']);
						?>
					</div>
					<div class="col-sm-10">
						<div class="alert alert-danger" id="alertForm" style="display:none;"></div>
					</div>
				</div>
			</div>
			<!-- Accordion -->
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>