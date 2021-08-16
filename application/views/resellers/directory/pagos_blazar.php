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
                                    <h5>Registro de pagos</h5>
                                    <span>Ahora se podrán registrar de manera automática los pagos realizados por transferencias SPEI mediante nuestro servicio de Registro de Pago unicamente es necesario ingresar su numero de Factura y el monto, posteriormente adjuntar su comprobante de pago y la clave de rastreo para la verificación.</span>
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
                                <iframe src="https://pagos.blazar.mx/" frameborder="0" height="1000px" width="100%"></iframe>
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


echo setClassById("menu_herramientas", "active pcoded-trigger");
echo setClassById("submenu_herramientas_pagos", "active");
?>
