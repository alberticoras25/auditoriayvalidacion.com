<?php
    session_start();
    error_reporting(E_ERROR);
    include_once("../../../portal/motor/conexionSitio.php");
    include_once("../../../portal/motor/globales.php");
    conectarSistema();
    $valCatalogo = "true";
    $alert = $formulario = '';

    echo json_encode(array("valCatalogo"=>$valCatalogo, "alert"=>$alert, "formulario"=>$formulario));