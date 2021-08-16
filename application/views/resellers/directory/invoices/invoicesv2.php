<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/591dcbd78028bb73270468bc/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->
<?php

echo $template['head'];
?>

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
                                    <h5>Referencias</h5>
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

                                        <div class="col-md-04">
                                            <label>Filtos para Facturacion.</label>
                                            <select name="" id="" class="form-control" onchange="busquedaPorFacturacion(this)">
                                                <option value="0">Todos</option>
                                                <option value="1">No disponible</option>
                                                <option value="2">Pendientes por facturar</option>
                                                <option value="3">Facturados</option>
                                            </select>
                                        </div>
                                        <div class="col-md-04"></div>
                                        <div class="col-md-04"></div>
                                    </div>
                                    <table id="tblPedidos" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID Sistema</th>
                                                <th>Numero de referencia</th>
                                                <th>Estatus</th>
                                                <td>Fecha de creacion</td>
                                                <th>Fecha de pago</th>
                                                <th>Total</th>
                                                <th>Opciones</th>
                                                <th>Facturacion</th>
                                                <th>FacturacionID</th>

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
<div class="modal" tabindex="-1" role="dialog" id="modalfacturacion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Facturacion electronica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="">Seleccione la razon social con la que deseas realizar esta factura.</label>

                <select name="" id="cboRazonSocial" class="form-control">
                    <option value="0" selected disabled>--SELECCIONE UNA OPCION--</option>

                    <?php foreach ($razonessociales as $row) : ?>
                        <option value="<?= $row->id_relacion ?>"><?= $row->razonsocial ?> - <?= $row->rfc ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="" id="txtIDfactura" style="display: none;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="" onclick="verificarFactura()">Facturar</button>
                <button type=" button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php
echo $template['footer'];
echo setDataTable("tablePedidos", "tblPedidos", base_url("Resellers/CResellers/obtenerReferenciasCliente"), array("id", "invoicenum", "status", "date", "datepaid", "total", "referencias", "opcionfactura", "opcionfacturaid"));

echo setClassById("menu_facturacion", "active pcoded-trigger");
echo setClassById("submenu_facturacion_referencias", "active");

?>



<script>
    //## BUSQUEDA INVOICE RESELLER   tablePedidos.columns(7).visible(false).draw();

    tablePedidos.columns(8).visible(false).draw();
</script>
<script>
    function busquedaPorFacturacion(input) {
        if (input.value == 0) {
            tablePedidos.columns(8).search("").draw();

        } else {
            tablePedidos.columns(8).search(input.value).draw();
        }
    }
</script>


<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js
"></script>



<script>
    function advertenciaFactura(value) {
        $("#txtIDfactura").val(value);
        $("#modalfacturacion").modal("show");
    }
</script>
<script>
    function verificarFactura() {
        var $idfactura = $("#txtIDfactura").val();
        var $idrazonsocial = $("#cboRazonSocial").val();
        if ($idfactura == "" || $idrazonsocial == null) {
            <?= setAlert("Razon social no seleccionada.", "error", false) ?>;

        } else {
            empaquetadoFactura($idfactura, $idrazonsocial);
        }


    }
</script>

<script>
    function empaquetadoFactura(value, razonsocial) {
        $.LoadingOverlay("show", {
            image: "",
            text: "Espere un momento..."
        });
        var formData = new FormData();
        formData.append("idinvoice", value);
        formData.append("idrazonsocial", razonsocial);

        $.ajax({
            url: "<?= base_url("CFacturacion/CFacturav3v2/generarFactura") ?>",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var responseParse = JSON.parse(response);
                Swal.fire({
                    position: 'top-end',
                    icon: responseParse.result,
                    title: responseParse.motivo,
                    showConfirmButton: false,
                    timer: 10000
                });
                $.LoadingOverlay("hide");
                tablePedidos.ajax.reload();
                $("#modalfacturacion").modal("hide");
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $.LoadingOverlay("hide");
                <?= setAlert("Error intentelo nuevamente, si continua con este error reportelo a soporte tecnico mencionando el codigo de error: XHR-E001", "error", false) ?>;


            }
        });
    }
</script>