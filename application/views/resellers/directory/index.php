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
                                    <h5>Pedidos Pendendientes</h5>
                                    <span>Aqui puedes visualizar tus pedidos pendientes Recuerda que solo podras aceptar pedidos de tipo (Servidores Virtuales).</span>
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
                                    <table id="tblPedidos" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Numero de Orden</th>
                                                <th>Fecha de pedido</th>
                                                <th>Estado de pago</th>
                                                <th>Productos</th>
                                                <th>Costo del pedido</th>
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

<?php
echo $template['footer'];
echo setDataTable("tablePedidos", "tblPedidos", base_url("Resellers/CResellers/obtenerPedidosJsonFilter"), array("ordernum", "date", "paymentstatus", "itemspedidos", "costo", "buttons"));

echo setClassById("menu_pedidos", "active pcoded-trigger");
echo setClassById("submenu_pedidos_activos", "active");
?>

<script>
    function aceptarPedido(idpedido) {
        $(`#btnAcept${idpedido}`).attr('disabled', true);
        var formData = new FormData();
        formData.append("idpedido", idpedido);

        $.ajax({
            type: "POST",
            url: "<?= base_url("Resellers/CResellers/aceptarPedido") ?>",
            data: formData,
            async: false, //que espere respuesta
            processData: false,
            contentType: false,
            success: function(respuesta) {
                <?= setAlert("El pedido ha sido aceptado correctamente", "success", false) ?>;
                tablePedidos.ajax.reload();
            },
            error: function() {
                <?= setAlert("Ha ocurrido un error reportelo al equipo de soporte tecnico de Blazar", "error", false) ?>;
            }
        })
    }
</script>

<?= setAlertConfirmDelete("cancelarPedido", base_url("Resellers/CResellers/cancelarPedido"), " tablePedidos.ajax.reload(); "); ?>