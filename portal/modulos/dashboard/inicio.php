<?php
	session_start();
	include_once('inicio_funciones.php');

	switch($_POST['accion'])
	{
		default:
			$modulo .= inicio_menuInicio();
		break;
	}