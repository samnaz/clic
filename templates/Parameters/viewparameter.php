<?php
    use Cake\Routing\Router; 
?>
<div class="div-container">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->Form->create($p); ?>
			<!-- Accordion -->
			<div class="panel-group add-user-accordion" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								<span class="caret"></span> Datos del Parámetro
							</a>
						</h4>
					</div>
					<div id="collapseOne" class="panel-collapse" role="tabpanel" aria-expanded='true' aria-labelledby="headingOne">
						<div class="panel-body">
							<div class="form-group">
								<div class="row">
									<label class="col-sm-3 text-right form-label-style">Clave:</label>
									<div class="radio col-sm-6">
									<?php
										echo $p['Id'];                                        					
                                     ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="col-sm-3 text-right form-label-style">Valor:</label>
									<label class="col-sm-4 form-label-style">
										<b><?= $p["Value"] ?></b>
									</label>
								</div>
							</div>							
						</div>
					</div>
				</div>					
			</div>
			<!-- Accordion -->
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>