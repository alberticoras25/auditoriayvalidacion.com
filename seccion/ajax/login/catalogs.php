<?php
    session_start();
    error_reporting(E_ERROR);
    include_once("../../../portal/motor/conexionSitio.php");
    include_once("../../../portal/motor/globales.php");
    conectarSistema();
    $valCatalogo = "true";
    $alert = $catalogo = '';

    echo json_encode(array("valCatalogo"=>$valCatalogo, "alert"=>$alert, "catalogo"=>$catalogo));