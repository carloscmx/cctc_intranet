<?php
echo $template['head'];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/2.1.0/select2.css" integrity="sha512-CeTclULLWLJj+H3XVCR+ZLGX2qK0f9SoPyjspqIg4s7ZnD5mWZ5oaTcuHr3lOXWk/FIUXD2JsvEj/ITqq8TAHQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .collapsibled {
        background-color: #f4f4f4;
        color: black;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
    }

    .actives,
    .collapsibled:hover {
        /* background-color: #448aff; */

    }

    .content {
        padding: 0 18px;
        /* display: none; */
        overflow: hidden;
        background-color: #fff;
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
                                    <h5>Datos de facturacion</h5>
                                    <span>Solicitar factura además de tener efectos fiscales, también tiene otros beneficios, como son: comprobar algún gasto como parte del presupuesto o como soporte documental de la contabilidad, por lo que solicitar factura no solo es un derecho de los contribuyentes, sino una obligación de todos aquellos que deseen poner su granito de arena al desarrollo de nuestro país.
                                    </span>
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
                                            <input type="submit" value="Nueva razon social" class="btn btn-success" onclick="javascript:$('#modalfacturacion').modal('show')">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <br><br>
                                        <div class="col-md-12">


                                            <div class="content">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>RAZON SOCIAL</th>
                                                            <th>RFC</th>
                                                            <th>TIPO DE GASTO</th>
                                                            <th>USO CFDI</th>
                                                            <th>OPCIONES</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyRazones">

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
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalfacturacion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva razon social</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="frmdatofacturacion">
                    <label for="">Razon Social</label>
                    <input type="text" name="txtrazonsocial" class="form-control" placeholder="Ejemplo: Blazar Networks, SA de CV" required>
                    <br>
                    <label for="">RFC</label>
                    <input type="text" name="txtrfc" id="txtrfc" class="form-control" placeholder="Ejemplo: XAXX010101000" required minlength="12">
                    <br>
                    <label for="">Metodo de pago </label>
                    <select name="cbometodogasto" class="form-control">
                        <?php foreach ($metodopago as $metodo) : ?>
                            <option value="<?= $metodo->id_fac_cat ?>"><?= $metodo->fac_metodo_nombre ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <label for="">Tipo de gasto</label>
                    <select name="cbotipogasto" class="form-control">
                        <?php foreach ($usocfdi as $cfdi) : ?>
                            <option value="<?= $cfdi->int_cfdi ?>"><?= $cfdi->fac_cfdi_nombre ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnnuevarazon">Guardar</button>
                <button type=" button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php
echo $template['footer'];


echo setClassById("menu_facturacion", "active pcoded-trigger");
echo setClassById("submenu_facturacion_datos", "active");
?>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/localization/messages_es.min.js" integrity="sha512-Ou4GV0BYVfilQlKiSHUNrsoL1nznkcZ0ljccGeWYSaK2CaVzof2XaZ5VEm5/yE/2hkzjxZngQHVwNUiIRE8yLw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>
    $('#txtrfc').mask("AAAAAAAAAAAAA");

    $('#txtrfc').keyup(function() {
        var valor = $(this).val();
        $(this).val(valor.toUpperCase());
    });
</script>
<script>
    $(document).ready(function() {
        $("#frmdatofacturacion").validate();

        $("#btnnuevarazon").click(function() {
            if ($("#frmdatofacturacion").valid()) {
                $.ajax({
                    url: "<?= base_url("Resellers/CDatosfacturacion/registrarDatoFacturacion") ?>",
                    method: "POST", //First change type to method here
                    data: $("#frmdatofacturacion").serialize(),
                    error: function() {
                        <?= setAlert("Error intentelo nuevamente", "error") ?>;
                    }

                }).done(function(response) {
                    $('#frmdatofacturacion').trigger("reset");
                    <?= setAlert("Guardado correctamente", "success") ?>;
                    $("#modalfacturacion").modal("hide");
                    mostrarRazonesSociales();


                });


            } else {
                <?= setAlert("Llene todos los datos correctamente", "error") ?>;

            }
        });
    });
</script>

<script>
    function mostrarRazonesSociales() {
        $.ajax({
            url: "<?= base_url("Resellers/CDatosfacturacion/obtenerRazoneSociales") ?>",
            method: "POST", //First change type to method here
            error: function() {
                <?= setAlert("Error intentelo nuevamente", "error") ?>;
            }

        }).done(function(response) {
            var result = JSON.parse(response);
            var html = ``;
            for (var i = 0; i < result.length; i++) {
                $button = `<input type='submit' value='Eliminar' onclick="ConfirmareliminarRegistro({'id':'${result[i].id_relacion}'})" class='btn btn-danger'>`;
                html = html + `
            <tr>
            <td>${result[i].razonsocial}</td>
            <td>${result[i].rfc}</td>
            <td>${result[i].usocfdiinfo.fac_cfdi_nombre} (${result[i].usocfdiinfo.fac_cfdi_codigo})</td>
            <td>${result[i].metodopagoinfo.fac_metodo_nombre} (${result[i].metodopagoinfo.fac_metodo_codigo})</td>
            <td>${$button}</td>
            </tr>`;
            }
            $("#tbodyRazones").html(html);
        });
    }
</script>

<?= setDelete("ConfirmareliminarRegistro", base_url("Resellers/CDatosfacturacion/eliminarRazonSocial"), "mostrarRazonesSociales()") ?>

<?= onloadscript("mostrarRazonesSociales") ?>