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
                                    <table id="" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Usuario</th>
                                                <th>Ultima visita</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($staff->staffonline->staff))  foreach ($staff->staffonline->staff as $row) : ?>
                                                <tr>
                                                    <td><?= $row->adminusername; ?></td>
                                                    <td><?= $row->lastvisit; ?></td>
                                                </tr>
                                            <?php endforeach;
                                            else {
                                                echo "<tr style='text-align: center'><th colspan='2'>Sin personal disponible</th></tr>";
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Pedidos</h5>
                                    <span>Monitoreo de pedidos</span>
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
                                    <table id="" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Numero de Orden</th>
                                                <th>Estado de pago</th>
                                                <th>Cliente</th>
                                                <th>Producto</th>
                                                <th>Costo</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php if (isset($ordenespendiente->orders->order)) foreach ($ordenespendiente->orders->order as $row) : ?>
                                                <tr>
                                                    <td><?= $row->ordernum; ?></td>
                                                    <td><?= $row->paymentstatus; ?></td>
                                                    <td><?= $row->name; ?></td>
                                                    <td><?= $row->lineitems->lineitem[0]->product; ?></td>
                                                    <td><?= $row->lineitems->lineitem[0]->amount; ?> (<?= $row->lineitems->lineitem[0]->billingcycle; ?>)</td>
                                                </tr>
                                            <?php endforeach;
                                            else {
                                                echo "<tr style='text-align: center'><th colspan='6'>Sin pedidos</th></tr>";
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                    <table id="" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Ticket</th>
                                                <th>Departamento</th>
                                                <th>Asunto</th>
                                                <th>Cliente</th>
                                                <th>Estatus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($tickets->tickets->ticket)) foreach ($tickets->tickets->ticket as $row) : ?>
                                                <tr onclick='javascript:window.open("<?= $patch_panel ?>RHde/supporttickets.php?action=view&id=<?= $row->id ?>","_blank")' style="cursor: pointer;">
                                                    <td><?= $row->tid; ?></td>
                                                    <td><?= $row->deptname; ?></td>
                                                    <td><?= $row->subject; ?></td>
                                                    <td><?= $row->owner_name; ?></td>
                                                    <td><?= $row->status; ?></td>
                                                </tr>
                                            <?php endforeach;
                                            else {
                                                echo "<tr style='text-align: center'><th colspan='5'>Buen trabajo no existen tickets pendientes!</th></tr>";
                                            }
                                            ?>
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
echo setClassById("link_home", "active");
?>