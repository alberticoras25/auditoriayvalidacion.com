<?php
	session_start();
	include_once('comingsoon_funciones.php');

	switch($_POST['accion'])
	{
		default:
			$modulo .= comingsoon_menuInicio();
		break;
	}