<?php
    session_start();
    error_reporting(E_ERROR);
    include_once("../portal/motor/globales.php");
    include_once("../portal/motor/control.php");

    $titleMsj = 'P&aacute;gina no encontrada !';
    $bodyMsj = 'Lo sentimos, pero la p&aacute;gina que estabas buscando no se pudo encontrar.';
    $subtitleMsj = 'Contact&eacute; al administrador del sistema si no puede encontrar lo que est&aacute; buscando.';
    $btnReturn = $falseBody = false;

    $body='  <!DOCTYPE html>
                <html>
                    <head>
                        <meta charset="utf-8">
                        <title>.::LiteM&eacute;xico::.</title>
                        <meta name="keywords" content="" />
                        <meta name="description" content="">
                        <meta name="author" content="">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800">
                        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300">
                        <link rel="stylesheet" type="text/css" href="../portal/assets/skin/default_skin/css/theme.css?v='.uniqid().'">
                        <link rel="stylesheet" type="text/css" href="../portal/assets/admin-tools/admin-forms/css/admin-forms.css?v='.uniqid().'">
                        <link rel="stylesheet" type="text/css" href="../portal/assets/fonts/icomoon/icomoon.css?v='.uniqid().'">
                        <link rel="shortcut icon" href="../portal/imagenes/empresa/icono.png">
                        <link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
                        <script src="../portal/vendor/jquery/jquery-1.11.1.min.js?v='.uniqid().'"></script>
                        <script src="../portal/vendor/jquery/jquery_ui/jquery-ui.min.js?v='.uniqid().'"></script>
                        <script src="../portal/assets/js/bootstrap/bootstrap.min.js?v='.uniqid().'"></script>
                        <link href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.css" media="all" rel="stylesheet" type="text/css" />
                        <link href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.brighttheme.css" media="all" rel="stylesheet" type="text/css" />
                        <link href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.buttons.css" media="all" rel="stylesheet" type="text/css" />
                    </head>
                    <body class="external-page error-page alt sb-r-c onload-check sb-l-m">
                        <div id="main">
                            <div class="overlay"><div id="loading-img"></div></div>
                            <header class="navbar navbar-fixed-top bg-system">
                                <div class="navbar-branding">
                                    <a class="navbar-brand" href="javascript:;"> <b>Multipagos</b></a>
                                </div>
                            </header>
                            <section id="content_wrapper" class="mln">
                                <section id="content" class="pn">
                                    <div class="center-block mt50 mw800">
                                        <div class="error-block container">
                                            <h1 class="display-4 mb-4">'.$titleMsj.'</h1>
                                            <h3 class="mb-5">'.$bodyMsj.'</h3>
                                            <p class="lead">'.$subtitleMsj.'</p>
                                        </div>
                                    </div>
                                </section>
                            </section>
                        </div>
                        <script src="../portal/vendor/ajax/libs/globalize/globalize.min.js?v='.uniqid().'"></script>
                        <!--<script src="../portal/vendor/ajax/libs/moment/moment.js?v='.uniqid().'"></script>-->
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/locale/es.js"></script>
                        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
                        <script src="../portal/script/portal/globales.js?v='.uniqid().'"></script>
                        <script src="../portal/script/portal/md5.js?v='.uniqid().'"></script>
                        <script src="../portal/script/portal/sistema.js?v='.uniqid().'"></script>
                        <script src="../portal/script/portal/jquery.numeric.js"></script>
                        <script src="../portal/script/portal/sessionTimeout.js?v='.uniqid().'"></script>
                        <script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
                        <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
                        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
                        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
                        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
                        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js"></script>
                        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.confirm.js"></script>
                        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.buttons.js"></script>
                        <script type="text/javascript">
                        $(document).ready(function()
                        {
                            if (typeof history.pushState === "function")
                            {
                                history.pushState("jibberish", null, null);
                                window.onpopstate = function () {
                                    history.pushState("newjibberish", null, null);
                                    // Handle the back (or forward) buttons here
                                    // Will NOT handle refresh, use onbeforeunload for this.
                                };
                            }
                            else
                            {
                                var ignoreHashChange = true;
                                window.onhashchange = function ()
                                {
                                    if (!ignoreHashChange) {
                                        ignoreHashChange = true;
                                        window.location.hash = Math.random();
                                        // Detect and redirect change here
                                        // Works in older FF and IE9
                                        // * it does mess with your hash symbol (anchor?) pound sign
                                        // delimiter on the end of the URL
                                    }
                                    else
                                    {
                                        ignoreHashChange = false;
                                    }
                                };
                            }
                        });
                        </script>
                        '.scripttag('../portal/assets/js/pages/login/EasePack.min.js').
                        scripttag('../portal/assets/js/pages/login/rAF.js').
                        scripttag('../portal/assets/js/pages/login/TweenLite.min.js').
                        scripttag('../portal/assets/js/pages/login/login.js').
                        scripttag("../portal/assets/plugins/form-select2/select2.min.js").
                        scripttag('../portal/assets/js/utility/utility.js').
                        scripttag('../portal/assets/js/main.js').
                        scripttag('../portal/assets/js/demo.js').
                        scripttag("../portal/script/portal/gralLogin.js").'
                    </body>
                </html>';

    echo $body;
