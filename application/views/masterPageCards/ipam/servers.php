<?php
$this->template->getHeader();
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
        display: none;
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
                        <p class="m-b-0">IPAM - SERVERS</p>
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
                                    <h5>Servidores OVH</h5>
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
                                        <div class="col-md-12 mb-4">
                                            <input id="btnConexion" type="button" value="Nueva conexion" class="btn btn-success" onclick="javascript:$('#nuevaConexion').modal('show')">
                                        </div>

                                        <div id="nuevaConexion" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form id="fNuevaConexion">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="varNombre">Nombre de la conexion</label>
                                                                <input id="varNombre" class="form-control" type="text" name="varNombre">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="varApplicationKey">Application Key</label>
                                                                <input id="varApplicationKey" class="form-control" type="text" name="varApplicationKey">
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label for="varApplicationSecret">Application Secret</label>
                                                                        <input id="varApplicationSecret" class="form-control" type="text" name="varApplicationSecret">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label for="varConsumerKey">Consumer Key</label>
                                                                        <input id="varConsumerKey" class="form-control" type="text" name="varConsumerKey">
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label for="varEndPoint">End Point</label>
                                                                        <input id="varEndPoint" class="form-control" type="text" name="varEndPoint">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Guardar</button>
                                                            <button type="button" data-dismiss="modal" class="btn btn-light">Cerrar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="cboCredenciales">Credenciales</label>
                                                <input type="hidden" name="iCredencial" id="iCredencial" value="0">
                                                <select name="cboCredenciales" id="cboCredenciales" class="form-control" onchange="seleccionarCredencial()">
                                                    <option>Seleccionar credenciales</option>
                                                    <?php foreach ($credenciales as $row) : ?>
                                                        <option value="<?= $row['iIdCredencial'] ?>">
                                                            <?= $row['vNombre'] ?>
                                                        </option>
                                                    <?php endforeach; ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">

                                        <label for="">Seleccione un servidor (Dedicados).</label>
                                        <div class="row">
                                            <div class="col-md-8"> <select name="" id="cboServicio" onchange="javascript:seleccionServicio()" class="form-control">
                                                    <option disabled selected value> -- Seleccione una opcion -- </option>

                                                </select></div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-mini btn-primary form-control" disabled id="btnSolicitarIpAdicional">Solicitar direcciones adicionales</button>
                                                    </div>
                                                    <div class="col-12 mt-4">
                                                        <div class="form-group" id="divServidoresDHCP">
                                                            <label for="cmboServidoresDHCP">Servidores DHCP</label>
                                                            <select id="cmboServidoresDHCP" class="form-control" name="cmboServidoresDHCP">
                                                                <option>Seleccionar</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">

                                                <p name="" type="text" name="" id="txtServicio" readonly class="form-control"></p>
                                            </div>
                                            <div class="col-md-12" id="htmlContent">

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

    <?php
    $this->template->getFooter();
    echo setClassById("menu_ipam", "active pcoded-trigger");
    echo setClassById("submenu_ipam_server", "active"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/2.1.0/select2.min.js" integrity="sha512-zHvORqLMgzpHOFmVsebm//FNQz5TWtB/mHqlLyAGjiLdrtMw/ULj3jV4xqRjy4h03cmKcQm4DqOvYE2aCGdNaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js
"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js
"></script>


    <!--
    <script>
        function seleccionServicio() {
            let servicio = $(`#cboServicio`).val();
            $("#btnSolicitarIpAdicional").prop("disabled", true);


            // Text
            $.LoadingOverlay("show", {
                image: "",
                text: "Espere un momento..."
            });
            $.ajax({
                url: "<? // base_url("CIpam/JsonDedicateServerNameIps") 
                        ?>",
                method: "POST", //First change type to method here

                data: {
                    serviceName: servicio
                },
                success: function(response) {


                },
                error: function() {
                    <? // setAlert("Ha ocurrido un error", "error", false) 
                    ?>;
                    $.LoadingOverlay("hide");
                }

            }).done(function(data) {
                let result = JSON.parse(data);
                $("#txtServicio").html(`Servidor: ${result.servidor.name} \n IP Principal: ${result.servidor.ip} \n Tipo de producto: ${result.servidor.commercialRange}`);
                console.log(result.direcciones.length);
                var $templateMessage = ``;
                for (var i = 0; i < result.direcciones.length; i++) {

                    var $trtable = ``;
                    for (var x = 0; x < result.direcciones[i].ips.length; x++) {
                        var macaddress = `<input type='submit' value='Solicitar Mac' class='btn btn-danger' onclick=javascript:getVirtualMac('${result.direcciones[i].ips[x].ip_subnet}')>`;
                        if (typeof result.direcciones[i].ips[x].mac_address !== 'undefined') {
                            macaddress = result.direcciones[i].ips[x].mac_address;
                        }
                        $trtable = $trtable + `<tr>
            <td>${result.direcciones[i].ips[x].ip_subnet}</td>
            <td>${macaddress}</td>
            <td></td>
            <td></td>
            </tr>`;

                    }
                    $templateMessage = $templateMessage + `   <button type="button" class="collapsibled">${result.direcciones[i].ip}</button>
            <div class="content">
            <table class="table table-striped">
            <thead>
            <tr>
            <th>IP</th>
            <th>MAC ADDRESS</th>
            <th></th>
            <th></th>
            </tr>
            </thead>
            <tbody>
            ${$trtable}
            </tbody>
            </table>
            </div>`;
                }
                if (result.direcciones.length == 0) {
                    $(`#htmlContent`).html(`<p>Este servicio no cuenta con direcciones adicionales relacionadas.</p>`);

                } else {
                    $(`#htmlContent`).html($templateMessage);

                }
                actulizarColapsable();
                $.LoadingOverlay("text", "Procesando la informacion...");
                setTimeout(function() {
                    $.LoadingOverlay("hide");
                    $("#btnSolicitarIpAdicional").prop("disabled", false);
                }, 3000);


            });
        }
    </script>
    -->

    <div class="modal" tabindex="-1" role="dialog" id="modalLicencia">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva licencia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="mnumerolicencia">Nombre de conexion</label>
                        </div>
                        <input type="text" name="" id="mnumerolicencia" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="ntipolicencia"></label>
                        </div>
                        <select name="" id="ntipolicencia" class="form-control">
                            <?php foreach ($tipolicencia as $rows) : ?>

                                <option value="<?= $rows->idlicencia ?>"><?= $rows->nombrelicencia ?></option>

                            <?php endforeach; ?>


                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="nestatus">Estatus de licencia</label>
                        </div>
                        <select name="" id="nestatus" class="form-control" onchange="javascript:validardiv()">
                            <?php foreach ($estatuslicencia as $rows) : ?>

                                <option value="<?= $rows['value'] ?>"><?= $rows['nombre'] ?></option>

                            <?php endforeach; ?>


                        </select>
                    </div>

                    <div class="input-group mb-3" id='div'>
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="fchacompra">Fecha de compra</label>
                        </div>
                        <input name="" id="fchacompra" class="form-control" type="date">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="ccostocompra">Costo de compra</label>
                        </div>
                        <input type="text" name="" id="ccostocompra" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="ccodigocal">Codigo CAL</label>
                        </div>
                        <input type="text" name="" id="codigocals" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="ccostocompra">Cantidad CAL</label>
                        </div>
                        <input type="text" name="" id="cantidadcals" class="form-control">
                    </div>
                    <div class="input-group mb-3" id='divfventa'>
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="fchaventa">Fecha de venta</label>

                        </div>
                        <input name="" id="fchaventa" class="form-control" type="date">
                    </div>
                    <div class="input-group mb-3" id='divcventa'>
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="ccostoventa">Costo de venta</label>
                        </div>
                        <input type="text" name="" id="ccostoventa" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="javascript:guardarLicencia()">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        $("#divServidoresDHCP").hide();

        function customConfig() {
            let $select_elem = $("#cboServicio");
            let $select_elem2 = $("#cboCredenciales");
            $select_elem.select2({});
            $select_elem2.select2({});
        }
    </script>
    <?= onloadscript("customConfig") ?>

    <script>
        function actulizarColapsable() {
            var coll = document.getElementsByClassName("collapsibled");
            var i;

            for (i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function() {
                    this.classList.toggle("actives");
                    var content = this.nextElementSibling;
                    if (content.style.display === "block") {
                        content.style.display = "none";
                    } else {
                        content.style.display = "block";
                    }
                });
            }
        }
    </script>

    <script>
        $("#btnSolicitarIpAdicional").click(function() {
            let servicio = $(`#cboServicio`).val();
            $.ajax({
                url: "<?= base_url("CIpam/solicitarOrdenIP") ?>",
                method: "POST", //First change type to method here

                data: {
                    serviceName: servicio
                },
                success: function(response) {


                },
                error: function() {
                    <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                    $.LoadingOverlay("hide");
                }

            }).done(function(data) {
                console.log(data);
            });

        });
    </script>

    <script>
        function getVirtualMac(ip) {
            let servicio = $(`#cboServicio`).val();

            $.LoadingOverlay("show", {
                image: "",
                text: "Espere un momento..."
            });
            $.ajax({
                url: "<?= base_url("CIpam/addVirtualMAc") ?>",
                method: "POST", //First change type to method here

                data: {
                    serviceName: servicio,
                    ipAddress: ip,
                    indexCredencial: $("#iCredencial").val()
                },
                error: function(jqXHR) {
                    console.log(jqXHR.responseJSON);
                    <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                    $.LoadingOverlay("hide");
                }

            }).done(function(data) {
                $.LoadingOverlay("text", "Procesando la informacion...");
                setTimeout(function() {
                    $.LoadingOverlay("hide");
                }, 10000);
                <?= setAlert("Finalizado", "success", false) ?>;
                seleccionServicio();

            });

        }
    </script>

    <script>
        function seleccionarCredencial() {
            let valCredencial = $("#cboCredenciales").val();
            $("#iCredencial").val(valCredencial);
            let servicio = $("#cboServicio");
            $.ajax({
                type: "POST",
                url: "<?= base_url('CIpam/changeCredenciales') ?>",
                data: {
                    credencial: valCredencial
                },
                dataType: "json",
                beforeSend: function() {
                    $.LoadingOverlay("show", {
                        image: "",
                        text: "Espere un momento..."
                    });
                    $("#cboServicio").prop('disabled', true);
                },
                success: function(response) {
                    $.LoadingOverlay("hide");
                    $("#cboServicio").prop('disabled', false);
                    $("#cboServicio").find('option').remove();
                    $(response).each(function(i, v) {
                        servicio.append(`<option value="${v}">${v}</option>`);
                    });

                },
                error: function(jqXHR) {
                    $.LoadingOverlay("hide");
                    servicio.prop('disabled', true);
                    alert('ERROR:FAILED');
                }
            });
        }

        function seleccionServicio() {

            let servicio = $(`#cboServicio`).val();
            $("#btnSolicitarIpAdicional").prop("disabled", true);
            $.LoadingOverlay("show", {
                image: "",
                text: "Espere un momento..."
            });
            var formData = new FormData();
            formData.append('serviceName', servicio);
            formData.append('indexCredencial', $("#iCredencial").val());
            var xhr = new XMLHttpRequest();
            // Setup our listener to process completed requests 
            xhr.onload = function() {
                // Process our return data 
                if (xhr.status >= 200 && xhr.status < 300) {
                    let result = JSON.parse(xhr.response);
                    $("#txtServicio").html(`Servidor: ${result.servidor.name} \n IP Principal: ${result.servidor.ip} \n Tipo de producto: ${result.servidor.commercialRange}`);
                    console.log(result.direcciones.length);
                    var $templateMessage = ``;
                    for (var i = 0; i < result.direcciones.length; i++) {

                        var $trtable = ``;
                        for (var x = 0; x < result.direcciones[i].ips.length; x++) {
                            var macaddress = `<input type='submit' value='Solicitar Mac' class='btn btn-danger' onclick=javascript:getVirtualMac('${result.direcciones[i].ips[x].ip_subnet}')>`;
                            if (typeof result.direcciones[i].ips[x].mac_address !== 'undefined') {
                                macaddress = result.direcciones[i].ips[x].mac_address;
                            }
                            $trtable = $trtable + `
          
                            <tr>
            <td>${result.direcciones[i].ips[x].ip_subnet}</td>
            <td>${macaddress}</td>
            <td></td>
            <td></td>
            </tr>`;

                        }
                        $templateMessage = $templateMessage + `   <button type="button" class="collapsibled">${result.direcciones[i].ip}</button>
            <div class="content">
            <table class="table table-striped">
            <thead>
            <tr>
            <th>IP</th>
            <th>MAC ADDRESS</th>
            <th><input type="submit" class="btn btn-primary" onclick="javascript:sincronizarSegmento('${result.direcciones[i].ip}')" value="Sincronizar"></th>
            <th></th>
            </tr>
            </thead>
            <tbody>
            
            ${$trtable}
            </tbody>
            </table>
            </div>`;
                    }
                    if (result.direcciones.length == 0) {
                        $(`#htmlContent`).html(`<p>Este servicio no cuenta con direcciones adicionales relacionadas.</p>`);

                    } else {
                        $(`#htmlContent`).html($templateMessage);

                    }
                    actulizarColapsable();
                    mostrarServidoresDHCP();
                    $.LoadingOverlay("text", "Procesando la informacion...");
                    setTimeout(function() {
                        $.LoadingOverlay("hide");
                        $("#btnSolicitarIpAdicional").prop("disabled", false);
                    }, 3000);
                } else {
                    $("#divServidoresDHCP").hide();
                    <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                    $.LoadingOverlay("hide");
                    console.log('Request Failed');
                }
            };
            xhr.open('POST', "<?= base_url("CIpam/JsonDedicateServerNameIps") ?>");
            xhr.send(formData);




        }

        function mostrarServidoresDHCP() {

            let servidores = $("#cmboServidoresDHCP");
            $("#divServidoresDHCP").hide();
            $.ajax({
                type: "POST",
                url: "<?= base_url('CIpam/agregarRelacionDhcp') ?>",
                dataType: "json",
                data: {
                    servername: $("#cboServicio").val()
                },
                beforeSend: function() {
                    $("#divServidoresDHCP").hide();

                },
                success: function(response) {

                    servidores.find('option').remove();
                    servidores.append('<option value="0">Seleccione una opcion</option>');

                    if (response['myDHCP'] == false) {
                        $(response['servidores']).each(function(i, v) {
                            servidores.append(`<option value="${v.int_mk_id_conexion}">${v.var_mk_nombre}</option>`);
                        });
                    } else {
                        $(response['servidores']).each(function(i, v) {
                            if (v.int_mk_id_conexion == response['myDHCP']) {
                                servidores.append(`<option value="${v.int_mk_id_conexion}" selected>${v.var_mk_nombre}</option>`);
                            } else {
                                servidores.append(`<option value="${v.int_mk_id_conexion}">${v.var_mk_nombre}</option>`);
                            }
                        });
                    }

                    $("#divServidoresDHCP").show();
                    $.LoadingOverlay("hide");

                },
                error: function(jqXHR) {
                    $("#divServidoresDHCP").hide();
                    $.LoadingOverlay("hide");
                }
            });

        }

        $("#cmboServidoresDHCP").change(function(e) {
            e.preventDefault();
            let servicio = $(`#cboServicio`).val();
            $.ajax({
                type: "POST",
                url: "<?= base_url('CIpam/insertarRelacionDHCP') ?>",
                data: {
                    serviceName: servicio,
                    dhcpIndex: $(this).val()
                },
                dataType: "json",
                beforeSend: function() {
                    $(`#cboServicio`).prop('disabled', true);
                },
                success: function(response) {
                    $(`#cboServicio`).prop('disabled', false);
                    <?= setAlert('Servidor DHCP asignado', 'success') ?>
                },
                error: function(jqXHR) {
                    $(`#cboServicio`).prop('disabled', false);
                    <?= setAlert('Error al asignar servidor DHCP', 'error') ?>
                    console.log(jqXHR.responseJSON);
                }
            });
        });

        $("#fNuevaConexion").submit(function(e) {
            e.preventDefault();
            $.LoadingOverlay("show", {
                image: "",
                text: "Espere un momento..."
            });
            $.ajax({
                type: "POST",
                url: "<?= base_url('CIpam/nuevaConexionServidoresDedicados') ?>",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    $("#nuevaConexion").modal('hide');
                    $("#fNuevaConexion")[0].reset();
                    $.LoadingOverlay("hide");
                    <?= setAlert('Finalizado', "success") ?>
                    location.reload(true);
                },
                error: function(jqXHR) {
                    $.LoadingOverlay("hide");
                    if (jqXHR.status == 400) {
                        <?= setAlert('Complete los campos', "error") ?>
                    }
                    if (jqXHR.status == 500) {
                        <?= setAlert('Algo salio mal al procesar su solicitud', "error") ?>
                    }
                }
            });
        });
    </script>

    <script>
        function sincronizarSegmento(ipsegment) {
            var $idchr = $("#cmboServidoresDHCP").val();
            if ($idchr != 0) {
                let servicio = $(`#cboServicio`).val();

                $("#btnSolicitarIpAdicional").prop("disabled", true);
                $.LoadingOverlay("show", {
                    image: "",
                    text: "Espere un momento..."
                });
                var formData = new FormData();
                formData.append('segmento', ipsegment);
                formData.append('idchr', $idchr);

                formData.append('serviceName', servicio);

                formData.append('indexCredencial', $("#iCredencial").val());
                var xhr = new XMLHttpRequest();
                // Setup our listener to process completed requests 
                xhr.onload = function() {
                    // Process our return data 
                    if (xhr.status >= 200 && xhr.status < 300) {
                        $.LoadingOverlay("text", "Procesando la informacion...");
                        setTimeout(function() {
                            $.LoadingOverlay("hide");
                            $("#btnSolicitarIpAdicional").prop("disabled", false);
                        }, 3000);
                    } else {
                        $("#divServidoresDHCP").hide();
                        <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                        $.LoadingOverlay("hide");
                        console.log('Request Failed');
                    }
                };
                xhr.open('POST', "<?= base_url("CIpam/JsonDedicateServerNameIpsSegment") ?>");
                xhr.send(formData);
            } else {
                <?= setAlert("Este servicio no cuenta con servidor DHCP", "error") ?>;

            }

        }
    </script>