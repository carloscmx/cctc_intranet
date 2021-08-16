<?php
$this->template->getHeader();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.24.0/ui/trumbowyg.min.css" integrity="sha512-baPsQggIoNC4ezJg68uPTtrEJ9OLY1SlnTnnDrYn+LgUBMbc1q5gSD9v5BN4+MWpfIG50AYhnCFmCDszbJaygw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .modal-lg {
        max-width: 80% !important;
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
                        <p class="m-b-0">Resumen del Panel.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <!--
                    <ul class="breadcrumb">
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
                                    <h5>Personal en linea</h5>
                                    <span>Monitoreo de personal</span>
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
                                            <input type="button" value="Nuevo" class="btn btn-success" onclick="javascript:$('#nproceso').modal('show')">

                                        </div>
                                        <div class="col-md-8"></div>

                                    </div>
                                    <table id="tprocesosint" class="table table-striped table-bordered" style="width:100%;  text-align: center;">
                                        <thead>
                                            <tr>
                                                <th>ID sistema</th>
                                                <th>Nombre</th>
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

<!--VER-->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="mproceso">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="mtitulo">TITLE</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea name="" id="mdescripcion" cols="30" rows="10" class="form-control" readonly></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!--EDITAR-->
<div class="modal" tabindex="-1" role="dialog" id="mprocesoedit">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Titulo: </h4> &nbsp;&nbsp;<input type="text" name="" id="mtituloedit" class="form-control">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="mdescripcionedit">Descripción de proceso:</label>
                <textarea id="mdescripcionedit" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnprocessedit">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!--NUEVO-->
<div class="modal" tabindex="-1" role="dialog" id="nproceso">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Titulo: </h4> &nbsp;&nbsp;<input type="text" name="" id="ntitulo" class="form-control">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="ndescripcion">Descripción de proceso:</label>
                <textarea name="" id="ndescripcion" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="" onclick="guardarProceso()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php
$this->template->getFooter();
echo setClassById("menu_procesos", "active pcoded-trigger");
echo setClassById("submenu_procesos_internos", "active");
echo setDataTable("tableProcesosint", "tprocesosint", base_url("CCProcesos/obetenerProcesosInternos"), array("code", "ps_nombre", "buttons"));
?>

<script>
    function verProceso(id) {
        var formData = new FormData();

        formData.append("ps_id", id);

        $.ajax({
            url: "<?= base_url("CCProcesos/obtenerProceso") ?>",
            method: "POST", //First change type to method here

            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var result = JSON.parse(response);

                $("#mtitulo").text(`${result.data.code} ${result.data.ps_nombre}`);
                // $("#mdescripcion").text(result.data.ps_descripcion);
                $('#mdescripcion').trumbowyg('html', result.data.ps_descripcion);


                $("#mproceso").modal("show");



            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }

        });
    }
</script>
<script>
    function editarProceso(id) {
        var formData = new FormData();
        formData.append("ps_id", id);
        $.ajax({
            url: "<?= base_url("CCProcesos/obtenerProceso") ?>",
            method: "POST", //First change type to method here

            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var result = JSON.parse(response);
                $("#mtituloedit").val(result.data.ps_nombre);
                $("#mdescripcionedit").val(result.data.ps_descripcion);
                $("#btnprocessedit").attr("onclick", `guardaredicionproceso(${result.data.ps_id})`);
                $('#mdescripcionedit').trumbowyg('html', result.data.ps_descripcion);
                $("#mprocesoedit").modal("show");

            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }

        });
    }
</script>

<script>
    function guardaredicionproceso(id) {
        var formData = new FormData();
        var ps_nombre = $("#mtituloedit").val();
        var ps_descripcion = $("#mdescripcionedit").val();
        formData.append("ps_id", id);
        formData.append("ps_nombre", ps_nombre);
        formData.append("ps_descripcion", ps_descripcion);

        $.ajax({
            url: "<?= base_url("CCProcesos/editarProceso") ?>",
            method: "POST", //First change type to method here

            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                <?= setAlert("Registro modificado", "success", false) ?>;
                tableProcesosint.ajax.reload();
                $("#mprocesoedit").modal("hide");


            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }

        });

    }
</script>
<?= setAlertConfirmDelete("eliminarProceso", base_url("CCProcesos/eliminarProceso"), "tableProcesosint.ajax.reload()"); ?>

<script>
    function guardarProceso() {
        var formData = new FormData();
        var ps_nombre = $("#ntitulo").val();
        var ps_descripcion = $("#ndescripcion").val();
        formData.append("ps_nombre", ps_nombre);
        formData.append("ps_descripcion", ps_descripcion);

        $.ajax({
            url: "<?= base_url("CCProcesos/guardarProceso") ?>",
            method: "POST", //First change type to method here

            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                <?= setAlert("Registro agregado", "success", false) ?>;
                tableProcesosint.ajax.reload();
                $("#nproceso").modal("hide");


            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }

        });

    }
</script>


<!-- Import Trumbowyg -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.24.0/trumbowyg.min.js">
</script>

<script>
    function htmlInitEditor() {
        $('#mdescripcion').trumbowyg({
            disabled: true
        });
        $('#mdescripcionedit').trumbowyg({
            btns: [
                ['viewHTML'],
                ['undo', 'redo'], // Only supported in Blink browsers
                ['formatting'],
                ['strong', 'em', 'del'],
                ['superscript', 'subscript'],
                ['link'],
                ['insertImage'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['removeformat'],
                ['fullscreen']
            ]
        });
        $('#ndescripcion').trumbowyg({});
    }
</script>

<?= onloadscript("htmlInitEditor") ?>