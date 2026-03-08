<?php
    set_time_limit(300);
    session_start();
    error_reporting(E_ERROR);
    include_once("../../../portal/motor/conexionSitio.php");
    include_once("../../../portal/motor/globales.php");
    conectarSistema();
    $alert = '';
    $valReporte = true;
    $txtFile = "imagenes/reportes/";
    $src =	date("YmdHis").".pdf";

    $server = $_SERVER['SERVER_NAME'];
    if($server == "localhost")
        $root = '/proyectos/multipagos/';
    else
        $root = 'https://iopik.com/mm/';

    $fecha = date('d/m/Y');
    $hora = date('h:i:s');

    liberar_bd();
    $selecDatosEmpresa = "	CALL sp_sistema_select_datos_empresa();";
    $datosEmpresa = consulta($selecDatosEmpresa);
    $empresa = siguiente_registro($datosEmpresa);
    $domicilio = $empresa["domicilio"];
    $srcImagen = "../../../portal/imagenes/empresa/".$empresa["logo"];

    switch ($_POST["catTipo"])
    {
    }

    echo json_encode(array("valReporte"=>$valReporte, "alert"=>$alert, "txtFile"=>$txtFile.$src));