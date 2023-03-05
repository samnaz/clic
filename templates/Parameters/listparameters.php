<div class="div-container">
    <div class="row">
        <div class="col-sm-12">
            <div id="div-menu-col"></div>
            <!-- BOOTSTRAP TABLE -->
            <table class="table table-striped info-table" id="table-pagination" data-url="" data-toggle="table" data-show-columns="true" data-search="true" data-show-export="true" data-pagination="true">
                <thead>
                    <tr>
                        <th data-field="ParameterId" data-align="left" data-halign="left" data-sortable="true">Nombre</th>
                        <th data-field="Value" data-align="left" data-halign="left" data-sortable="true">Valor</th>
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
    
    function ListParameters(){
        $.ajax({
            type: "GET",
            url: "/Parameters/getparameters.json",
            cache: false,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: "",
            success: function(data) {			
				$('#table-pagination').bootstrapTable('load', data.Parameters);
            }
        });

    }
	
    function actionFormatter(value, row, index) {
                return [
            '<a href="/Parameters/editparameter/' + row["ParameterId"] + '" title="Editar">',
                '<img style="width:15px;margin:5px;" src="/img/icons/icon_edit.png" alt="Editar">',
            '</a>',
            '<a href="/Parameters/viewparameter/' + row["ParameterId"] + '" title="Detalle">',
                '<img style="width:15px;margin:5px;" src="/img/icons/icon_view.png" alt="Detalle">',
            '</a>'
        ].join('');
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
        ListParameters();
        showDrop();
        $('#btn-span').click(function(){
            $(this).addClass('open')
        })
    });    
</script>