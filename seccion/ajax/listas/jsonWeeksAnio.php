<?php
    session_start();
    error_reporting(E_ERROR);
    include_once("../../../portal/motor/conexionSitio.php");
    include_once("../../../portal/motor/globales.php");
    conectarSistema();
    $json = [];

    $optionWeeks = '';
    $year = $_GET["q"]["term"];
    $weeks = getIsoWeeksInYear($year);
    for($x=1; $x<=$weeks; $x++)
    {
        $dates = getStartAndEndDate($x, $year, 3);
        $json[] = ['id'=>normalize_date($dates['week_start']).' - '.normalize_date($dates['week_end']), 'text'=>$year.'/'.$x.' ('.normalize_date($dates['week_start']).' - '.normalize_date($dates['week_end']).')'];
    }

    echo json_encode($json, JSON_UNESCAPED_UNICODE);