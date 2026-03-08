<?php
    session_start();
    date_default_timezone_set('America/Mexico_City') ;
    include("portal/motor/conexionSitio.php");
    include("portal/motor/globales.php");
    conectarSistema();
    error_reporting(E_ERROR);
?>

<!doctype html>
<html lang="es">
    <? include 'view/head.php';?>
    <body>
        <div class="ts-page-wrapper" id="page-top">
            <? include 'view/header.php';?>
            <? include 'view/main.php';?>
            <? include 'view/footer.php';?>
        </div>
    </body>
    <? include 'view/alerts.php';?>
</html>