<?php
	session_start();
	error_reporting(E_ERROR);
	include_once("../../portal/motor/conexionSitio.php");
	include_once("../../portal/motor/globales.php");
	include_once("../../clases/attach_mailer/attach_mailer_class.php");
	conectarSistema();
	$valReport = "true";
	$alert = $txtReturn = '';
	$idReturn = 0;

	switch($_POST["catTipo"])
	{
	}

	echo json_encode(array("valReport"=>$valReport, "alert"=>$alert, "idReturn"=>$idReturn, "txtReturn"=>$txtReturn));