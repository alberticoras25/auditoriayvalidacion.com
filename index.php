<?php
    $url = $_SERVER["SCRIPT_NAME"];
    $server = $_SERVER['SERVER_NAME'];
    $parts = explode('/', $url);
    $file = $parts[count($parts) - 1];
    $directory = 'view/pages/';
    $pageStyle = '';
    if($server == "localhost")
        $txtBase = '/proyectos/valaudita/';
    else
        $txtBase = 'https://validacionyauditoria.com/';

    session_start();
    date_default_timezone_set('America/Mexico_City') ;
    include("portal/motor/conexionSitio.php");
    include("portal/motor/globales.php");
    conectarSistema();
    error_reporting(E_ERROR);
    if(isset($_GET["folio"]) && $_GET["folio"] != "")
    {
        //DATOS DEL DOCUMENTO
        $folio = utf8_desconvert(strtolower($_GET["folio"]));
        liberar_bd();
        $selectDocumento = 'CALL sp_sistema_select_datos_catalogo_documento_folio("'.$folio.'");';
        $documento = consulta($selectDocumento);
        $ctaDocumento = cuenta_registros($documento);
        if($ctaDocumento != 0)
        {
            $doc = siguiente_registro($documento);
            if($doc["estatus"] == 1)
            {
                $_SESSION["idDocAct"] = $doc["idDoc"];
?>
                <!doctype html>
                <html lang="en">
                    <? include 'view/head.php';?>
                    <body>
                        <? include 'view/header.php';?>
                        <? include 'view/main.php';?>
                        <? include 'view/footer.php';?>
                    </body>
                    <? include 'view/alerts.php';?>
                </html>
                <?php
            }
            else
            {
                header('Location: '.$txtBase.'error/');
                die();
            }
        }
        else
        {
            header('Location: '.$txtBase.'error/');
            die();
        }
    }
    else
    {
        header('Location: '.$txtBase.'error/');
        die();
    }