<!DOCTYPE html>
<html lang="en">

<head>
    <title>Intranet - Blazar</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
    <meta name="author" content="Codedthemes" />
    <!-- Favicon icon -->

    <link rel="icon" href="<?= base_url() ?>recursos/assets/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>recursos/assets/css/bootstrap/css/bootstrap.min.css">
    <!-- waves.css -->
    <link rel="stylesheet" href="<?= base_url() ?>recursos/assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>recursos/assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>recursos/assets/icon/icofont/css/icofont.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>recursos/assets/icon/font-awesome/css/font-awesome.min.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>recursos/assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url("recursos/jquery-toast-plugin-master/demos/css/jquery.toast.css") ?>">

</head>

<body themebg-pattern="theme1">
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="preloader-wrapper">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->

    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->

                    <form class="md-float-material form-material">
                        <div class="text-center">
                            <img src="<?= base_url() ?>recursos/assets/images/logo.png" alt="logo.png">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center">Iniciar Sesión (Resellers)</h3>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="email" id="user" class="form-control">
                                    <span class="form-bar"></span>
                                    <label for="user" class="float-label">Correo Electronico</label>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" id="password" class="form-control">
                                    <span class="form-bar"></span>
                                    <label for="password" class="float-label">Contraseña</label>
                                </div>

                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <center>

                                            <div class="g-recaptcha" data-sitekey="6Ldw1iEbAAAAAEnsSz1O-Xw1taHLRf9SniGhBDUH"></div>
                                        </center>
                                    </div>
                                </div>

                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20" onclick="javascript:validarLogin()" id="btnIniciar">Iniciar sesión</button>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-10">
                                        <p class="text-inverse text-left m-b-0">Intranet<?= vesion_stash() ?></p>
                                        <?php
                                        $whmcs = json_decode($this->whmcs->funcion('WhmcsDetails', ["responsetype" => "json"]));

                                        ?>
                                        <p> <?= $whmcs->whmcs->canonicalversion; ?></p>

                                        <p class="text-inverse text-left"><a href="https://panel.blazar.mx"><b>Regresar al panel</b></a></p>
                                    </div>
                                    <div class="col-md-2">
                                        <img src="<?= base_url() ?>recursos/assets/images/auth/Logo-small-bottom.png" alt="small-logo.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end of form -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>
    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
    <!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="<?= base_url() ?>recursos/assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="<?= base_url() ?>recursos/assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="<?= base_url() ?>recursos/assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="<?= base_url() ?>recursos/assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="<?= base_url() ?>recursos/assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="<?= base_url() ?>recursos/assets/js/jquery/jquery.min.js "></script>
    <script type="text/javascript" src="<?= base_url() ?>recursos/assets/js/jquery-ui/jquery-ui.min.js "></script>
    <script type="text/javascript" src="<?= base_url() ?>recursos/assets/js/popper.js/popper.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>recursos/assets/js/bootstrap/js/bootstrap.min.js "></script>
    <!-- waves js -->
    <script src="<?= base_url() ?>recursos/assets/pages/waves/js/waves.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="<?= base_url() ?>recursos/assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>recursos/assets/js/common-pages.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js
"></script>



    <!--JQTOAST-->
    <script src="<?= base_url("recursos/jquery-toast-plugin-master/demos/js/jquery.toast.js") ?>"></script>

    <script>
        function validarLogin() {
            if ($("#user").val() != "" && $("#password").val() != "") {
                var token = $("#g-recaptcha-response").val();
                var formData = new FormData();
                formData.append("user", $("#user").val());
                formData.append("password", $("#password").val());
                formData.append("g-recaptcha-response", token);
                $.LoadingOverlay("show");
                $.ajax({

                    url: "<?= base_url("directory/services/external/login/resellers") ?>",
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var responseParse = JSON.parse(response);
                        $.LoadingOverlay("hide");
                        console.log(responseParse);
                        switch ($.trim(responseParse.result)) {
                            case "success":
                                $.toast({
                                    heading: 'Success',
                                    text: 'Espere un momento por favor.',
                                    showHideTransition: 'slide',
                                    icon: 'success'
                                });

                                $(window).attr("location", "<?= base_url("resellers/home/index") ?>");
                                break;
                            case "error":
                                grecaptcha.reset();
                                $.toast({
                                    heading: 'Error',
                                    text: 'Usuario o contraseña inválida, inténtelo nuevamente.',
                                    showHideTransition: 'fade',
                                    icon: 'error'
                                })
                                break;
                            case "norecaptcha":
                                $.toast({
                                    heading: 'Error',
                                    text: 'Resuelva la primero la recaptcha.',
                                    showHideTransition: 'fade',
                                    icon: 'error'
                                })
                                break;
                            case "spam":
                                $.toast({
                                    heading: 'Error',
                                    text: 'SPAM DETECTADO.',
                                    showHideTransition: 'fade',
                                    icon: 'error'
                                })
                                break;

                            case "without":
                                grecaptcha.reset();
                                $.toast({
                                    heading: 'Error',
                                    text: 'Sin autorización.',
                                    showHideTransition: 'fade',
                                    icon: 'error'
                                })
                                break;
                            default:
                                grecaptcha.reset();
                                $.toast({
                                    heading: 'Error',
                                    text: 'Ha ocurrio un error, inténtelo mas tarde.',
                                    showHideTransition: 'fade',
                                    icon: 'error'
                                })
                                break;
                        }


                    }
                });
            } else {
                $.toast({
                    heading: 'Error',
                    text: 'Valide los campos.',
                    showHideTransition: 'fade',
                    icon: 'error'
                })
            }
        }
    </script>
    <script>
        var user = document.getElementById("user");
        // Execute a function when the user releases a key on the keyboard
        user.addEventListener("keyup", function(event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                document.getElementById("btnIniciar").click();
            }
        });


        // Get the input field
        var input = document.getElementById("password");

        // Execute a function when the user releases a key on the keyboard
        input.addEventListener("keyup", function(event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                document.getElementById("btnIniciar").click();
            }
        });
    </script>

</body>

</html>

<?php
if ($this->session->userdata('reseller')) {
    $this->session->unset_userdata('reseller');
}
?>

<script src='https://www.google.com/recaptcha/api.js' async defer></script>