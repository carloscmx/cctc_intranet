<?php
$this->template->getHeader();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css" integrity="sha512-0nkKORjFgcyxv3HbE4rzFUlENUMNqic/EzDIeYCgsKa/nwqr2B91Vu/tNAu4Q0cBuG4Xe/D1f/freEci/7GDRA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Licenciamiento- Stock de licencias.</h5>
                        <p class="m-b-0">En este apartado puedes configurar o relacionar las licencias a servicios o clientes.</p>
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
                                    <input type="submit" value="Nueva Licencia" class="btn btn-success" onclick="javascript:$('#modalLicencia').modal('show');">



                                    <input type="submit" value="Solicitar Licencia" class="btn btn-info" onclick="javascript:$('#modalSolicitarLicencia').modal('show');">

                                    <table class="table" id="tStock" class="table table-striped table-bordered" style="width:100%;  text-align: center;">
                                        <thead>
                                            <tr>
                                                <th>Licencia</th>
                                                <th>Cantidad de dispositivos</th>
                                                <th>Tipo de licencia</th>
                                                <th>Fecha de compra</th>
                                                <th>Costo de compra</th>
                                                <th>Codigo CAL</th>
                                                <th>Cantidad CAL</th>
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

<div class="modal" tabindex="-1" role="dialog" id="modalLicencia">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva licencia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="nproveededor">Proovedor</label>
                    </div>
                    <select name="" id="nproveededor" class="form-control">
                        <?php foreach ($proveedores as $row) : ?>

                            <option value="<?= $row->idprovedor ?>"><?= $row->nombres . " " . $row->apellidopat ?></option>

                        <?php endforeach; ?>


                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="mlicencia">Numero de licencia</label>
                    </div>
                    <input type="text" name="" id="mlicencia" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="mnumerolicencia">Cantidad de dispositivos</label>
                    </div>
                    <input type="text" name="" id="mnumerolicencia" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="ntipolicencia">Tipo de licencia</label>
                    </div>
                    <select name="" id="ntipolicencia" class="form-control">
                        <?php foreach ($tipolicencia as $rows) : ?>

                            <option value="<?= $rows->idlicencia ?>"><?= $rows->nombrelicencia ?></option>

                        <?php endforeach; ?>


                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="nestatus">Estatus de licencia</label>
                    </div>
                    <select name="" id="nestatus" class="form-control" onchange="javascript:validardiv()">
                        <?php foreach ($estatuslicencia as $rows) : ?>

                            <option value="<?= $rows['value'] ?>"><?= $rows['nombre'] ?></option>

                        <?php endforeach; ?>


                    </select>
                </div>

                <div class="input-group mb-3" id='div'>
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="fchacompra">Fecha de compra</label>
                    </div>
                    <input name="" id="fchacompra" class="form-control" type="date">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="ccostocompra">Costo de compra</label>
                    </div>
                    <input type="text" name="" id="ccostocompra" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="ccodigocal">Codigo CAL</label>
                    </div>
                    <input type="text" name="" id="codigocals" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="ccostocompra">Cantidad CAL</label>
                    </div>
                    <input type="text" name="" id="cantidadcals" class="form-control">
                </div>
                <div class="input-group mb-3" id='divfventa'>
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="fchaventa">Fecha de venta</label>

                    </div>
                    <input name="" id="fchaventa" class="form-control" type="date">
                </div>
                <div class="input-group mb-3" id='divcventa'>
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="ccostoventa">Costo de venta</label>
                    </div>
                    <input type="text" name="" id="ccostoventa" class="form-control">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="javascript:guardarLicencia()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modalRelacion">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Relacion para la licencia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="tipoRelacionLicencia">Tipo de relacion</label>
                    </div>
                    <select name="" id="tipoRelacionLicencia" class="form-control">
                        <option disabled selected value> -- Seleccione una opcion -- </option>

                        <option value="1">Cliente</option>
                        <option value="2">Servicio</option>
                    </select>

                </div>
                <select id="BuscadorRelacionLicencia" disabled class="form-control">
                    <option disabled selected value> -- Seleccione una opcion -- </option>
                </select>
                <input type="text" name="" id="idlicenciaRelacion" style="display: none;">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="javascript:madarAlertaLicenciaInsertar()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalSolicitarLicencia">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Solicitud de licencia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="pedidoProveedor">Proovedor</label>
                    </div>
                    <select name="" id="pedidoProveedor" class="form-control">
                        <?php foreach ($proveedores as $row) : ?>

                            <option value="<?= $row->idprovedor ?>"><?= $row->nombres . " " . $row->apellidopat ?></option>

                        <?php endforeach; ?>


                    </select>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="pedidoTipoLicencia">Tipo de licencia</label>
                    </div>
                    <select name="" id="pedidoTipoLicencia" class="form-control">
                        <?php foreach ($tipolicencia as $rows) : ?>

                            <option value="<?= $rows->idlicencia ?>"><?= $rows->nombrelicencia ?></option>

                        <?php endforeach; ?>


                    </select>
                </div>


                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="pedidoCantidadPc">Cantidad de PC</label>
                    </div>
                    <input type="text" name="" id="pedidoCantidadPc" class="form-control">
                </div>
                <div class="input-group mb-3">

                    <textarea id="pedidoNota" class="form-control" placeholder="Nota*"></textarea>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="javascript:solicitarLicencia()">Solicitar Licencia</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalTrasladoLicencia">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de traslado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="trasladoResponsable">Responsable</label>
                    </div>
                    <input type="text" name="" id="trasladoResponsable" class="form-control" readonly>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="trasladoFecha">Fecha de traslado</label>
                    </div>
                    <input type="text" name="" id="trasladoFecha" class="form-control" readonly>
                </div>

                <div>
                    <p class="form-control"><strong id="trasladoDetalles"></strong></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php
$this->template->getFooter();
echo setClassById("menu_licencia", "active pcoded-trigger");
echo setClassById("submenu_stock", "active");
echo setDataTable("tableStock", "tStock", base_url("CLicenciamiento/getLicencias"), array("licencia", "cantidadlicencia", "nombrelicencia", "fechacompra", "costocompralic", "codigocals", "cantidadcals", "opciones"));
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js
"></script>


<script>
    function limpiarCampos() {
        $("#mlicencia").val("");
        $("#nestatus").val("");
        $("#fchacompra").val("");
        $("#ccostocompra").val("");
        $("#ccostoventa").val("");
        $("#fchaventa").val("");
        $("#cantidadcals").val("");
        $("#codigocals").val("");

    }
</script>

<script>
    function objectdata() {
        var arr = []

        let proveededor = $("#nproveededor").val();
        let mlicencia = $("#mlicencia").val();
        let ntipolicencia = $("#ntipolicencia").val();
        let nestatus = $("#nestatus").val();
        let fchacompra = $("#fchacompra").val();
        let ccostocompra = $("#ccostocompra").val();
        let ccostoventa = $("#ccostoventa").val();
        let fchaventa = $("#fchaventa").val();
        let cantidadcals = $("#cantidadcals").val();
        let codigocals = $("#codigocals").val();
        let mnumerolicencia = $("#mnumerolicencia").val();

        arr['proveededor'] = proveededor;
        arr['mlicencia'] = mlicencia;
        arr['ntipolicencia'] = ntipolicencia;
        arr['nestatus'] = nestatus;
        arr['fchacompra'] = fchacompra;
        arr['ccostocompra'] = ccostocompra;
        arr['fchaventa'] = fchaventa;
        arr['ccostoventa'] = ccostoventa;
        arr['cantidadcals'] = cantidadcals;
        arr['codigocals'] = codigocals;
        arr['mnumerolicencia'] = mnumerolicencia;
        var data = {
            "proveededor": proveededor,
            "mlicencia": mlicencia,
            "ntipolicencia": ntipolicencia,
            "nestatus": nestatus,
            "fchacompra": fchacompra,
            "ccostocompra": ccostocompra,
            "fchaventa": fchaventa,
            "ccostoventa": ccostoventa,
            "cantidadcals": cantidadcals,
            "codigocals": codigocals,
            "mnumerolicencia": mnumerolicencia
        };
        return data;


    }
</script>

<script>
    function guardarLicencia() {
        var licencia = objectdata();
        $.ajax({
            url: "<?= base_url("CLicenciamiento/insertLicencia") ?>",
            method: "POST", //First change type to method here

            data: licencia,
            // contentType: false,
            // processData: false,
            success: function(response) {
                limpiarCampos();
                <?= setAlert("Registro agregado", "success", false) ?>;
                tableStock.ajax.reload();
                $("#modalLicencia").modal("hide");


            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }

        });

    }
</script>
<script>
    validardiv();

    function validardiv() {

        if ($("#nestatus").val() == 2) {
            $("#divfventa").show();
            $("#divcventa").show();

        } else {
            $("#divfventa").hide();
            $("#divcventa").hide();
        }

    }
</script>


<script>
    function solicitarLicencia() {
        var pedidoProveedor = $(`#pedidoProveedor`).val();
        var pedidoTipoLicencia = $(`#pedidoTipoLicencia`).val();
        var pedidoCantidadPc = $(`#pedidoCantidadPc`).val();
        var pedidoNota = $(`#pedidoNota`).val();
        var data = {
            "pedidoProveedor": pedidoProveedor,
            "pedidoTipoLicencia": pedidoTipoLicencia,
            "pedidoCantidadPc": pedidoCantidadPc,
            "pedidoNota": pedidoNota
        };
        $("#modalSolicitarLicencia").modal("hide");


        $.ajax({
            url: "<?= base_url("CLicenciamiento/solicitarLicencia") ?>",
            method: "POST", //First change type to method here

            data: data,
            // contentType: false,
            // processData: false,
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status == "success") {
                    <?= setAlert("Pedido Generado Correctamente.", "success", false) ?>;

                    $(`#pedidoCantidadPc`).val("");
                    $(`#pedidoNota`).val("");
                    $("#modalLicencia").modal("hide");
                } else {
                    <?= setAlert("No se ha configurado el precio de esta licencia para este proveedor.", "error", false) ?>;

                }


            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                $(`#pedidoCantidadPc`).val("");
                $(`#pedidoNota`).val("");
                $("#modalLicencia").modal("hide");
            }

        });


    }
</script>

<script>
    function verRelacionLicencia(id) {
        $("#idlicenciaRelacion").val(id);
        $("#tipoRelacionLicencia").prop('selectedIndex', 0);
        $("#modalRelacion").modal("show");
    }
</script>
<script>
    $('#tipoRelacionLicencia').change(function() {
        var $select_elem = $("#BuscadorRelacionLicencia");
        $select_elem.prop('selectedIndex', 0);
        $select_elem.prop("disabled", true);
        $select_elem.chosen("destroy");


        //   $("#BuscadorRelacionLicencia").prop('selectedIndex', 0);
        // $("#BuscadorRelacionLicencia").prop("disabled", true);


        var valor = $(this).val();

        $.ajax({
            url: "<?= base_url("CLicenciamiento/obtenerDatosRelacionLicencia") ?>",
            method: "POST",
            data: {
                tiporelacion: valor
            },
            success: function(response) {

            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;

            }

        }).done(function(data) {
            let result = JSON.parse(data);

            $select_elem
                .empty()
                .append('<option  selected value> -- Seleccione una opcion -- </option>');
            $select_elem.prop('selectedIndex', 0);
            $select_elem.prop("disabled", false);
            for (var i = 0; i < result.length; i++) {
                var newOption = new Option(result[i].text, result[i].id, false, false);
                $select_elem.append(newOption).trigger('change');
            }
            $select_elem.chosen({
                no_results_text: "Oops, no encontrado!"
            });





        });

    });
</script>

<script>
    function madarAlertaLicenciaInsertar() {

        var $tipoRelacionLicencia = $("#tipoRelacionLicencia").val();
        var $BuscadorRelacionLicencia = $("#BuscadorRelacionLicencia").val();
        if (!$tipoRelacionLicencia || !$BuscadorRelacionLicencia) {
            <?= setAlert("Verifique los datos antes de trasladar la licencia", "error", false) ?>;
        } else {
            Swal.fire({
                title: '¿Estas seguro?',
                text: 'Esta acción no sera reversible',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Transferir licencia'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: "<?= base_url("CLicenciamiento/transferirLicencia") ?>",
                        method: "POST", //First change type to method here
                        data: {
                            tipoRegistro: $tipoRelacionLicencia,
                            idexterno: $BuscadorRelacionLicencia,
                            id_lic_stock: $("#idlicenciaRelacion").val()

                        },
                        success: function(response) {
                            Swal.fire(
                                'Exito!',
                                'Licencia transferida correctamente.',
                                'success'
                            );
                            $("#modalRelacion").modal("hide");
                            tableStock.ajax.reload();
                        },
                        error: function() {
                            <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                        }

                    });
                }
            })
        }

    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>
    $(document).ready(function() {

        $('#mlicencia').mask("AAAAA-AAAAA-AAAAA-AAAAA-AAAAA", {
            placeholder: "XXXXX-XXXXX-XXXXX-XXXXX-XXXXX"
        });

        $('#mlicencia').keyup(function() {
            var valor = $(this).val();
            $(this).val(valor.toUpperCase());
        });
        $('#mlicencia').change(function() {
            var valor = $(this).val();
            $(this).val(valor.toUpperCase());
        });

    });
</script>

<script>
    function verRelacionLicenciaLicencia(id) {
        $.ajax({
            url: "<?= base_url("CLicenciamiento/getTrasladoIdStockLicencia") ?>",
            method: "POST", //First change type to method here
            data: {
                id_lic_stock: id
            },
            success: function(response) {
                let result = JSON.parse(response);
                $("#trasladoResponsable").val(result.var_tras_responsable);
                $("#trasladoFecha").val(result.tsp_tras_fecha_mov);
                $("#trasladoDetalles").html(result.detalle);
                $("#modalTrasladoLicencia").modal("show");

            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }

        });
    }
</script>