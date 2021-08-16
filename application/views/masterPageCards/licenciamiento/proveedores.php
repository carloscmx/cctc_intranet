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
                                <div class="row">
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="sel1">Provedor predeterminado:</label>
                                            <select class="form-control" id="proveedorprede" onchange="javascript:cambiarProveedorPreterminado(this)">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-7"></div>
                                </div>
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="submit" value="Nuevo" class="btn btn-success" onclick="javascript:openModalNuevo()">
                                        </div>
                                        <div class="col-md-8">

                                        </div>
                                    </div>
                                    <table class="table" id="tProveedor" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nombre de proveedor</th>
                                                <th>Correo</th>
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


<div class="modal" tabindex="-1" role="dialog" id="modalnuevoproveedor">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar nuevo proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="Nnombreprov">Nombre</label>
                    </div>
                    <input type="text" name="" id="Nnombreprov" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="Napellidopatprov">Apellido Paterno</label>
                    </div>
                    <input type="text" name="" id="Napellidopatprov" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="Napellidomatprov">Apellido materno</label>
                    </div>
                    <input type="text" name="" id="Napellidomatprov" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="Ncorreoprov">Correo electronico</label>
                    </div>
                    <input type="text" name="" id="Ncorreoprov" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="guardarNuevoProveedor()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalproveedor">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modificar proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="nombreprov">Nombre</label>
                    </div>
                    <input type="text" name="" id="nombreprov" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="apellidopatprov">Apellido Paterno</label>
                    </div>
                    <input type="text" name="" id="apellidopatprov" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="apellidomatprov">Apellido materno</label>
                    </div>
                    <input type="text" name="" id="apellidomatprov" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="correoprov">Correo electronico</label>
                    </div>
                    <input type="text" name="" id="correoprov" class="form-control">
                </div>

                <div id="accordion" role="tablist" aria-multiselectable="true">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnGuardarModal">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<?php
$this->template->getFooter();
?>

<script>
    function openModalNuevo() {
        limpiarCamposNuevo();
        $("#modalnuevoproveedor").modal("show");
    }
</script>

<script>
    function limpiarCamposNuevo() {
        $("#Nnombreprov").val("");
        $("#Napellidopatprov").val("");
        $("#Napellidomatprov").val("");
        $("#Ncorreoprov").val("");
    }
</script>
<script>
    function guardarNuevoProveedor() {
        var formData = new FormData();
        formData.append("nombres", $("#Nnombreprov").val());
        formData.append("apellidopat", $("#Napellidopatprov").val());
        formData.append("apellidomat", $("#Napellidomatprov").val());
        formData.append("correoproveedor", $("#Ncorreoprov").val());
        $.ajax({
            url: "<?= base_url("CLicenciamiento/insertProveedores") ?>",
            method: "POST",

            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                <?= setAlert("Se ha modificado correcmante", "success", false) ?>;
                tableProveedor.ajax.reload();
                actualizarSelectorPredeterminado();
                $("#modalnuevoproveedor").modal("hide");
            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }
        });
    }
</script>
<script>
    function cambiarProveedorPreterminado(selector) {
        var proveedor = $(selector).val();
        $.ajax({
            url: "<?= base_url("CLicenciamiento/UpdatePredeterminadoProveedores") ?>",
            method: "POST", //First change type to method here

            data: {
                "id": proveedor
            },
            success: function(response) {
                <?= setAlert("Guardado", "success", false) ?>;


            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }

        });
    }
</script>

<!--FUNCION PARA RECUPERAR EL PROVEEDOR PREDETERMINAO-->
<script>
    function actualizarSelectorPredeterminado() {
        $.ajax({
            url: "<?= base_url("CLicenciamiento/getProveedoresdata") ?>",
            method: "POST", //First change type to method here

            data: {},
            success: function(response) {
                var result = JSON.parse(response);
                var htmlselect = "";
                var predeterminado = false;
                for (var i = 0; i < result.data.length; i++) {
                    var seleccionado = "";
                    if (result.data[i].activo == 2) {
                        //   console.log(result.data[i]);
                        seleccionado = "selected";
                        predeterminado = true;
                    }
                    htmlselect += `
                <option value="${result.data[i].idprovedor}" ${seleccionado}>${result.data[i].nombrecompleto}</option>
                `;

                }
                if (!predeterminado) {
                    htmlselect += `
                    <option disabled selected>Selecciona una opción</option>
                `;
                }


                $("#proveedorprede").html(htmlselect);

            },
            error: function() {
                <?= setAlert("Ha ocurrido un error, cuando se intento cargar el proveedor predeterminado", "error", false) ?>;
            }

        });
    }
</script>
<script>
    function abrirModificar(id) {
        $.ajax({
            url: "<?= base_url("CLicenciamiento/getProveedoresdata") ?>",
            method: "POST", //First change type to method here

            data: {
                query: true,
                idprovedor: id, // Second add quotes on the value.
            },
            success: function(response) {
                $("#btnGuardarModal").removeAttr("onclick");
                var result = JSON.parse(response);

                $("#nombreprov").val(result.data[0].nombres);
                $("#apellidopatprov").val(result.data[0].apellidopat);
                $("#apellidomatprov").val(result.data[0].apellidomat);
                $("#correoprov").val(result.data[0].correoproveedor);
                $("#btnGuardarModal").attr("onclick", `editarProveedor(${result.data[0].idprovedor})`);
                $("#modalproveedor").modal("show");
                obtenerProductosProveedor(id);

            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }

        });

    }
</script>


<script>
    function obtenerProductosProveedor(id) {
        var formData = new FormData();
        formData.append("idprov", id);
        formData.append("query", true);
        $.ajax({
            url: "<?= base_url("CLicenciamiento/getProvedorLicenciaData") ?>",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var data = JSON.parse(response);
                var licenciasactivas = data['encontrado'];
                var licenciasnoactivas = data['noencontrado'];
                var html = "";
                for (var x = 0; x < licenciasactivas.length; x++) {
                    var habilitado = "";
                    var deshabilitado = "selected";
                    if (licenciasactivas[x]['activolic'] == 1) {
                        habilitado = "selected";
                        deshabilitado = "";
                    }
                    html += `       <div class="accordion-panel">
                        <div class="accordion-heading" role="tab" id="headingOne">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg waves-effect waves-dark" data-toggle="collapse" data-parent="#accordion" href="#collapse-up-${licenciasactivas[x]['idlicprov']}" aria-expanded="true" aria-controls="collapse-up-${licenciasactivas[x]['idlicprov']}">
                                ${licenciasactivas[x]['nombrelicencia']}
                                </a>
                            </h3>
                        </div>
                        <div id="collapse-up-${licenciasactivas[x]['idlicprov']}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="accordion-content accordion-desc">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="nombreprov">Costo</label>
                                    </div>
                                    <input type="text" name="" id="costocompra-up-${licenciasactivas[x]['idlicprov']}" class="form-control" value="${licenciasactivas[x]['costocompra']}" onkeyup="javascript:validarCantidad(this)">
                                    <select name="" id="status-up-${licenciasactivas[x]['idlicprov']}">
                                        <option value="1" ${habilitado}>Habilitado</option>
                                        <option value="0" ${deshabilitado}>Deshabilitado</option>

                                    </select>
                                    <input type="button" value="Guardar" class="btn btn-success" onclick="actualizarlicencia(${licenciasactivas[x]['idlicprov']},${licenciasactivas[x]['idprov']})">
                                </div>

                            </div>
                        </div>
                    </div>`;
                }

                for (var x = 0; x < licenciasnoactivas.length; x++) {
                    html += `<div class="accordion-panel">
                    <div class="accordion-heading" role="tab" id="headingOne">
                        <h3 class="card-title accordion-title">
                            <a class="accordion-msg waves-effect waves-dark" data-toggle="collapse" data-parent="#accordion" href="#collapse${licenciasnoactivas[x]['idlicencia']}" aria-expanded="true" aria-controls="collapse${licenciasnoactivas[x]['idlicencia']}">
                            ${licenciasnoactivas[x]['nombrelicencia']}
                            </a>
                        </h3>
                    </div>
                    <div id="collapse${licenciasnoactivas[x]['idlicencia']}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="accordion-content accordion-desc">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="nombreprov">Costo</label>
                                </div>
                                <input type="text" name="" id="costocompra${licenciasnoactivas[x]['idlicencia']}" class="form-control" value="0.00" onkeyup="javascript:validarCantidad(this)">

                                <select name="" id="status${licenciasnoactivas[x]['idlicencia']}">
                                                        <option value="1">Habilitado</option>
                                                        <option value="0" selected>Deshabilitado</option>

                                                    </select>
                                <input type="button" value="Guardar" class="btn btn-success" onclick="guardarlicencia(${id},${licenciasnoactivas[x]['idlicencia']})">
                            </div>

                        </div>
                    </div>
                </div>`;

                }
                $("#accordion").html(html);
            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }
        });
    }
</script>

<?= setAlertConfirmDelete("confirmarEliminar", base_url("CLicenciamiento/deleteProveedores"), "tableProveedor.ajax.reload(); actualizarSelectorPredeterminado()"); ?>

<script>
    function editarProveedor(id) {
        var formData = new FormData();
        formData.append("idprovedor", id);
        formData.append("nombres", $("#nombreprov").val());
        formData.append("apellidopat", $("#apellidopatprov").val());
        formData.append("apellidomat", $("#apellidomatprov").val());
        formData.append("correoproveedor", $("#correoprov").val());
        $.ajax({
            url: "<?= base_url("CLicenciamiento/updateProveedores") ?>",
            method: "POST", //First change type to method here

            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                <?= setAlert("Se ha modificado correcmante", "success", false) ?>;

                tableProveedor.ajax.reload();
                actualizarSelectorPredeterminado();
                $("#modalproveedor").modal("hide");


            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }

        });

    }
</script>



<script>
    function actualizarlicencia(idlicprov, proveedor) {
        var costocompra = parseFloat($(`#costocompra-up-${idlicprov}`).val());
        if (costocompra >= 0) {
            var formData = new FormData();
            formData.append("idlicprov", idlicprov);
            formData.append("costocompra", costocompra);
            formData.append("activo", $(`#status-up-${idlicprov}`).val());
            $.ajax({
                url: "<?= base_url("CLicenciamiento/UpdateProveedorLicencia") ?>",
                method: "POST", //First change type to method here

                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    <?= setAlert("Actualizado correctamente", "success", false) ?>;

                    obtenerProductosProveedor(proveedor);



                },
                error: function() {
                    <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                }

            });
        } else {
            <?= setAlert("Verifique los campos", "error", false) ?>;

        }

    }
</script>
<script>
    function guardarlicencia(idproveedor, idtipolicencia) {
        var costocompra = parseFloat($(`#costocompra${idtipolicencia}`).val());
        if (costocompra >= 0) {
            var formData = new FormData();
            formData.append("activo", $(`#status${idtipolicencia}`).val());
            formData.append("costocompra", costocompra);
            formData.append("idprov", idproveedor);
            formData.append("idtipolicencia", idtipolicencia);
            $.ajax({
                url: "<?= base_url("CLicenciamiento/insertProveedorLicencia") ?>",
                method: "POST", //First change type to method here

                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    <?= setAlert("Guardado correcmante", "success", false) ?>;
                    obtenerProductosProveedor(idproveedor);
                },
                error: function() {
                    <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                }
            });

        } else {
            <?= setAlert("Verifique los campos", "error", false) ?>;

        }

    }
</script>

<script>
    function validarCantidad(evento) {
        evento.value = evento.value.replace(/[^0-9.]/g, "");
    }
</script>

<?php
echo setClassById("menu_licencia", "active pcoded-trigger");
echo setClassById("submenu_proveedores", "active");
echo setDataTable("tableProveedor", "tProveedor", base_url("CLicenciamiento/getProveedoresdata"), array("nombrecompleto", "correoproveedor", "buttons"));
echo loadscript("actualizarSelectorPredeterminado");
?>