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
					'onchange' => 'ListUsers()',
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
                        <th data-field="UserId" data-align="left" data-halign="left" data-sortable="true">Id</th>
                        <th data-field="Name" data-align="left" data-halign="left" data-sortable="true">Nombre</th>
                        <th data-field="LastName" data-align="left" data-halign="left" data-sortable="true">Apellido</th>
                        <th data-field="Book" data-align="left" data-halign="left" data-sortable="true">Libro</th>
                        <th data-field="Lesson" data-align="left" data-halign="left" data-sortable="true">Lecci&oacute;n</th>
                        <th data-field="Created" data-align="left" data-halign="left" data-sortable="true">Fecha Completada</th>
                        <th data-formatter="actionFormatter" data-align="Center" data-halign="Center" data-sortable="true">Acciones</th>
                    </tr>
                </thead>
            </table>
            <!-- BOOTSTRAP TABLE -->            
        </div>
    </div>   
</div>
<script language='javascript'>    
    var visible = false;
    
    function ListUsers(){
        $.ajax({
            type: "GET",
			url: "/Reports/getuserlessons/"+$("#cmbUsers").val()+".json",
            cache: false,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                $('#table-pagination').bootstrapTable('load', data.userlessons);
            }            
        });
    }    

    function actionFormatter(value, row, index) {
        return [           
            '<a href="javascript:void(0)" onClick="ShowModalT(' + row["UserId"] +',' + row["LessonId"] + ')" title="Ver Detalle de Tareas">',
            '<img style="width:15px;margin:5px;" src="/img/icons/icon_view.png" alt="Ver Detalle de Tareas">',
            '</a>'
        ].join('');
    }
	
	/*function actionFormatter2(value, row, index) {
        return [           
            '<a href="javascript:void(0)" onClick="ShowTask(' + row["UserId"] +',' + row["Id"] + ')" title="Ver Tareas">',
            '<img style="width:15px;margin:5px;" src="/img/icons/icon_view.png" alt="Ver Detalle de Tareas">',
            '</a>'
        ].join('');
    }*/

    function ShowModalT(id, lId) {
        $("#btnDisablePri").css("display", "inline");
        $("#btnCancelPri").css("display", "inline");
        //$("#btnOkPri").css("display", "none");
        //$("#btnDisablePri").attr("onclick", "DeleteUser(" + id + ")");
		TaskByUser(id, lId);
        $("#TaskUser").modal('show');
    }

    function TaskByUser(id, lessonId) {
        $.ajax({
            data: "",
            type: 'GET',
            url: '/Reports/getuserpages/' + id+'/'+lessonId,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
				$('#tblTask').bootstrapTable('load', data.userpages);				
            },
            error: function(xhr, status) {
                var err = eval("(" + xhr.responseText + ")");
                alert("Error" + err.Message);
            }
        });
    }
	
	function ShowTask(userId, id) {
        $.ajax({
            data: "",
            type: 'GET',
            url: '/Reports/getuserpage/' + userId+'/'+id,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
				console.log(data.userpage);				
				// 3 Actividad Ordenar
				// 4 Actividad Voice
				// 5 Actividad Imagen
				// 6 Actividad Reconocimiento de Voz
				// 7 Actividad Texto
				if (data.userpage.Id == 7)
					alert(data.userpage.Response);
				else if (data.userpage.Id == 5 || data.userpage.Id == 4)
					window.open("/img/userlessons/" + data.userpage.File);
				else
					alert("Completada con éxito");
            },
            error: function(xhr, status) {
                var err = eval("(" + xhr.responseText + ")");
                alert("Error" + err.Message);
            }
        });
    }
	
	$.fn.editable.defaults.mode = 'inline' /*: 'popup'*/;
	$(function() {
		$('#tblTask').on('editable-save.bs.table', function(e, field, row, oldValue){
			/*console.log(field);
			console.log(row);
			console.log(row.TeacherPoints);
			console.log(oldValue);
			console.log(e);*/
			
			// Validate 
			var v = parseInt(row.TeacherPoints);
			var p = parseInt(row.Points);
            var co = row.TeacherComments;

			//console.log(v);
			if (isNaN(v)){
				alert("Calificación inválida");
				e.cancelBubble = true;
			}else if (v<0){
				alert("Calificación no puede ser menor de 0");
				e.cancelBubble = true;
			}else if (v>p){
				alert("Calificación no puede ser mayor de " +p);
				e.cancelBubble = true;
			}else{
				$.ajax({
					data: {Id : row.Id,TeacherPoints: v, TeacherComments:co},
					type: 'POST',
					async: false,
					url: 'AddTeacherPoints.json',
					success: function (data) {
						console.log(data);
					},
					error: function (xhr, status){
						var err = eval("(" + xhr.responseText + ")");
						alert("Error" + err.Message);
					}
				});
			}
		});    
	});

</script>
<!-- MODAL Ver -->
<div class="modal fade" id="TaskUser" tabindex="-1" role="dialog" aria-labelledby="DeleteUser">
    <div class="modal-dialog" role="document" style="width:1200px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalDelete">Tareas del Usuario</h4>
            </div>
            <div id="TitlePri" class="modal-body" style="background-color:#F5F5F5">
                <table class="table table-striped info-table" id="tblTask" data-toggle="table" data-show-columns="true" data-search="true" data-show-export="true" data-pagination="true">
					<thead>
						<tr>
							<th data-field="Book" data-align="left" data-halign="left" data-sortable="true">Libro</th>
							<th data-field="Lesson" data-align="left" data-halign="left" data-sortable="true">Lecci&oacute;n</th>
							<th data-field="Task" data-align="left" data-halign="left" data-sortable="true">Tarea</th>
							<th data-field="Description" data-align="left" data-halign="left" data-sortable="true">Respuesta</th>
							<th data-field="Created" data-align="left" data-halign="left" data-sortable="true">Fecha Completada</th>
							<th data-field="Points" data-align="center" data-halign="left" data-sortable="true">Puntos</th>
							<th data-field="TeacherReview" data-align="center" data-halign="left" data-sortable="true">Fecha Revisada</th>
							<th data-editable="true" data-field="TeacherPoints" data-align="right" data-halign="Center" data-sortable="true">Calificación</th>							
							<th data-editable="true" data-field="TeacherComments" data-align="right" data-halign="Center" data-sortable="true">Comentarios</th>							
					</thead>
				</table>
            </div>
            <div class="modal-footer">
                <button id="btnCancelPri" type="button" class="btn btn-default menuBtn" style="width:15%;" data-dismiss="modal"><strong>Aceptar</strong></button>
                <button id="btnOkPri" type="button" class="btn btn-default menuBtn" style="width:15%; display:none;" data-dismiss="modal"><strong>Aceptar</strong></button>
            </div>
        </div>
    </div>
</div>