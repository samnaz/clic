<?php
    use Cake\Routing\Router; 
?>
<div class="div-container">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->Form->create($banner); ?>
			<!-- Accordion -->
			<div class="myaccordion" id="activeAcord">Datos de la Publicidad</div>
			<div class="panel">
				<div class="boxForm">
							<div class="form-group">
								<div class="row">
									<label class="col-sm-3 text-right form-label-style">Id:</label>
									<div class="col-sm-6">
									<?php
										echo $banner['Id'];                                        					
                                     ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="col-sm-3 text-right form-label-style">Título:</label>
									<div class="radio col-sm-6">
									<?php
										echo $banner['Title'];                                        					
                                     ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="col-sm-3 text-right form-label-style">Publicidad:</label>
									<label class="col-sm-4 form-label-style">
										<b><?= $banner["Description"] ?></b>
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