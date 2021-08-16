<?= $head ?>
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>


<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Bienvenido.</h5>
                        <p class="m-b-0">Modulo: Tus clientes, aqui podras visualizar los clientes asignados a tu lista de clientes</p>
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
                                    <h5>Mis clientes</h5>
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
                                        <div class="col-md-5">
                                            <p>Busqueda inteligente: </p>
                                            <select name="" id="bInteligente" onchange="busquedaPorVendedor(this)">
                                                <option value="">Vendedor</option>
                                            </select>
                                        </div>
                                        <div class="col-md-7"></div>

                                    </div>

                                    <table class="table" id="tClientes" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Compañía</th>
                                                <td>Email</td>
                                                <td>IDVENDEDOR</td>
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
echo $footer;
echo setClassById("menu_comisiones", "active pcoded-trigger");
echo setClassById("submenu_vendedoresclientes", "active");
echo setDataTable("tableClientes", "tClientes", base_url("CVendedores/CComisiones/getClients"), array("nombrecompleto", "companyname", "email", "vendedor"));

?>
<script>
    tableClientes.columns(3).visible(false).draw();
</script>
<script>
    function busquedaPorVendedor(input) {
        if (input.value == 0) {
            tableClientes.columns(3).search("").draw();

        } else {
            tableClientes.columns(3).search(input.value).draw();
        }
    }
</script>
<script>
    function cambiarVendedor(vendedor, cliente) {
        var formData = new FormData();
        formData.append("vendedor", vendedor.value);
        formData.append("cliente", cliente);
        $.ajax({
            url: "<?= base_url("CVendedores/CComisiones/insertVendedoresCliente") ?>",
            method: "POST", //First change type to method here
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                <?= setAlert("Guardado correctamente!.", "success", false) ?>;
                tableClientes.ajax.reload();

            },
            error: function() {
                <?= setAlert("Ha ocurrido un error, cuando se intento cargar el selector de busqueda", "error", false) ?>;
            }

        });
    }
</script>


<!--FUNCION PARA RECUPERAR EL PROVEEDOR PREDETERMINAO-->
<script>
    function ActualizarSelectorbInteligente() {
        $.ajax({
            url: "<?= base_url("CVendedores/CComisiones/getVendedores") ?>",
            method: "POST", //First change type to method here
            data: {
                "query": true,
                "ven_activo": 1
            },
            success: function(response) {
                var result = JSON.parse(response);
                var htmlselect = `<option value="0" selected>Todos</option>`;
                for (var i = 0; i < result.data.length; i++) {

                    htmlselect += `
                    
                <option value="${result.data[i].ven_idvendedor}">${result.data[i].ven_nombrecompleto_config}</option>
                `;
                }
                $("#bInteligente").html(htmlselect);

            },
            error: function() {
                <?= setAlert("Ha ocurrido un error, cuando se intento cargar el selector de busqueda", "error", false) ?>;
            }

        });
    }
</script>

<?= loadscript("ActualizarSelectorbInteligente"); ?>

<script>
    function autoselect() {
        $("#bInteligente").val("<?= $datos['ven_idvendedor'] ?>");

        tableClientes.columns(3).search("<?= $datos['ven_idvendedor'] ?>").draw();
        $('#bInteligente').attr("disabled", true);
        $('#bInteligente').attr("style", "display:none");

    }
</script>

<?= onloadscript("autoselect"); ?>