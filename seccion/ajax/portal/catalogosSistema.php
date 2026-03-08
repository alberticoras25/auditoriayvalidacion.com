<?php
	session_start();
	error_reporting(E_ERROR);
	include_once("../../../portal/motor/conexionSitio.php");
	include_once("../../../portal/motor/globales.php");
	conectarSistema();
	
	//PREMISOS DE ACCIONES
    liberar_bd();
    $selectPermisosAcciones = 'CALL sp_sistema_select_permisos_acciones_modulo(' . $_SESSION["idPerfil"] . ', ' . $_SESSION["modSis"] . ');';
    $permisosAcciones = consulta($selectPermisosAcciones);
    while ($acciones = siguiente_registro($permisosAcciones))
    {
        switch (($acciones["accion"]))
        {
            case 'Descargar':
                $btnDescargar = true;
            break;
            case 'Generar':
                $btnGenerar = true;
            break;
        }
    }

	liberar_bd();
	switch($_POST["catTipo"])
	{
	}

	echo json_encode(array("catalogo"=>$catalogo));