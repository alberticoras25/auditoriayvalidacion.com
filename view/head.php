<?php
    session_start();
    date_default_timezone_set('America/Mexico_City') ;
    include("../portal/motor/conexionSitio.php");
    include("../portal/motor/globales.php");

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

    $valCheckBD = true;
    switch($file)
    {
        case 'index.php':
            $description = "";
            $pageTitle = "Inicio";
            $pageStyle = '  <link rel="stylesheet" href="portal/css/vendor/quill.snow.css">';
        break;
        case '404.php':
            $description = "";
            $pageTitle = "Error";
            $pageStyle = '';
        break;
        default:

        break;
    }
?>
    <head>
        <base href="<?=$txtBase;?>">
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="author" content="">
        <meta name="description" content="<?=$description;?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="base" href="<?=$txtBase;?>">
        <link rel="canonical" href="<?=$_SERVER["canonical"];?>">
        <!--<link rel="shortcut icon" href="portal/imagenes/empresa/logo.png" type="image/png">-->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/flaticon.css">
        <link rel="stylesheet" href="assets/css/nice-select.css">
        <link rel="stylesheet" href="assets/css/animate.css">
        <link rel="stylesheet" href="assets/css/magnific-popup.css">
        <link rel="stylesheet" href="assets/css/slick.css">
        <link rel="stylesheet" href="assets/css/default.css?v=<?=uniqid();?>">
        <link rel="stylesheet" href="assets/css/style.css?v=<?=uniqid();?>">
        <link rel="stylesheet" href="assets/css/mystyle.css?v=<?=uniqid();?>">
        <?=$pageStyle;?>
        <title><?=$pageTitle;?> - Validación y Auditoría </title>
        <?=$pageShare;?>
    </head>