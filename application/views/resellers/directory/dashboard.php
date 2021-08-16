<?php
echo $template['head'];
?>
<!--
<style>
    .cabecera {
        /*  width: 165px; */
        height: 110px;


    }

    .textosdiv {
        position: relative;
        top: 50%;
        left: 50%;
        height: auto;

        transform: translate(-50%, -50%);
    }
</style>
-->

<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Bienvenido</h5>
                        <p class="m-b-0">Intranet, versión: <?= vesion_stash() ?>.</p>
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
                                    <h5>Dashboard</h5>
                                    <span>Bienvenido a intranet, aqui podras visualizar el resumen de tus servicios.</span>
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
                                        <div class="col-md-3">
                                            <div class="card mat-clr-stat-card text-white blue">
                                                <div class="card-block">
                                                    <div class="row" style=" cursor: pointer;" onclick="showWindowsOption(1)">
                                                        <div class="col-3 text-center bg-c-blue">
                                                            <i class="fas fa-trophy mat-icon f-24"></i>
                                                        </div>
                                                        <div class="col-9 cst-cont" id="divTotalActivos">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card mat-clr-stat-card text-white blue">
                                                <div class="card-block">
                                                    <div class="row" style=" cursor: pointer;" onclick="showWindowsOption(2)">
                                                        <div class="col-3 text-center bg-c-blue">
                                                            <i class="fas fa-chart-line mat-icon f-24"></i>
                                                        </div>
                                                        <div class="col-9 cst-cont" id="divTotalActivosMes">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="card mat-clr-stat-card text-white blue">
                                                <div class="card-block">
                                                    <div class="row" style=" cursor: pointer;" onclick="showWindowsOption(3)">
                                                        <div class="col-3 text-center bg-c-blue">
                                                            <i class="fas fa-chart-area mat-icon f-24"></i>
                                                        </div>
                                                        <div class="col-9 cst-cont" id="divTotalCanceladosMes">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">

                                            <div class="card mat-clr-stat-card text-white blue">
                                                <div class="card-block">
                                                    <div class="row">
                                                        <div class="col-3 text-center bg-c-blue">
                                                            <i id="icon"></i>
                                                        </div>
                                                        <div class="col-9 cst-cont" id="divCrecimiento">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row" id="row1">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Todos los servicios activos</h5>
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
                                <div class="card-block ">
                                    <div>
                                        <table id="tableActive" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ID sistema</th>
                                                    <th>Tipo de servicio</th>
                                                    <th>Nombre</th>
                                                    <th>Dia de registro</th>
                                                    <th>Proximo vencimiento</th>
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
                    <div class="row" id="row2">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Servicios activos del mes</h5>
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
                                    <table id="tableActiveMes" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID sistema</th>
                                                <th>Tipo de servicio</th>
                                                <th>Nombre</th>
                                                <th>Dia de registro</th>
                                                <th>Proximo vencimiento</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row" id="row3">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Servicios cancelados del mes</h5>
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
                                    <table id="tableCanceladosMes" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID sistema</th>
                                                <th>Tipo de servicio</th>
                                                <th>Nombre</th>
                                                <th>Dia de registro</th>
                                                <th>Proximo vencimiento</th>
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

echo setClassById("link_home", "active");
echo setDataTable("tableServicesActives", "tableActive", base_url("Resellers/CResellers/obternerServiciosJsonActivo"), array("id", "typeservice", "domain", "regdate", "nextduedate", "referencias"));
echo setDataTable("tableServicesActivesMes", "tableActiveMes", base_url("Resellers/CResellers/obternerServiciosActivosMes"), array("id", "typeservice", "domain", "regdate", "nextduedate"));
echo setDataTable("tableServicesCancelledMes", "tableCanceladosMes", base_url("Resellers/CResellers/obternerServiciosCanceladosMes"), array("id", "typeservice", "domain", "regdate", "nextduedate"));
?>

<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js
"></script>
<script>
    $.LoadingOverlay("show");

    // Hide it after 3 seconds
</script>


<script>
    function obtenerEstadisticas() {
        $.ajax({
            url: "<?= base_url("Resellers/CResellers/generarEstadisticas") ?>",
            type: 'post',
            contentType: false,
            processData: false,
            success: function(response) {
                var responseParse = JSON.parse(response);
                $('#divTotalActivos').append(`<spam style="font-size: 2em">${responseParse.totalactivos}</spam><br><spam style="font-size:14px">Servicios activos.</spam>`);
                $('#divTotalActivosMes').append(`<spam style="font-size: 2em">${responseParse.activosmes}</spam><br><spam style="font-size:14px">Servicios activos este mes.</spam>`);
                $('#divTotalCanceladosMes').append(`<spam style="font-size: 2em">${responseParse.canceladosmes}</spam><br><spam style="font-size:12px">Servicios cancelados este mes.</spam>`);
                $('#divCrecimiento').append(`<spam style="font-size: 2em">${responseParse.porcentajecrecimiento}%</spam><br><spam style="font-size:14px">Porcentaje de crecimiento.</spam>`);
                $("#icon").attr("class", `fas fa-${responseParse.icon} mat-icon f-24`);
                $.LoadingOverlay("hide");
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $.LoadingOverlay("hide");
                <?= setAlert("Error intentelo nuevamente", "error", false) ?>;


            }
        });
    }
</script>

<?= onloadscript("obtenerEstadisticas") ?>


<script>
    function hideDivs() {
        $('#row1').hide();
        $('#row2').hide();
        $('#row3').hide();
    }
</script>
<script>
    function showWindowsOption(id) {
        hideDivs();
        switch (id) {
            case 1:
                $('#row1').show();
                break;
            case 2:
                $('#row2').show();
                break;
            case 3:
                $('#row3').show();
                break;
        }

    }
</script>

<?= onloadscript("hideDivs") ?>
<?= hidelat() ?>