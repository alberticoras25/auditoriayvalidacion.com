<?php
    session_start();
    error_reporting(E_ERROR);
    include_once("../motor/conexionSitio.php");
    include_once("../motor/globales.php");
    conectarSistema();

    //LISTA DE SERVICIOS
    liberar_bd();
    $selectListaServicios = '  SELECT
                                    serv.id_servicios AS id
                                FROM
                                    servicios AS serv
                                ORDER BY id';

    $listaServicios = consulta($selectListaServicios);
    while($listServ = siguiente_registro($listaServicios))
    {
        $idServACtual = $listServ["id"];

        //DATOS DEL SERVICIO ACTUAL
        liberar_bd();
        $selectDatosServicio = 'CALL sp_sistema_select_datos_comerciales_servicio('.$idServACtual.')';
        $datosServicio = consulta($selectDatosServicio);
        $servi = siguiente_registro($datosServicio);

        //TOTALES ACTUALES
        liberar_bd();
        $selectDatosTotales = 'CALL sp_select_totales_guardias_servicio_estatus('.$idServACtual.', 3)';
        $datosTotales = consulta($selectDatosTotales);
        $serviT = siguiente_registro($datosTotales);
        $newMontFin = $newMontNorm = 0;

        if($serviT["sumaPacto"] != "")
            $newMontFin = $serviT["sumaPacto"];

        if($serviT["sumaNormal"] != "")
            $newMontNorm = $serviT["sumaNormal"];

        $porcDesc = $newMontNorm * 100;

        if($porcDesc != 0)
        {
            $porcDesc = $porcDesc / $newMontFin;
            $porcDesc = 100 - $porcDesc;
        }
        else
            $porcDesc = 0;

        $montoInter = $servi["montoInter"];//NO CAMBIA
        $montoRecup = $servi["montoRecup"];
        $newMontoRecup = $newMontNorm - $montoInter;

        $montoDescPP = $servi["montoDescPP"];//NO CAMBIA
        $porcDescPP = $servi["porcDescPP"];

        $newPorcDescPP = 0;
        if($newMontoRecup != 0)
            $newPorcDescPP = ($montoDescPP * 100) / $newMontoRecup;

        /*if($newPorcDescPP != 0)
            $newPorcDescPP = 100 - $newPorcDescPP;*/

        $cargos = $servi["cargos"];//NO CAMBIA
        $montoRecupEfec = $servi["montoRecupEfec"];
        $newMontoRecupEfec = ($newMontoRecup - $montoDescPP) + $cargos;

        $facturaInter = $servi["facturaInter"];
        $totalFact = $servi["totalFact"];
        if($facturaInter == 1)
            $newTotalFact = $newMontNorm + $cargos;
        else
            $newTotalFact = ($newMontNorm - $montoInter) + $cargos;

        $montoDescFin = $servi["montoDescFin"];
        $newMontoDescFin = $newMontNorm - $montoDescPP;

        $porcDescFin = $servi["porcDescFin"];

        $newPorcDescFin = 0;
        if($newMontFin != 0)
        {
            $newPorcDescFin = ($newMontFin - $newMontoDescFin) / $newMontFin;
            $newPorcDescFin = $newPorcDescFin * 100;
        }

        //ACTUALIZAMOS MONTOS Y DESCUENTO DE SERVICIO
        liberar_bd();
        $updateMontosServicio = 'CALL sp_sistema_update_montos_servicio('.$idServACtual.',
                                                                        '.$newMontFin.',
                                                                        '.$newMontNorm.',
                                                                        '.$porcDesc.',
                                                                        '.$newMontoRecup.',
                                                                        '.$newPorcDescPP.',
                                                                        '.$newMontoRecupEfec.',
                                                                        '.$newTotalFact.',
                                                                        '.$newMontoDescFin.',
                                                                        '.$newPorcDescFin.',
                                                                        1);';

        $montosServicio = consulta($updateMontosServicio);

        //GUARDAMOS LA MODIFICACION
        liberar_bd();
        $insertModificaServicio = 'CALL sp_sistema_insert_modifica_servicio('.$idServACtual.',
                                                                            '.$servi["montoFin"].',
                                                                            '.$servi["montoNor"].',
                                                                            '.$servi["porcDesc"].',
                                                                            '.$servi["montoRecup"].',
                                                                            '.$servi["porcDescPP"].',
                                                                            '.$servi["montoRecupEfec"].',
                                                                            '.$servi["totalFact"].',
                                                                            '.$servi["montoDescFin"].',
                                                                            '.$servi["porcDescFin"].',
                                                                            "'.$servi["fecha"].'",
                                                                            '.$newMontFin.',
                                                                            '.$newMontNorm.',
                                                                            '.$porcDesc.',
                                                                            '.$newMontoRecup.',
                                                                            '.$newPorcDescPP.',
                                                                            '.$newMontoRecupEfec.',
                                                                            '.$newTotalFact.',
                                                                            '.$newMontoDescFin.',
                                                                            '.$newPorcDescFin.',
                                                                            1, 1);';

        $modificaServicio = consulta($insertModificaServicio);
    }