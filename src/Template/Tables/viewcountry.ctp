<?php
    use Cake\Routing\Router; 
?>
<div class="div-container">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->Form->create($country); ?>
			<!-- Accordion -->
			<div class="myaccordion" id="activeAcord">Datos del País</div>
			<div class="panel">
					<div class="boxForm">
							<div class="form-group">
								<div class="row">
									<label class="col-sm-3 text-right form-label-style">Id:</label>
									<div class="col-sm-6">
									<?php
										echo $country['Id'];                                        					
                                     ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="col-sm-3 text-right form-label-style">Nombre:</label>
									<label class="col-sm-4 form-label-style">
										<b><?= $country["Name"] ?></b>
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