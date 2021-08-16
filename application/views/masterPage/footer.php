<div id="styleSelector"></div>
</div>
</div>
</div>
</div>
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
<script src="<?= base_url() ?>recursos/assets/js/pcoded.min.js"></script>
<script src="<?= base_url() ?>recursos/assets/js/vertical/vertical-layout.min.js"></script>
<script src="<?= base_url() ?>recursos/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- Custom js -->
<script type="text/javascript" src="<?= base_url() ?>recursos/assets/js/script.min.js"></script>

<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js "></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>recursos/assets/js/bootstrap-growl.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!--OCULTA EL TEMPLATE PREMIUM-->
<script>
    $(document).ready(function() {
        document.getElementsByClassName('fixed-button active')[0].style.visibility = 'hidden';
    });
</script>
</body>

</html>