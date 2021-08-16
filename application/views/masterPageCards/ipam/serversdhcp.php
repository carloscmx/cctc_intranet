<?php
$this->template->getHeader();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.1.0/select2.css" integrity="sha512-yg/sdAodl6RKjmJtbJkej9HrE1CL6r6xD+8SY3KC/0w+zkL8TMBNkbN4nhQUASPrZTrWTqqSeVy82wjLyoXrMA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">IPAM - Serviores DHCP</h5>
                        <!-- <p class="m-b-0">Resumen del Panel.</p> -->
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
                                    <h5>Servidores DHCP</h5>
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
                                        <div class="col-md-12">
                                            <input type="submit" value="Nuevo servidor DHCP" onclick="javascript:$('#modalNuevoDhcp').modal('show')" class="btn btn-success">
                                            <br><br>
                                        </div>
                                    </div>
                                    <table id="tChr" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Servidor DHCP</th>
                                                <th>IP</th>
                                                <th>Servicio relaciondo</th>
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

<div class="modal" tabindex="-1" role="dialog" id="modalNuevoDhcp">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo servidor DHCP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="#" id="frmServidorDhcp">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="txtNombreServidor">Nombre de servidor</label>
                        </div>
                        <input type="text" name="txtNombreServidor" class="form-control" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="txtDireccionServidor">Direccion del servidor</label>
                        </div>
                        <input type="text" name="txtDireccionServidor" class="form-control" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="txtNombreUsuarioServidor">Nombre de usuario</label>
                        </div>
                        <input type="text" name="txtNombreUsuarioServidor" class="form-control" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="txtPasswordServidor">Contraseña de servidor</label>
                        </div>
                        <input type="text" name="txtPasswordServidor" class="form-control" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="txtPuertoServidor">Puerto de servidor</label>
                        </div>
                        <input type="text" name="txtPuertoServidor" class="form-control" required value="8728">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="javascript:guardarServidorDhcp()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" role="dialog" id="modaldhcpservicio">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdalNombreChr"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <select name="" id="cboServicio">
                            <option disabled selected value> -- Seleccione una opcion -- </option>
                            <?php foreach ($servicios as $row) : ?>
                                <option value="<?= $row ?>">
                                    <?= $row ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="" id="txtSevicioSeleccionado" style="display: none;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="javascript:guardarRelaciondhpservicio()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php
$this->template->getFooter();
echo setClassById("menu_ipam", "active pcoded-trigger");
echo setClassById("submenu_ipam_server_dhcp", "active");
echo setDataTable("tableChr", "tChr", base_url("CIpam/JsongetServidoresdhcp"), ['var_mk_nombre', 'var_mk_direccion', 'buttons']);

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.1.0/select2.js" integrity="sha512-TTXWrG3HKH48LH0OeMNiZsftliSeRL6gvQNzSNpwxg66snPaAEhSgeV4Pl9U5/A2cv8dQ63zxr2J6yKOgBtg+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js
"></script>
<script>
    let $select_elem = $("#cboServicio");

    $select_elem.select2({
        dropdownParent: $('#modaldhcpservicio')
    });


    function guardarServidorDhcp() {
        $.LoadingOverlay("show", {
            image: "",
            text: "Espere un momento..."
        });
        $formservar = $(`#frmServidorDhcp`).serializeArray();
        $.ajax({
            url: "<?= base_url("CIpam/agregarServidorDhcp") ?>",
            method: "POST", //First change type to method here
            data: $formservar,
            error: function() {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
            }
        }).done(function(data) {
            let result = JSON.parse(data);
            $.LoadingOverlay("hide");
            if (result.result == "success") {
                <?= setAlert("Correcto", "success", false) ?>;
                $("#modalNuevoDhcp").modal("hide");
                $(`#frmServidorDhcp`).find("input[type=text]").val("");
                tableChr.ajax.reload();

            } else {
                <?= setAlert("Error en la conexion verifique sus datos", "error", false) ?>;
            }
        });
    }
</script>

<script>
    function verificardhcpservicio(data) {
        $("#txtSevicioSeleccionado").val(data.id);
        $("#mdalNombreChr").html(`DHCP ${data.nombre}`);
        $("#modaldhcpservicio").modal("show");

    }
</script>

<script>
    function customConfig() {
        let $select_elem = $("#cboServicio");
        // $select_elem.select2({});
    }
</script>
<?= onloadscript("customConfig") ?>

<script>
    function guardarRelaciondhpservicio() {
        var sevidordhcp = $("#txtSevicioSeleccionado").val();
        var servicio = $("#cboServicio").val();


        let data = {
            servidordhcp: sevidordhcp,
            serviciorel: servicio
        };
        if (servicio == null) {
            <?= setAlert("Seleccione un servicio", "error", false) ?>;
        } else {
            $.ajax({
                url: "<?= base_url("CIpam/agregarRelacionDhcp1") ?>",
                method: "POST", //First change type to method here
                data: data,
                error: function(jqxhr) {
                    <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                }
            }).done(function(data, textStatus, jqXHR) {
                //  console.log(data);
                if (data.status == true) {
                    <?= setAlert("Guardado exitoso", "success", false) ?>;
                    $("#modaldhcpservicio").modal("show");
                    $('#cboServicio').select2("val", $('#fieldId option:eq(0)').val());
                    tableChr.ajax.reload();



                } else {
                    <?= setAlert("Este servicio se encuentra relacionado con otro servidor DHCP.", "error", false) ?>;

                }
            });
        }
    }
</script>