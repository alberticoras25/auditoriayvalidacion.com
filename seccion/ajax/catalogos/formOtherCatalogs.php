<?php
    session_start();
    error_reporting(E_ERROR);
    include_once("../../../sistema/motor/conexionSitio.php");
    include_once("../../../sistema/motor/globales.php");
    conectarSistema();
    $valCatalogo = "true";
    $alert = $formulario = '';

    switch($_POST["catTipo"])
    {
    }

    echo json_encode(array("valCatalogo"=>$valCatalogo, "alert"=>$alert, "formulario"=>$formulario));