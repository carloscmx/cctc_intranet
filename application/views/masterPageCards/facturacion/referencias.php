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
                                    <h5>Tickets</h5>
                                    <span>Monitoreo de tickets</span>
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
                                                <th>Cliente</th>
                                                <th>Estatus</th>
                                                <td>Fecha de creacion</td>
                                                <th>Fecha de pago</th>
                                                <th>Total</th>
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

<?php
$this->template->getFooter();
echo setClassById("menu_facturacion", "active pcoded-trigger");
echo setClassById("submenu_facturacion_facturacion", "active");
echo setDataTable("tablePedidos", "tblPedidos", base_url("CFacturacionadmin/obtenerReferenciasCliente"), array("id", "invoicenum", "cliente", "status", "date", "datepaid", "total", "opcionfactura", "opcionfacturaid"));
?>

<script>
    //tablePedidos.columns(6).visible(false).draw();

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
        Swal.fire({
            title: 'Precaución',
            text: 'Este proceso demora hasta 1 minuto por lo que te pedimos NO refrescar o cerrar esta pestaña.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Timbrar'
        }).then((result) => {

            if (result.isConfirmed) {
                Swal.fire(
                    'Solicitud en curso.',
                    'Tu solicitud está siendo procesada actualmente.',
                    'success'
                );
                $.LoadingOverlay("show");
                empaquetadoFactura(value);

            }
        });
    }
</script>

<script>
    function empaquetadoFactura(value) {
        var formData = new FormData();
        formData.append("idinvoice", value);
        $.ajax({
            url: "<?= base_url("CFacturacion/CFacturav3admin/generarFactura") ?>",
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
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $.LoadingOverlay("hide");
                <?= setAlert("Error intentelo nuevamente, si continua con este error reportelo a soporte tecnico mencionando el codigo de error: XHR-E001", "error", false) ?>;


            }
        });
    }
</script>