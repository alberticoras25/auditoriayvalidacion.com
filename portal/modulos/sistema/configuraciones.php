<?php
	session_start();
	include_once('configuraciones_funciones.php');
	//DATOS DEL MODULO
	liberar_bd();
	$selectDatosModulo = 'CALL sp_sistema_select_datos_modulo('.$_SESSION["mod"].');';
	$datosModulo = consulta($selectDatosModulo);
	$datMod = siguiente_registro($datosModulo);
	$_SESSION["moduloPadreActual"] = utf8_convert($datMod["nombre"]);

	switch($_POST['accion'])
	{
		default:
			$modulo .= configuraciones_menuInicio();
		break;
	}