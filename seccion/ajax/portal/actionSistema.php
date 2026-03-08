<?php
	session_start();
	error_reporting(E_ERROR);
	include_once("../../../portal/motor/conexionSitio.php");
	include_once("../../../portal/motor/globales.php");
	conectarSistema();
	$valCatalogo = "true";
	$alert = '';
	ini_set('memory_limit', '1024M');
	set_time_limit(300);

	switch($_POST["tipo"])
	{
		case 1:
			$backup_file = date('YmdHis');
			liberar_bd();
			//get all of the tables
			$tables = array();
			$result = consulta('SHOW TABLES');
			while($row = siguiente_registro_array($result))
			{
				$tables[] = $row[0];
			}

			//cycle through
			foreach($tables as $table)
			{
				liberar_bd();
				$resultTab = consulta('	SELECT count(*) AS numCols
										FROM information_schema.columns
										WHERE table_schema="'.$_SESSION['bdConect'].'"
										AND table_name = "'.$table.'"');

				$numCol = siguiente_registro($resultTab);
				$numCols = $numCol["numCols"];

				liberar_bd();
				$result = consulta('SELECT * FROM '.$table);

				while($row = siguiente_registro_array($result))
				{
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$numCols; $j++)
					{
						if (isset($row[$j]))
							$return.= '"'.$row[$j].'"';
						else
							$return.= '""';

						if ($j<($numCols-1))
							$return.= ',';
					}
					$return.= ");\n";
				}
				$return.="\n\n\n";
			}

			//save file
			$command = fopen('../../../adminvisor/imagenes/respaldos/'.$backup_file.'.txt','w+');
			fwrite($command,$return);
			$alert = fclose($command);

			//INSERTAMOS EN LA TABLA DE HISTORIAL
			liberar_bd();
			$insertBackup = 'CALL sp_sistema_insert_historial_respaldo(	"'.$backup_file.'.txt'.'", '.$_SESSION["idUser"].',
																		"'.todayComplete().'");';
			$insertBack = consulta($insertBackup);
		break;
	}

	echo json_encode(array("valCatalogo"=>$valCatalogo, "alert"=>$alert));