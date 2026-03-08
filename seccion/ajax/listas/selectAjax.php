<?php
	session_start();
	error_reporting(E_ERROR);
	include_once("../../../portal/motor/conexionSitio.php");
	include_once("../../../portal/motor/globales.php");
	conectarSistema();
	$valCount = $reseteRet = 'true';
	$retLista = '';
	$valDefault = true;
	$valSel = 0;

	switch($_POST["list"])
	{
		case "citiesEdos":
			$defaultOption = 'SELECCIONE UNA CIUDAD';
			$errorOption = '';
			$idElement = $_POST["idElement"];
			$selectLista = 'CALL sp_sistema_lista_ciudades_edoId('.$idElement.');';
		break;
	}

	if($valDefault)
		$retLista = '<option value="0" selected>'.$defaultOption.'</option>';

	liberar_bd();
	$lista = consulta($selectLista);
	$ctaLista = cuenta_registros($lista);
	if($ctaLista != 0)
	{
		while ($li = siguiente_registro($lista))
		{
			$validateExp = true;
			$selected = $txtComplement = "";
			$idLi = $li["id"];
			switch($_POST["list"])
			{
			}

			if($validateExp)
				$retLista .= '<option '.$selected.' value="'.$idLi.'">'.utf8_convert($li["nombre"]).$txtComplement.'</option>';
		}
	}
	else
		$valCount = 'false';

	echo json_encode(array("retLista"=>$retLista, "valCount"=>$valCount, "errorOption"=>$errorOption, "reseteRet"=>$reseteRet, "valSel"=>$valSel));
