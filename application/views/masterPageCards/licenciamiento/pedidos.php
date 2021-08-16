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

                                    <table class="table" id="tTipoLicencia" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No. Pedido</th>
                                                <th>Proveedor</th>
                                                <th>Tipo Licencia</th>
                                                <th>Fecha de pedido</th>
                                                <th>Responsable</th>
                                                <th>Cantidad</th>
                                                <th>Costo Total</th>
                                                <th>Estatus de pedido</th>
                                                <th>Estatus Pago</th>
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



<div class="modal" tabindex="-1" role="dialog" id="modalDetalle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detalleTitulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detalleCuerpo">


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
echo setClassById("submenu_pedidos", "active");
echo setDataTable("tableTipoLicencia", "tTipoLicencia", base_url("CLicenciamiento/obtenerPedidosJson"), ["npedido", "vendedor", "tipolicencia", "tsp_fecha_pedido", "var_autoriza", "int_cantidad_licencia", "costototal", "estatuspedido", "estatuspago", "verdetalles"]);


?>

<script>
    function verDetalle(id) {
        $.ajax({
            url: "<?= base_url("CLicenciamiento/obtenerPedidosJsonWhere") ?>",
            method: "POST", //First change type to method here

            data: {
                idpedido: id
            },

            success: function(response) {
                result = JSON.parse(response);
                let masinfo = ``;
                if (result.data.int_activo_pedido == 2) {
                    masinfo = `<hr><h5>Detalles de entrega.</h5><p>Fecha de entrega: ${result.data.tsp_fecha_entrega}</p><p>Licencia: ${result.data.txt_licencia}</p><p>Cantidad de licencias CAL: ${result.data.int_numero_cal}</p><p>Licencia CAL: ${result.data.var_serie_cal}</p>`;
                }
                let masinfopago = ``;
                if (result.data.int_estatus_pago == 1) {
                    masinfopago = `<hr><h5>Detalles de pago.</h5><p>Pagado por: ${result.data.var_autoriza_pago}</p><p>Fecha de Pago: ${result.data.tsp_fecha_pago}</p>`;
                }


                $(`#detalleTitulo`).html(`Pedido: ${result.data.npedido}`);
                let info = `<p>Proveedor: ${result.data.vendedor}</p><p>Solicitado por: ${result.data.var_autoriza}</p><p>Fecha de pedido: ${result.data.tsp_fecha_pedido}</p><p>Tipo de licencia: ${result.data.tipolicencia}</p><p>Cantidad de dispotivos: ${result.data.int_cantidad_licencia}</p><p>Costo unitario: $${result.data.dou_costo_licencia}</p><p>Costo total: ${result.data.costototal}</p><p>Estatus pedido: ${result.data.estatuspedido}</p><p>Estatus de pago: ${result.data.estatuspago}</p><p>Nota: ${result.data.txt_nota}</p>${masinfo}${masinfopago}`;
                $(`#detalleCuerpo`).html(info);

                $("#modalDetalle").modal("show");
            },
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }

        });
    }
</script>
<script>
    function marcarPago(id) {
        Swal.fire({
            title: '¿Estas seguro?',
            text: 'Esta acción no sera reversible',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Marcar como pagado'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "<?= base_url("CLicenciamiento/mandarPagoPedido") ?>",
                    method: "POST", //First change type to method here
                    data: {
                        idpedido: id
                    },
                    success: function(response) {
                        Swal.fire(
                            'PAGADO!',
                            'Este pedido ha sido pagado correctamente.',
                            'success'
                        );
                        tableTipoLicencia.ajax.reload();
                    },
                    error: function() {
                        <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                    }

                });
            }
        })
    }
</script>