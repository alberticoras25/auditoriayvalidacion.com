<?php
	function conectarSistema()
	{
		$usuario = "u283966854_usvalau2";
		$pass = "V4liD4ci0N4uDi74";
		$bd = "u283966854_valaudita2";
		$servidor = "localhost";

		$conexion = mysqli_connect($servidor, $usuario, $pass, $bd); 
	
		if(mysqli_connect_errno())
		{
			echo "La conexión falló: " . mysqli_connect_error();
		}
		else
		{
			$_SESSION['conexion'] = $conexion;
			$_SESSION['bdConect'] = $bd;
		}	
	}

	function consulta($sql)
	{
		$resultado = mysqli_query($_SESSION['conexion'],$sql);
		return $resultado;
	}
	
	function cuenta_registros($resultado)
	{
		return mysqli_num_rows($resultado);	
	}
	
	function siguiente_registro($resultado)
	{
		return mysqli_fetch_assoc($resultado);	
	}
	
	function ultimo_id()
	{
		return mysqli_insert_id($_SESSION["conexion"]);	
	}
	
	function inicia_transaccion()
	{
		mysqli_autocommit($_SESSION['conexion'], FALSE);
	}
	
	function aplica_transaccion()
	{
		mysqli_commit($_SESSION['conexion']);
		mysqli_autocommit($_SESSION['conexion'], TRUE);
	}
	
	function cancela_transaccion()
	{
		mysqli_rollback($_SESSION['conexion']);
		mysqli_autocommit($_SESSION['conexion'], TRUE);
	}

	function liberar_bd()
	{
		$conexion = $_SESSION['conexion'];
		while(mysqli_more_results($conexion))
		{
			if(mysqli_next_result($conexion))
			{
				$resultado = mysqli_use_result($conexion);
				mysqli_free_result($resultado);
			}
		}
	}

	function siguiente_registro_array($resultado)
	{
		return convertArrayToUTF8(mysqli_fetch_array($resultado));
	}

	function multiconsulta($sql)
	{
		return mysqli_multi_query($_SESSION["conexion"], $sql);
	}

	function ultimo_multiconsulta($sql)
	{
		mysqli_multi_query($_SESSION["conexion"], $sql);
		do {
			null;
		} while (mysqli_more_results($_SESSION['conexion']) && mysqli_next_result($_SESSION['conexion']));
		$result = mysqli_store_result($_SESSION['conexion']);
		return $result;
	}

	function convertArrayToUTF8($array)
	{
		array_walk_recursive($array, function ($item, $key) {
			if (!mb_detect_encoding($item, 'utf-8', true)) {
				$item = utf8_encode($item);
			}
		});

		return $array;
	}

	function deconvertArrayFromUTF8($array)
	{
		array_walk_recursive($array, function ($item, $key) {
			if (mb_detect_encoding($item, 'utf-8', true)) {
				$item = utf8_decode($item);
			}
		});

		return $array;
	}

	function deconvertStringFromUTF8($string)
	{
		if (mb_detect_encoding($string, 'utf-8', true)) {
			$string = utf8_decode($string);
		}

		return $string;
	}