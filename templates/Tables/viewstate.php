<?php
    use Cake\Routing\Router; 
?>
<div class="div-container">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->Form->create($state); ?>
			<!-- Accordion -->
			<div class="myaccordion" id="activeAcord">Datos de la Ubicación</div>
					<div class="panel">
						<div class="boxForm">
							<div class="form-group">
								<div class="row">
									<label class="col-sm-3 text-right form-label-style">Id:</label>
									<div class="col-sm-6">
									<?php
										echo $state['Id'];                                        					
                                     ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="col-sm-3 text-right form-label-style">Ubicación:</label>
									<label class="col-sm-4 form-label-style">
										<b><?= $state["Name"] ?></b>
									</label>
								</div>
							</div>							
						</div>
					</div>
			<!-- Accordion -->
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>