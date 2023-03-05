<script src="https://cdn.jsdelivr.net/gh/Talv/x-editable@develop/dist/bootstrap4-editable/js/bootstrap-editable.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.4/dist/extensions/editable/bootstrap-table-editable.min.js"></script>
<style>
.editable-input input {
    padding: 3px 5px;
    width: 90px !important;
    height: auto;
    font-size: 11px; }
</style>
<div class="div-container">
	<div class="row">
		<div class="form-group">
			<div class="row">
				<label class="col-sm-2 text-right form-label-style">Usuario a consultar:</label>
				<?php
				echo $this->Form->select('cmbUsers', $users, [
					'type' => 'select',
					'id' => 'cmbUsers',
					'name' => 'cmbUsers',
					'multiple' => false,
					'label' => false,                                                
					'empty' => 'Seleccione...', TRUE,
					'onchange' => 'ListData()',
					'class' => 'form-input-style col-sm-4']);
				?>
			</div>
		</div>
	</div>
    <div class="row">
        <div class="col-sm-12">
            <div id="div-menu-col"></div>
            <!-- BOOTSTRAP TABLE -->
            <table class="table table-striped info-table" id="table-pagination" data-url="" data-toggle="table" data-show-columns="true" data-search="true" data-show-export="true" data-pagination="true">
                <thead>
                    <tr>
                        <th data-field="Created" data-align="center" data-halign="left" data-sortable="true">Fecha</th>
                        <th data-field="Name" data-align="left" data-halign="left" data-sortable="true">Nombre</th>
                        <th data-field="LastName" data-align="left" data-halign="left" data-sortable="true">Apellido</th>
                        <th data-field="Category" data-align="left" data-halign="left" data-sortable="true">Categoría</th>
                        <th data-field="Coins" data-align="right" data-halign="left" data-sortable="true">Monedas</th>              
                    </tr>
                </thead>
            </table>
            <!-- BOOTSTRAP TABLE -->            
        </div>
    </div>   
</div>
<script language='javascript'>    
    var visible = false;
    
    function ListData(){
        $.ajax({
            type: "GET",
			url: "/Reports/getusercoins/"+$("#cmbUsers").val()+".json",
            cache: false,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                $('#table-pagination').bootstrapTable('load', data.rpt);
            }            
        });
    }    

</script>
