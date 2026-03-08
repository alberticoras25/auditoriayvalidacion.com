<?php
    $url = $_SERVER["SCRIPT_NAME"];
    $parts = explode('/', $url);
    $file = $parts[count($parts) - 1];
    $valShowFooter = true;

    switch($file)
    {
        case 'index.php':
            $pageScript = '';

        break;
        default:
            $pageScript = '';
        break;
    }

    if($valShowFooter)
    {
?>
        <footer class="footer-area">
            <div class="footer-copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="footer-copyright-item">
                                <p>© Validación y Auditoría <?=date("Y");?> | Reservados todos los derechos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="go-top-area">
            <div class="go-top-wrap">
                <div class="go-top-btn-wrap">
                    <div class="go-top go-top-btn">
                        <i class="fa fa-angle-double-up"></i>
                        <i class="fa fa-angle-double-up"></i>
                    </div>
                </div>
            </div>
        </div>

<?php
    }
?>
    <script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/jquery.nice-select.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/circle-progress.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/ajax-contact.js"></script>
    <script src="assets/js/main.js?v=<?=uniqid();?>"></script>
    <?=$pageScript;?>
    <script type="text/javascript" src="portal/script/portal/globales.js?v=<?=uniqid();?>"></script>
   <!-- <script type="text/javascript" src="portal/script/sistema/moduloSitio.js?v=<?=uniqid();?>"></script>-->
    <?=$scriptLogin;?>