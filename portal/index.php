<?php
	ini_set('display_errors', false);
	ini_set('upload_max_filesize','512M');
	ini_set( "memory_limit", "512M" );
	ini_set( 'date.timezone', 'America/Mexico_City' );
	session_start();
	include_once("motor/sesion.php");
	include_once("motor/conexionSitio.php");
	conectarSistema();
	liberar_bd();
	$selectVariableIdUser = 'CALL sp_sistema_select_variable_id_usuario();';
	$variableIdUser = consulta($selectVariableIdUser);
	$varIdUser = siguiente_registro($variableIdUser);
	include_once("motor/globales.php");
	muestraContenido();