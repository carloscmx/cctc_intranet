<?php
$this->template->getHeader();
?>

<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Licenciamiento- Tipos de licencia.</h5>
                        <p class="m-b-0">En este apartado puedes configurar el tipo de licencias.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Sample page</a>
                        </li>
                    </ul>
                    -->
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
                                    <h5>Tipos de licencias de Windows</h5>
                                    <span>Versiones y tipos de licencia de Windows</span>
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
                                            <input type="submit" value="Nuevo" class="btn btn-success" onclick="javascript:nuevoTipoLicencia()">
                                        </div>
                                        <div class="col-md-8">

                                        </div>
                                    </div>
                                    <table class="table" id="tTipoLicencia" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nombre de licencia</th>
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

<div class="modal" tabindex="-1" role="dialog" id="modallicencia">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modificar licencia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="nombreLicencia">Nombre de licencia</label>
                    </div>
                    <input type="text" name="" id="nombreLicencia" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="comparativoPanel">Nombre comparativo Panel</label>
                    </div>
                    <input type="text" name="" id="comparativoPanel" class="form-control">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnGuardarModal">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalNuevoTIpo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modificar licencia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="NuevonombreLicencia">Nombre de licencia</label>
                    </div>
                    <input type="text" name="" id="NuevonombreLicencia" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="NuevocomparativoPanel">Nombre comparativo Panel</label>
                    </div>
                    <input type="text" name="" id="NuevocomparativoPanel" class="form-control">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="" onclick="GuardarNuevoTipoLicencia()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<?php
$this->template->getFooter();
echo setClassById("menu_licencia", "active pcoded-trigger");
echo setClassById("submenu_tipolicencia", "active");
echo setDataTable("tableTipoLicencia", "tTipoLicencia", base_url("CLicenciamiento/getTiposLicencia"), array("nombrelicencia", "buttons"));
?>

<script>
    function abrirModificar(id) {
        $.ajax({
            url: "<?= base_url("CLicenciamiento/getTiposLicencia") ?>",
            method: "POST", //First change type to method here

            data: {
                query: true,
                idlicencia: id, // Second add quotes on the value.
            },
            success: function(response) {
                $("#btnGuardarModal").removeAttr("onclick");
                var result = JSON.parse(response);

                $("#nombreLicencia").val(result.data[0].nombrelicencia);
                $("#comparativoPanel").val(result.data[0].comparativoPanel);
                $("#btnGuardarModal").attr("onclick", `editarTipoLicencia(${result.data[0].idlicencia})`);
                $("#modallicencia").modal("show");

            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }

        });

    }
</script>

<?= setAlertConfirmDelete("confirmarEliminar", base_url("CLicenciamiento/deleteTipoLicencias"), "tableTipoLicencia.ajax.reload()"); ?>

<script>
    function editarTipoLicencia(id) {
        var formData = new FormData();
        formData.append("idlicencia", id);
        formData.append("nombrelicencia", $("#nombreLicencia").val());
        formData.append("comparativoPanel", $("#comparativoPanel").val());



        $.ajax({
            url: "<?= base_url("CLicenciamiento/updateTipoLicencias") ?>",
            method: "POST", //First change type to method here

            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                <?= setAlert("Se ha modificado correcmante", "success", false) ?>;
                tableTipoLicencia.ajax.reload();
                $("#modallicencia").modal("hide");


            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }

        });

    }
</script>

<script>
    function nuevoTipoLicencia() {
        $("#NuevonombreLicencia").val("");
        $("#NuevocomparativoPanel").val("");
        $("#modalNuevoTIpo").modal("show");
    }
</script>

<script>
    function GuardarNuevoTipoLicencia() {

        var nuevoTipo = $.trim($("#NuevonombreLicencia").val());
        var nuevoComparativo = $.trim($("#NuevocomparativoPanel").val());
        if (nuevoTipo == "" || nuevoComparativo == "") {
            <?= setAlert("Verifique los datos", "error", false) ?>;
        } else {
            var formData = new FormData();
            formData.append("nombrelicencia", nuevoTipo);
            formData.append("comparativoPanel", nuevoComparativo);



            $.ajax({
                url: "<?= base_url("CLicenciamiento/insertTipoLicencia") ?>",
                method: "POST", //First change type to method here

                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    <?= setAlert("Se ha modificado correcmante", "success", false) ?>;
                    tableTipoLicencia.ajax.reload();
                    $("#modalNuevoTIpo").modal("hide");


                },
                error: function() {
                    <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                }

            });
        }

    }
</script>