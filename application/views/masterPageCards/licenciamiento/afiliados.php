<?php
$this->template->getHeader();
?>
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
                        <h5 class="m-b-10">Afiliados.</h5>
                        <p class="m-b-0">En este apartado puedes configurar los afiliados los cuales podran autoaceptar pedidos.</p>
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
                                    <h5>Afiliados</h5>
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
                                    <table class="table" id="tAfiliados">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Compañía</th>
                                                <th>Grupo</th>
                                                <th>Afiliado</th>

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
$this->template->getFooter();
echo setClassById("menu_licencia", "active pcoded-trigger");
echo setClassById("submenu_afiliados", "active");
echo setDataTable("tableTipoLicencia", "tAfiliados", base_url("CClientes/getClients"), array("nombrecompleto", "companyname", "tipogrupo", "button"));
?>

<script>
    function verificar(id) {
        var type = "agregar";

        if ($(`#checkinput${id}`).is(':checked')) {
            var type = "borrar";
        }
        console.log(type);

        $.ajax({
            url: "<?= base_url("CClientes/setStatusAfiliado") ?>",
            type: "post",
            data: {
                "id": id,
                "status": type
            },
            success: function(response) {
                <?= setAlert("Se ha guardado correctamente", "success", false) ?>;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                <?= setAlert("Ha ocurrido un error", "error", false) ?>;
                // console.log(textStatus, errorThrown);
            }
        });




    }
</script>