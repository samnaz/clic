<div class="div-container">
    <?php echo $this->Form->create(null, ['type' => 'file', 'id' => 'importUsersFrom', 'name'=>'importUsersFrom']); ?>
        <div class="row">
            <div class="col-sm-12">
                <table class="container-yellow">
                    <tr class="yellow-row">
                        <td>Select your file:</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="div-container" style="margin-bottom:10px;margin-top:10px;">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="btn-upload" style="margin:0;">
                                            Upload file
                                            <?php
                                                echo $this->Form->file('user-file', ['id' => 'user-file', 'name' => 'user-file']);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="file-text" id="txtFile">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <br><br>
                                        Please, select the file to be imported*
                                        <br><br>
                                        If the file presents a wrong schema, it will be rejected*
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <!-- Mensaje de alerta de validacion de formulario -->
            <div class="col-sm-12">
                <div class="alert alert-danger" id="alertForm" style="display:none;"></div>
            </div>
            <!-- Mensaje de alerta de validacion de formulario -->
            <!-- Boton de Formulario -->
            <div class="col-sm-12 text-right">
                 <?php
                    echo $this->Form->button('Add', ['type' => 'submit', 'class' => 'btn btn-submit', 'onclick' => 'validateForm()']);
                ?>
            </div>
            <!-- Boton de Formulario -->
        </div>
    <?php echo $this->Form->end(); ?>
</div>

<script type="text/javascript">
    $(function() {
        $("#user-file").on("change", function()
        {
            var txtFile = $("#user-file").val();
            $("#txtFile").text($("#user-file").val());
            var str = txtFile.split("\\");
            $("#txtFile").text(str[str.length - 1]);
        });
    });

    function validateForm() {

        var file = $('input[type="file"]').val();
        if (file == "") {
            $("#alertForm").show(500);
            $("#alertForm").text("You must to attach a File.");
            return false;
        }
        
        var exts = ['doc','docx','txt','xls','xlsx', 'tsv'];
        // first check if file field has any value
        if (file) {
        // split file name at dot
        var get_ext = file.split('.');
        // reverse name to check extension
        get_ext = get_ext.reverse();
        // check file type is valid as given in 'exts' array
        if ($.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){
          //console.log(file);
        }   else {
          $("#alertForm").show(500);
          $("#alertForm").text("Error! You must to attach a correct file.");
          return false;
            }
        }

        $("#alertForm").hide(500);
        $("#importUsersForm").submit();
    }
</script>