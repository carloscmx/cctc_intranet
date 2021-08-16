<?= $head ?>

<style>
    .flipswitch {
        position: relative;
        width: 48px;
    }

    .flipswitch input[type=checkbox] {
        display: none;
    }

    .flipswitch-label {
        display: block;
        overflow: hidden;
        cursor: pointer;
        border: 1px solid #999999;
        border-radius: 21px;
    }

    .flipswitch-inner {
        width: 200%;
        margin-left: -100%;
        transition: margin 0.3s ease-in 0s;
    }

    .flipswitch-inner:before,
    .flipswitch-inner:after {
        float: left;
        width: 50%;
        height: 19px;
        padding: 0;
        line-height: 19px;
        font-size: 15px;
        color: white;
        font-family: Trebuchet, Arial, sans-serif;
        font-weight: bold;
        box-sizing: border-box;
    }

    label {
        margin-bottom: 0 !important;
    }


    .flipswitch-inner:before {
        content: "SI";
        padding-left: 8px;
        background-color: #256799;
        color: #FFFFFF;
    }

    .flipswitch-inner:after {
        content: "NO";
        padding-right: 8px;
        background-color: #EBEBEB;
        color: #888888;
        text-align: right;
    }

    .flipswitch-switch {
        width: 16px;
        margin: 1.5px;
        background: #FFFFFF;
        border: 1px solid #999999;
        border-radius: 21px;
        position: absolute;
        top: 0;
        bottom: 0;
        right: 28px;
        transition: all 0.3s ease-in 0s;
    }

    .flipswitch-cb:checked+.flipswitch-label .flipswitch-inner {
        margin-left: 0;
    }

    .flipswitch-cb:checked+.flipswitch-label .flipswitch-switch {
        right: 0;
    }
</style>
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Bienvenido</h5>
                        <p class="m-b-0">Modulo - Comisiones.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Sample page</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Vendedores</h5>
                                    <span></span>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li>
                                                <i class="fa fa fa-wrench open-card-option"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-window-maximize full-card"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-minus minimize-card"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-refresh reload-card"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-trash close-card"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="submit" value="Nuevo" class="btn btn-success" onclick="javascript:openModalNuevo()">
                                        </div>
                                        <div class="col-md-8">

                                        </div>
                                    </div>
                                    <table class="table" id="tVendedores" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Numero de vendedor</th>
                                                <th>Nombre de vendedor</th>
                                                <th>(%) Ganancia</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" tabindex="-1" role="dialog" id="modalNuevoVendedor">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Vendedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="Nnombre">Nombre(s)</label>
                    </div>
                    <input type="text" name="" id="Nnombre" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="Napellidopat">Apellido paterno</label>
                    </div>
                    <input type="text" name="" id="Napellidopat" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="Napellidomat">Apellido materno</label>
                    </div>
                    <input type="text" name="" id="Napellidomat" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="Nporcentaje">Porcentaje de ganacias</label>
                    </div>
                    <input type="text" name="" id="Nporcentaje" class="form-control" <?= input_valid_numeric() ?> <?= input_valid_numeric_max() ?>>
                    <label class="input-group-text" for="Nporcentaje">(%)</label>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="" onclick="GuardarVendedor()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalEditarVendedor">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Vendedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="Enombre">Nombre(s)</label>
                    </div>
                    <input type="text" name="" id="Enombre" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="Eapellidopat">Apellido paterno</label>
                    </div>
                    <input type="text" name="" id="Eapellidopat" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="Eapellidomat">Apellido materno</label>
                    </div>
                    <input type="text" name="" id="Eapellidomat" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="Eporcentaje">Porcentaje de ganacias</label>
                    </div>
                    <input type="text" name="" id="Eporcentaje" class="form-control" <?= input_valid_numeric() ?> <?= input_valid_numeric_max() ?>>
                    <label class="input-group-text" for="Nporcentaje">(%)</label>
                    <input type="text" name="" id="Eidvendedor" style="display:none">
                </div>


                <div class="input-group mb-3">
                    <label for="">Habilitar Login?</label>
                    &nbsp;<div class="flipswitch">
                        <input type="checkbox" name="flipswitch" class="flipswitch-cb" id="fsUser">
                        <label class="flipswitch-label" for="fsUser">
                            <div class="flipswitch-inner"></div>
                            <div class="flipswitch-switch"></div>
                        </label>
                    </div>
                    &nbsp;&nbsp;<a id="rPassword" href="#" onclick="javascript:alert('ok')" style="display:none">Resetear Credenciales</a>
                </div>
                <div class="input-group mb-3" id="divCorreo" style="display:none">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="lg_correo">Correo electronico</label>
                    </div>
                    <input type="text" name="" class="form-control" id="lg_correo">

                </div>
                <div class="input-group mb-3" id="divUsuario" style="display:none">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="lg_usuario">Nombre de usuario</label>
                    </div>
                    <input type="text" name="" class="form-control" id="lg_usuario">
                    <input type="text" name="" id="lg_action" style="display: none;">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="" onclick="GuardarEditarVendedor()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<?php
echo $footer;
echo setClassById("menu_comisiones", "active pcoded-trigger");
echo setClassById("submenu_vendedores", "active");

echo setDataTable("tableVendedores", "tVendedores", base_url("CComisiones/getVendedores"), array("ven_id_num_config", "ven_nombrecompleto_config", "ven_porcentaje_config", "buttons"));
echo init_input_valid_numeric();
echo init_input_valid_numeric_max();
?>
<?= setAlertConfirmDelete("confirmarEliminar", base_url("CComisiones/deleteVendedores"), " tableVendedores.ajax.reload(); "); ?>


<script>
    function abrirModificar(id) {
        $("#fsUser").prop('checked', false);
        $("#lg_correo").val("");
        $("#lg_usuario").val("");
        $("#lg_action").val("create");
        $.ajax({
            url: "<?= base_url("CComisiones/getVendedores") ?>",
            method: "POST", //First change type to method here

            data: {
                query: true,
                ven_idvendedor: id,
            },
            success: function(response) {
                var result = JSON.parse(response);
                $("#Enombre").val(result.data[0].ven_nombre);
                $("#Eapellidopat").val(result.data[0].ven_ape_pat);
                $("#Eapellidomat").val(result.data[0].ven_ape_mat);
                $("#Eporcentaje").val(result.data[0].ven_porcentaje);
                $("#Eidvendedor").val(result.data[0].ven_idvendedor);
                $("#modalEditarVendedor").modal("show");
                validarCheckUser();
                abrirConfigurarUsuario(id);


            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }

        });
    }
</script>

<script>
    function abrirConfigurarUsuario(id) {
        $.ajax({
            url: "<?= base_url("CComisiones/getUsers") ?>",
            method: "POST", //First change type to method here

            data: {
                query: true,
                lg_external_id: id,
                lg_usuarios_lg_perfiles_id: 2
            },
            success: function(response) {
                var result = JSON.parse(response);
                if (!jQuery.isEmptyObject(result.data)) {
                    $("#lg_action").val("update");
                    $("#lg_correo").val(result.data[0].lg_usuarios_correo);
                    $("#lg_usuario").val(result.data[0].lg_usuarios_nombre);
                    if (result.data[0].lg_activo == 1) {
                        $("#fsUser").prop('checked', true);
                        validarCheckUser();

                    }
                }
            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }

        });

    }
</script>

<script>
    function openModalNuevo() {
        limpiarCampoVendedor();
        $("#modalNuevoVendedor").modal("show");
    }
</script>


<script>
    function limpiarCampoVendedor() {
        $("#Nnombre").val("");
        $("#Napellidopat").val("");
        $("#Napellidomat").val("");
        $("#Nporcentaje").val("");
    }
</script>
<script>
    function camposVendedor() {
        var status = true;
        var ven_nombre = $("#Nnombre").val();
        var ven_ape_pat = $("#Napellidopat").val();
        var ven_ape_mat = $("#Napellidomat").val();
        var ven_porcentaje = $("#Nporcentaje").val();
        if (ven_nombre == "") {
            status = false
        }
        if (ven_ape_pat == "") {
            status = false
        }
        if (ven_ape_mat == "") {
            status = false
        }
        if (ven_porcentaje == "") {
            status = false
        }

        return status;


    }
</script>
<script>
    function camposEditarVendedor() {
        var status = true;
        var ven_nombre = $("#Enombre").val();
        var ven_ape_pat = $("#Eapellidopat").val();
        var ven_ape_mat = $("#Eapellidomat").val();
        var ven_porcentaje = $("#Eporcentaje").val();
        var Eidvendedor = $("#Eidvendedor").val();

        if (ven_nombre == "") {
            status = false
        }
        if (ven_ape_pat == "") {
            status = false
        }
        if (ven_ape_mat == "") {
            status = false
        }
        if (ven_porcentaje == "") {
            status = false
        }
        if (Eidvendedor == "") {
            status = false;
        }
        return status;


    }
</script>

<script>
    function GuardarVendedor() {
        if (camposVendedor()) {
            var formData = new FormData();
            formData.append("ven_nombre", $("#Nnombre").val());
            formData.append("ven_ape_pat", $("#Napellidopat").val());
            formData.append("ven_ape_mat", $("#Napellidomat").val());
            formData.append("ven_porcentaje", $("#Nporcentaje").val());
            $.ajax({
                url: "<?= base_url("CComisiones/insertVendedores") ?>",
                method: "POST", //First change type to method here

                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    <?= setAlert("Se ha modificado correcmante", "success", false) ?>;
                    tableVendedores.ajax.reload();
                    $("#modalNuevoVendedor").modal("hide");


                },
                error: function() {
                    <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                }

            });
        } else {

            <?= setAlert("Verifique sus datos", "error", false) ?>;
        }
    }
</script>
<script>
    function GuardarEditarVendedor() {
        if (camposEditarVendedor()) {
            var formData = new FormData();
            formData.append("ven_nombre", $("#Enombre").val());
            formData.append("ven_ape_pat", $("#Eapellidopat").val());
            formData.append("ven_ape_mat", $("#Eapellidomat").val());
            formData.append("ven_porcentaje", $("#Eporcentaje").val());
            formData.append("ven_idvendedor", $("#Eidvendedor").val());

            $.ajax({
                url: "<?= base_url("CComisiones/updateVendedores") ?>",
                method: "POST",

                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    <?= setAlert("Se ha modificado correcmante", "success", false) ?>;
                    tableVendedores.ajax.reload();
                    $("#modalEditarVendedor").modal("hide");
                    var inputUser = validarInputUser();
                    if (inputUser.lg_habilitado_user) {
                        var idvendedor = $("#Eidvendedor").val();
                        guardarUsuario(idvendedor);
                    } else {
                        if (inputUser.lg_habilitado_user == false && $("#lg_action").val() == "update") {
                            var idvendedor = $("#Eidvendedor").val();

                            $.ajax({
                                url: "<?= base_url("CComisiones/disableVendedoresCliente") ?>",
                                type: "POST",
                                data: {
                                    "lg_external_id": idvendedor
                                },
                                success: function(response) {
                                    <?= setAlert("Usuario modificado correctamente", "success", false) ?>;
                                },
                                error: function() {
                                    <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                                }

                            });
                        }
                    }


                },
                error: function() {
                    <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                }

            });
        } else {

            <?= setAlert("Verifique sus datos", "error", false) ?>;
        }
    }
</script>

<script>
    $("#fsUser").on("click", function() {
        validarCheckUser();
    });
</script>

<script>
    function validarCheckUser() {
        if ($("#fsUser").is(':checked')) {
            $("#divCorreo").show();
            $("#divUsuario").show();

        } else {
            $("#divCorreo").hide();
            $("#divUsuario").hide();
        }
    }
</script>

<script>
    function validarInputUser() {
        var lg_usuario = $.trim($("#lg_usuario").val());
        var lg_correo = $.trim($("#lg_correo").val());
        var lg_habilitado_user = false;
        var trimiado = false;
        if (lg_correo != "" && lg_correo != "") {
            trimiado = true;

        }
        if ($("#fsUser").is(':checked')) {
            var lg_habilitado_user = true;
        }
        var result = `{
            "lg_correo": "${lg_correo}",
            "lg_usuario": "${lg_usuario}",
            "trimiado": ${trimiado},
            "lg_habilitado_user": ${lg_habilitado_user}

        }`;
        return $.parseJSON(result);

    }

    function guardarUsuario(idusario) {
        var inputsuser = validarInputUser();
        if (inputsuser.trimiado) {
            var formData = new FormData();
            formData.append("lg_usuarios_nombre", inputsuser.lg_usuario);
            formData.append("lg_usuarios_correo", inputsuser.lg_correo);
            formData.append("lg_external_id", idusario);
            formData.append("lg_action", $("#lg_action").val());



            $.ajax({
                url: "<?= base_url("CComisiones/insertUserVendedor") ?>",
                method: "POST",

                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    <?= setAlert("Usuario modificado correctamente", "success", false) ?>;
                },
                error: function() {
                    <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                }

            });

        } else {
            <?= setAlert("No fue posible generar el usuario porque los campos no estaban llenados correctamente", "error", false) ?>;

        }
    }
</script>