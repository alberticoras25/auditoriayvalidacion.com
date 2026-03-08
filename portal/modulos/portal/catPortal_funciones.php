<?php

    function catPortal_menuInicio()
    {
        $liPortal = $divPortal = '';
        $valSelected = false;

        switch($_SESSION["mod"])
        {
            case "11610":
                switch($_SESSION["mod"])
                {
                    case "11610":
                        $ini = 11601;
                        $fin = 11601;
                    break;
                }

                for($i = $ini; $i <= $fin; $i++)
                {
                    liberar_bd();
                    $selectPermisosModulos = 'CALL sp_sistema_select_permiso_modulo('.$_SESSION['idPerfil'].', '.$i.');';
                    $permisosModulos = consulta($selectPermisosModulos);
                    $ctaPerMod = cuenta_registros($permisosModulos);
                    if($ctaPerMod != 0)
                    {
                        $perMod = siguiente_registro($permisosModulos);

                        if($valSelected == true)
                        {
                            $classLink = ' ';
                            $divClass = ' ';
                        }
                        else
                        {
                            $classLink = ' active ';
                            $divClass = ' show active ';
                        }

                        switch($i)
                        {
                            case 11601:
                                $divCarga = 'divDoc';
                                $valSelected = true;
                            break;
                        }

                        $liPortal.= '   <li class="nav-item">
                                            <a onclick="formCatalogo(\''.$divCarga.'\', '.$i.', \'catalogo\', 0)" class="nav-link '.$classLink.'" id="'.$divCarga.'-tab" data-toggle="tab" href="#'.$divCarga.'" role="tab" aria-controls="'.$divCarga.'" aria-selected="true">'.utf8_convert($perMod["nomMod"]).'</a>
                                        </li>';

                        $divPortal.= '<div class="tab-pane '.$divCarga.$divClass.' tabPortal" id="'.$divCarga.'" role="tabpanel" aria-labelledby="'.$divCarga.'-tab"></div>';
                    }
                }
            break;
        }

        $liVendedor = '';
        if(isset($_SESSION['idVendedorActual']) && $_SESSION['idVendedorActual'] != 0)
            $liVendedor = '<b>Vendedor:</b> '.$_SESSION['nomVendedorActual'];

        $pagina = ' <div class="row divHead" id="divHead">
                        <div class="col-12">
                            <h1 class="text-one">'.$liVendedor.'</h1>
                            <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                                <ol class="breadcrumb pt-0">
                                    <li class="breadcrumb-item">
                                        <a href="javascript:;" onclick="navegar_modulo(0);">INICIO</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">'.$_SESSION["moduloPadreActual"].'</li>
                                </ol>
                            </nav>
                            <div class="separator mb-5"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <h5 class="mb-2 font-weight-bold">Cat&aacute;logos</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <ul class="nav nav-tabs divNavCatPor separator-tabs ml-0 mb-5" role="tablist">
                                                    '.$liPortal.'
                                                </ul>
                                                <div class="tab-content">
                                                    '.$divPortal.'
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';

        return $pagina;
    }