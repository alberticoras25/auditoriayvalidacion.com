<?php
    session_start();
    $url = $_SERVER["SCRIPT_NAME"];
    $parts = explode('/', $url);
    $file = $parts[count($parts) - 1];
    switch($file)
    {
        case 'index.php':
        break;
        default:
        break;
    }
?>

    <div id="loading">
        <div id="loading-center">
            <div id="loading-center-absolute">
                <div class="object" id="object_one"></div>
                <div class="object" id="object_two"></div>
                <div class="object" id="object_three"></div>
                <div class="object" id="object_four"></div>
            </div>
        </div>
    </div>
    <header class="header-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="navigation">
                        <nav class="navbar navbar-expand-lg">
                            <span class="navbar-brand">
                                <h6>GOBIERNO DE <br><span class="mx">M&Eacute;XICO</span></h6>
                                <!--<img src="portal/img/logo_w.png" alt="Logo">-->
                            </span>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarFive" aria-controls="navbarFive" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarFive">
                            </div>
                            <div class="navbar-btn d-none d-sm-inline-block"></div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>