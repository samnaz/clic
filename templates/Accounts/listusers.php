<div class="div-container">
    <div class="row">
        <div class="col-sm-12">
            <div id="div-menu-col"></div>
            <!-- BOOTSTRAP TABLE -->
            <table class="table table-striped info-table" id="table-pagination" data-url="" data-toggle="table" data-show-columns="true" data-search="true" data-show-export="true" data-pagination="true">
                <thead>
                    <tr>
                        <th data-field="Name" data-align="left" data-halign="left" data-sortable="true">Nombre</th>
                        <th data-field="LastName" data-align="left" data-halign="left" data-sortable="true">Apellido</th>
                        <th data-field="Email" data-align="left" data-halign="left" data-sortable="true">Email</th>
                        <th data-field="Roles" data-align="left" data-halign="left" data-sortable="true">Rol</th>
                        <th data-field="Status" data-align="left" data-halign="left" data-sortable="true">Estatus</th>
                        <th data-field="LastLogin" data-align="left" data-halign="left" data-sortable="true">Ultimo Login</th>
                        <th data-formatter="actionFormatter" data-align="Center" data-halign="Center" data-sortable="true">Acciones</th>
                    </tr>
                </thead>
            </table>
            <!-- BOOTSTRAP TABLE -->
            
        </div>
    </div>
    <div class="row" style="padding-bottom: 30px;">
        <div class="col-sm-6 col-sm-offset-6 text-right">
            <table class="total-table">
                <tr id="one">
                    <td>Total Usuarios Activos</td>
                </tr>
                <tr id="two">
                    <td>Total Usuarios Inactivos</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- MODAL PARA ELIMINAR USUARIOS - DE FORMA LOGICA- OCULTAR REGISTROS -->
<div class="modal fade" id="DeleteUser" tabindex="-1" role="dialog" aria-labelledby="DeleteUser">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalDelete">Eliminar Usuario</h4>
            </div>

            <div id="TitlePri" class="modal-body" style="background-color:#F5F5F5">
                <h5>Seguro que desea eliminar este Usuario?</h5>
            </div>

            <div class="modal-footer">
                <button id="btnDisablePri" type="button" class="btn btn-default menuBtn" style="width:15%"><strong>SI</strong></button>
                <button id="btnCancelPri" type="button" class="btn btn-default menuBtn" style="width:15%;" data-dismiss="modal"><strong>No</strong></button>
                <button id="btnOkPri" type="button" class="btn btn-default menuBtn" style="width:15%; display:none;" data-dismiss="modal"><strong>Aceptar</strong></button>
            </div>

        </div>
    </div>
</div>

<!-- MODAL PARA DESACTIVAR USUARIO -->
<div class="modal fade" id="ChangeStatusUser" tabindex="-1" role="dialog" aria-labelledby="DisableUserModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cambiar Estatus</h4>
            </div>

            <div id="Name" class="modal-body" style="background-color:#F5F5F5">
                <h5>�Seguro que desea realizar el cambio?</h5>
            </div>

            <div class="modal-footer">
                <button id="btnDisable" type="button" class="btn btn-default menuBtn" style="width:15%"><strong>SI</strong></button>
                <button id="btnCancel" type="button" class="btn btn-default menuBtn" style="width:15%;font-weight: 700;" data-dismiss="modal"><strong>NO</strong></button>
            </div>

        </div>
    </div>
</div>
<!-- MODAL PARA DESACTIVAR USUARIO -->

<script language='javascript'>
    
    var visible = false;
    
    function ListUsers(){
        $.ajax({
            type: "GET",
            url: "/Accounts/getusers.json",
            cache: false,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: "",
            success: function(data) {
                $('#table-pagination').bootstrapTable('load', data.users);
            }

                // $('#btn-span').addClass('hola');
                // $('#btn-span').click(function(){
                //     $(this).addClass('open')
                // })
            
        });

    }
    
    //$('.pagination-info').appendTo('#btn-menu-col');

        $.ajax({
            type: "GET",
            url: "/Accounts/statusEnabled.json",
            cache: false,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: "",
            success: function(data) {
                $("#one").append('<td class="filled">'+data.enabled+'</td>');
            }
        });

        $.ajax({
            type: "GET",
            url: "/Accounts/statusDisabled.json",
            cache: false,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: "",
            success: function(data) {
               $("#two").append('<td class="filled">'+data.disabled+'</td>');
            }
        });

    function actionFormatter(value, row, index) {
        var texto = row["UserStatusId"] == 2 ? "Enable" : "Disable";
        var imgSrc = row["UserStatusId"] == 2 ? "icon_change.png" : "icon_change_verde.png";
        //console.log(row);

        return [
            '<a href="/Accounts/edituser/' + row["UserId"] + '" title="Editar">',
                '<img style="width:15px;margin:5px;" src="/img/icons/icon_edit.png" alt="Editar">',
            '</a>',
            '<a href="/Accounts/viewuser/' + row["UserId"] + '" title="Detalles">',
                '<img style="width:15px;margin:5px;" src="/img/icons/icon_view.png" alt="Detalles">',
            '</a>',
            '<a href="javascript:void(0)" onClick="ShowModalDelete(' + row["UserId"] +',' + row["UserStatusId"] + ')" title="Eliminar">',
            '<img style="width:15px;margin:5px;" src="/img/icons/icon_delete.png" alt="Eliminar">',
            '</a>',
            '<a href="javascript:void(0)" onClick="ShowModalChangeStatus(' + row["UserId"] +',' + row["UserStatusId"] + ')" title="'+ texto +'">',
                '<img style="width:15px;margin:5px;" src="/img/icons/'+ imgSrc +'" alt="'+ texto +'">',
            '</a>'
        ].join('');
    }

    function ShowModalDelete(id) {
        $("#TitlePri").html("<h5>Seguro que desea eliminar este usuario?</h5>");
        $("#btnDisablePri").css("display", "inline");
        $("#btnCancelPri").css("display", "inline");
        $("#btnOkPri").css("display", "none");
        $("#btnDisablePri").attr("onclick", "DeleteUser(" + id + ")");
        $("#DeleteUser").modal('show');
    }

    function DeleteUser(id) {
        $.ajax({
            data: "",
            type: 'GET',
            url: '/Accounts/deleteuser/' + id,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
				if (data.status==1){
					$("#TitlePri").html("<h5>Usuario Eliminado.</h5>");
					
					//Recargar la lista
					ListUsers();
				}else{
					$("#TitlePri").html("<h5>Usuario no Eliminado. Tiene publicaciones asociadas.</h5>");
				}
                $("#btnDisablePri").css("display", "none");
                $("#btnCancelPri").css("display", "none");
                $("#btnOkPri").css("display", "inline");
            },
            error: function(xhr, status) {
                var err = eval("(" + xhr.responseText + ")");
                alert("Error" + err.Message);
            }
        });
    }

    function showDrop(){
        $('.btn-group,span.dropup').click(function(){
           $(this).toggleClass('open');
           //$(this).find('button:first-child').attr('aria-expanded','true');  
        })
        $('span.dropup').click(function(){
            //$(this).find('button:first-child').addClass('open'); 
            $(this).addClass('open'); 
        })  
    }

    function ShowModalChangeStatus(id, statusUsr) {
        // Si es habilitar
        if (statusUsr == "1")
            $("#myModalLabel").html("Inactivar Usuario");
        else if (statusUsr == "2")
            $("#myModalLabel").html("Activar Usuario");

        // Text
        $("#Name").html("<h5>Seguro que desea cambiar el Estatus?</h5>");
        $("#btnDisable").css("display", "inline");
        $("#btnCancel").css("display", "inline");
        $("#btnCancel").text("No");
        $("#btnOk").css("display", "none");
        $("#btnDisable").attr("onclick", "ChangeStatusUser(" + id + ")");
        $("#ChangeStatusUser").modal('show');        
    }

    function ChangeStatusUser(id) {
        $.ajax({
            data: "",
            type: 'GET',
            url: '/Accounts/status/' + id,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                //console.log(data);
                if (data.status == "1")
                    $("#Name").html("<h5>Activado<h5>");                    
                else if (data.status == "2")
                    $("#Name").html("<h5>Inactivado<h5>");
                else 
                    $("#Name").html("<h5>Pendiente<h5>");
                
                // Cambia bot�n "no" por "ok"
                $("#btnDisable").css("display", "none");
                $("#btnCancel").text("OK");
                
                //Recarga la lista de usuarios.
                ListUsers();
            },
            error: function(xhr, status) {
                var err = eval("(" + xhr.responseText + ")");
                alert("Error" + err.Message);
            }
        });
    }
    $(document).ready(function(){
        // $('#div-menu-col').append('<button id="btn-menu-col">button</button>');
        ListUsers();
        showDrop();
        $('#btn-span').click(function(){
            $(this).addClass('open')
        })
    });
    // $(window).load(function() {

        
    //     // var button = $('#btn-menu-col');
    //     // $('.pagination-info').after(button);

    //     // $('#btn-menu-col').click(function(){
    //     //     $('#menu-col').toggle('fast')
    //     // });
    // });
</script>