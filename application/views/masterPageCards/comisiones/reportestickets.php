<?php

$this->template->getHeader();
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.bootstrap.min.css">

<style>
    .ui-datepicker-calendar {
        display: none;
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
                        <p class="m-b-0">Modulo Reportes de tickets y comisiones de Panel Blazar.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <!--     <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Sample page</a>
                        </li>
                    </ul> -->
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
                                    <h5>Reporte Tickets y comisiones</h5>
                                    <span>Seleccione un operador y un mes para generar el reporte.</span>
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
                                        <div class="col-md-5">
                                            <p>Busqueda inteligente: </p>
                                            <select name="" id="bInteligente">
                                                <option value="">Operador</option>
                                            </select>
                                        </div>
                                        <div class=" col-md-7">
                                            <p for="startDate">Mes :</p>
                                            <input name="startDate" id="startDate" class="date-picker" />
                                            <input type="submit" value="Ver reporte" class="btn btn-success" onclick="generarReporte()">
                                        </div>

                                    </div>
                                    <table class="table" id="tReferencias" style="width:100%" class="display nowrap">
                                        <thead>
                                            <tr>
                                                <th>Operador</th>
                                                <th>ID Ticket</th>
                                                <th>Fecha</th>
                                                <th>Fecha cierre</th>
                                                <th>Cliente</th>
                                                <th>Asunto</th>
                                                <th>Departamento</th>
                                                <th>Comisión </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th colspan="" style="text-align:right">Total de comisión:</th>
                                                <th></th>


                                            </tr>
                                        </tfoot>
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
echo setClassById("menu_comisiones", "active pcoded-trigger");
echo setClassById("submenu_vendedores_reportes_tickets", "active");
?>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js
"></script>
<script>
    function setVendedor() {
        return $("#bInteligente option:selected").text();
    }
</script>
<!--FUNCION PARA RECUPERAR EL PROVEEDOR PREDETERMINAO-->
<script>
    function ActualizarSelectorbInteligente() {
        $.ajax({
            url: "<?= base_url("CComisiones/getOperadores") ?>",
            method: "POST", //First change type to method here
            success: function(response) {

            },
            error: function() {
                <?= setAlert("Ha ocurrido un error, cuando se intento cargar el selector de busqueda", "error", false) ?>;
            }

        }).done(function(response) {
            var result = JSON.parse(response);
            var htmlselect = `<option value="0" selected>Todos</option>`;
            for (var i = 0; i < result.admin_users.length; i++) {

                htmlselect += `
                    
                <option value="${result.admin_users[i].id}">${result.admin_users[i].firstname} ${result.admin_users[i].lastname}</option>
                `;
            }
            $("#bInteligente").html(htmlselect);
        });
    }
</script>

<?= loadscript("ActualizarSelectorbInteligente"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
<script>
    $(function() {
        $('.date-picker').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: false,
            dateFormat: 'yy-mm',
            onClose: function(dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
        });
    })
</script>

<script src="//cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.7.0/js/buttons.bootstrap.min.js"></script>
<script src=" https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js "></script>
<script src=" https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js "></script>
<script src=" https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js "></script>
<script src=" https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js "></script>
<script src=" https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js "></script>
<script src=" https://cdn.datatables.net/buttons/1.7.0/js/buttons.bootstrap4.min.js "></script>
<script>
    var oTblReport = $("#tReferencias");

    function generarReporte() {
        var idoperador = $("#bInteligente").val();
        var startDate = $("#startDate").val();
        var posicioncelda = 7;

        if (startDate.trim() != "") {
            $.LoadingOverlay("show", {
                image: "",
                text: "Espere un momento..."
            });
            $.ajax({
                url: "<?= base_url("CComisiones/getComisionesTickets") ?>",
                method: "POST", //First change type to method here
                data: {
                    "id": idoperador,
                    "date": startDate
                },
                success: function(response) {



                },
                error: function() {
                    $.LoadingOverlay("text", "Ha ocurrido un error...");

                    setTimeout(function() {
                        $.LoadingOverlay("hide");
                    }, 2500);

                    <?= setAlert("Datos no encotrados", "error", false) ?>;
                    oTblReport.DataTable({
                        "bDestroy": true,
                        "data": [{
                            "nombre": "Sin registros",
                            "empresa": "",
                            "nreferencia": "",
                            "fechapago": "",
                            "subtotal": 0.00,
                            "ganaciacomision": 0.00

                        }],
                        "columns": [{
                                "data": "operador"
                            },
                            {
                                "data": "id"
                            },
                            {
                                "data": "date"
                            },
                            {
                                "data": "lastreply"
                            },
                            {
                                "data": "name"
                            },
                            {
                                "data": "subject"
                            },
                            {
                                "data": "deptname"
                            },
                            {
                                "data": "bono"
                            }
                        ],
                        "footerCallback": function(row, data, start, end, display) {
                            var api = this.api(),
                                data;

                            // Remove the formatting to get integer data for summation
                            var intVal = function(i) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '') * 1 :
                                    typeof i === 'number' ?
                                    i : 0;
                            };

                            // Total over all pages
                            total = api
                                .column(posicioncelda)
                                .data()
                                .reduce(function(a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                            // Total over this page
                            pageTotal = api
                                .column(posicioncelda, {
                                    page: 'current'
                                })
                                .data()
                                .reduce(function(a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                            // Update footer
                            $(api.column(posicioncelda).footer()).html(
                                `$ ${Number.parseFloat(total).toFixed(2)}`
                            );
                        }
                    });
                }

            }).done(function(response) {
                $.LoadingOverlay("text", "Recopilando la información ...");
                setTimeout(function() {
                    $.LoadingOverlay("hide");
                }, 3000);
                var jsonString = JSON.parse(response) //for testing
                oTblReport.DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copyHtml5',
                            footer: true
                        },
                        {
                            extend: 'excelHtml5',
                            footer: true
                        },
                        {
                            extend: 'csvHtml5',
                            footer: true
                        },
                        {
                            extend: 'pdfHtml5',
                            orientation: 'landscape',
                            footer: true,
                            message: `Reporte del mes: ${startDate}
                                Operador: ${setVendedor()}
                                `,
                        }
                    ],
                    "bDestroy": true,
                    "data": jsonString,
                    "columns": [{
                            "data": "operador"
                        },
                        {
                            "data": "id"
                        },
                        {
                            "data": "date"
                        },
                        {
                            "data": "lastreply"
                        },
                        {
                            "data": "name"
                        },
                        {
                            "data": "subject"
                        },
                        {
                            "data": "deptname"
                        },
                        {
                            "data": "bono"
                        }
                    ],

                    "footerCallback": function(row, data, start, end, display) {
                        var api = this.api(),
                            data;

                        // Remove the formatting to get integer data for summation
                        var intVal = function(i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                i : 0;
                        };

                        // Total over all pages
                        total = api
                            .column(posicioncelda)
                            .data()
                            .reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        // Total over this page
                        pageTotal = api
                            .column(posicioncelda, {
                                page: 'current'
                            })
                            .data()
                            .reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        // Update footer
                        $(api.column(posicioncelda).footer()).html(
                            `$ ${Number.parseFloat(total).toFixed(2)}`
                        );
                    }
                });
            });
        } else {
            <?= setAlert("Seleccione el mes del reporte", "error", false) ?>;

        }

    }
</script>

<script>