<div class="div-container">
    <div class="row">
        <div class="col-sm-12">
            <div id="div-menu-col"></div>
            <!-- BOOTSTRAP TABLE -->
            <table class="table table-striped info-table" id="table-pagination" data-url="" data-toggle="table" data-show-columns="true" data-search="true" data-show-export="true" data-pagination="true">
                <thead>
                    <tr>
                        <th data-field="Name" data-align="left" data-halign="left" data-sortable="true">País</th>
                        <th data-formatter="actionFormatter" data-align="Center" data-halign="Center" data-sortable="true">Acciones</th>
                    </tr>
                </thead>
            </table>
            <!-- BOOTSTRAP TABLE -->
            
        </div>
    </div>   
</div>
<!-- MODAL PARA ELIMINAR MARCAS -->
<div class="modal fade" id="DeleteState" tabindex="-1" role="dialog" aria-labelledby="DeleteState">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalDelete">Eliminar País</h4>
            </div>

            <div id="TitlePri" class="modal-body" style="background-color:#F5F5F5">
                <h5>Seguro que desea eliminar este País?</h5>
            </div>

            <div class="modal-footer">
                <button id="btnDisablePri" type="button" class="btn btn-default menuBtn" style="width:15%"><strong>S&iacute;</strong></button>
                <button id="btnCancelPri" type="button" class="btn btn-default menuBtn" style="width:15%;" data-dismiss="modal"><strong>No</strong></button>
                <button id="btnOkPri" type="button" class="btn btn-default menuBtn" style="width:15%; display:none;" data-dismiss="modal"><strong>Aceptar</strong></button>
            </div>

        </div>
    </div>
</div>

<script language='javascript'>
    
    var visible = false;
    
    function ListCountries(){
        $.ajax({
            type: "GET",
            url: "/Tables/getCountries.json",
            cache: false,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: "",
            success: function(data) {
                $('#table-pagination').bootstrapTable('load', data.Countries);
            }
        });

    }
	
    function actionFormatter(value, row, index) {
                return [
            '<a href="/Tables/editcountry/' + row["CountryId"] + '" title="Editar">',
                '<img style="width:15px;margin:5px;" src="/img/icons/icon_edit.png" alt="Editar">',
            '</a>',
            '<a href="/Tables/viewcountry/' + row["CountryId"] + '" title="Detalle">',
                '<img style="width:15px;margin:5px;" src="/img/icons/icon_view.png" alt="Detalle">',
            '</a>',
            '<a href="javascript:void(0)" onClick="ShowModalDelete(' + row["CountryId"] + ')" title="Eliminar">',
            '<img style="width:15px;margin:5px;" src="/img/icons/icon_delete.png" alt="Eliminar">',
            '</a>'
        ].join('');
    }

    function ShowModalDelete(id) {
        $("#TitlePri").html("<h5>Seguro que desea eliminar este País?</h5>");
        $("#btnDisablePri").css("display", "inline");
        $("#btnCancelPri").css("display", "inline");
        $("#btnOkPri").css("display", "none");
        $("#btnDisablePri").attr("onclick", "DeleteCountry(" + id + ")");
        $("#DeleteState").modal('show');
    }

    function DeleteCountry(id) {
        $.ajax({
            data: "",
            type: 'GET',
            url: '/Tables/deleteCountry/' + id,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                $("#TitlePri").html("<h5>País Eliminado.</h5>");
                $("#btnDisablePri").css("display", "none");
                $("#btnCancelPri").css("display", "none");
                $("#btnOkPri").css("display", "inline");

                //Recargar la lista
                ListCountries();
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
    
    $(document).ready(function(){
        // $('#div-menu-col').append('<button id="btn-menu-col">button</button>');
        ListCountries();
        showDrop();
        $('#btn-span').click(function(){
            $(this).addClass('open')
        })
    });    
</script>