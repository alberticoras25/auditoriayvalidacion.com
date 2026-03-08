<?php
	session_start();
	error_reporting(E_ERROR);
	include_once("../../portal/motor/conexionSitio.php");
	include_once("../../portal/motor/globales.php");
	conectarSistema();
	$valAdmon = "true";
	$newRow = $newSubRow = $alert = $txtReturn = '';
	$idReturn = 0;
	$valReturn = $valSubReturn = false;

	switch($_POST["catTipo"])
	{
		case '11702':
			//PREMISOS DE ACCIONES
			liberar_bd();
			$selectPermisosAcciones = 'CALL sp_sistema_select_permisos_acciones_modulo('.$_SESSION["idPerfil"].', '.$_POST["catTipo"].');';
			$permisosAcciones = consulta($selectPermisosAcciones);
			while($acciones = siguiente_registro($permisosAcciones))
			{
				switch(utf8_convert($acciones["accion"]))
				{
					case 'Modificación':$btnEdita = true;break;
					case 'Eliminación':$btnElimina = true;break;
				}
			}

			switch($_POST["action"])
			{
				case 'new':
					$logUser = mb_convert_case($_POST['logUser'], MB_CASE_UPPER, "UTF-8");
					$pswd = mb_convert_case($_POST['pswd'], MB_CASE_UPPER, "UTF-8");

					liberar_bd();
					$selectLoginUsuario =  "CALL sp_sistema_select_usuario_login('".$logUser."');";
					$loginUsuario = consulta($selectLoginUsuario);
					$ctaloginUsuario = cuenta_registros($loginUsuario);
					if($ctaloginUsuario == 0)
					{
						liberar_bd();
						$insertUsuarioId = ' CALL sp_sistema_insert_usuario("'.utf8_desconvert($logUser).'",
                                                                            "'.utf8_desconvert($_POST["nomUser"]).'",
                                                                            "'.utf8_desconvert($pswd).'",
                                                                            '.$_POST["id_perfil"].',
                                                                            '.$_SESSION["idUser"].',
                                                                            "'.todayComplete().'");';

						$insertUsuario = consulta($insertUsuarioId);

						if($insertUsuario)
						{
							$insertUser = siguiente_registro($insertUsuario);
							$idReturn = $idUser = $insertUser["idUser"];

							$valReturn = true;
							$alert = 'Usuario agregado existosamente';
						}
						else
						{
							$valAdmon = "false";
							$alert = 'No se pudo agregar el usuario';
						}
					}
					else
					{
						$valAdmon = "false";
						$alert = 'Ya existe un usuario con este nombre de acceso';
					}
				break;
				case 'edit':
					$idReturn = $idUser = $_POST["idElem"];

					$logUser = mb_convert_case($_POST['logUser'], MB_CASE_UPPER, "UTF-8");
					$pswd = mb_convert_case($_POST['pswd'], MB_CASE_UPPER, "UTF-8");

					liberar_bd();
					$selectLoginUsuario = "CALL sp_sistema_select_usuario_loginEditar('".utf8_desconvert($logUser)."', '".$idUser."');";
					$loginUsuario = consulta($selectLoginUsuario);
					$ctaLoginUsuario = cuenta_registros($loginUsuario);
					if($ctaLoginUsuario == 0)
					{
						liberar_bd();
						$updateUserSystem = 'CALL sp_sistema_update_usuario("'.$logUser.'", "'.utf8_desconvert($_POST["nomUser"]).'",
																			'.$_POST["id_perfil"].', '.$idUser.', '.$_SESSION["idUser"].');';

						$userSystem = consulta($updateUserSystem);

						if($userSystem)
						{
							if($_POST["pswd"] != "")
							{
								//ACTUALIZAMOS LAS CONTRASEÑAS DEL USUARIO
								liberar_bd();
								$updatePassUser = 'CALL sp_sistema_update_pass_user('.$idUser.', md5("'.utf8_desconvert($pswd).'"));';
								$passUser  = consulta($updatePassUser);
							}

							/*if($_POST["changeSuc"] == 1)
                            {
                                //CAMBIO DE DIA DE SUCURSAL
                                liberar_bd();
                                $updateFechaSuc = 'CALL sp_sistema_update_fecha_dia_sucursal('.$_POST["idElem"].');';
                                $updFechaSuc = consulta($updateFechaSuc);
                            }*/

							$valReturn = true;
							$alert = 'Usuario actualizado existosamente';
						}
						else
						{
							$valAdmon = "false";
							$alert = 'No se pudo actualizar el usuario';
						}
					}
					else
					{
						$valAdmon = "false";
						$alert = 'Ya existe un usuario con este nombre de acceso';
					}
				break;
			}

			if($valReturn)
			{
				liberar_bd();
				$selectUsuarioId = "CALL sp_sistema_select_usuario_id(".$idUser.");";
				$usuarioId = consulta($selectUsuarioId);
				$user = siguiente_registro($usuarioId);

				$newRow.= ' <tr id="'.$idUser.'">
								<td>'.utf8_convert($user["nombre"]).' ('.utf8_convert($user["login"]).')</td>
								<td>'.utf8_convert($user["perfil"]).'</td>
								<td>
									<div class="btn-group top-right-button-container" role="group">';
										if($btnEdita)
											$newRow.= ' <button type="button" class="btn btn-primary icon-button see_sidemenu_r_cat" title="Editar" onClick="muestra_page(\'myModalContent\', '.$_POST["catTipo"].', \'edit\', '.$idUser.')">
															<i class="simple-icon-pencil"></i>
														</button> ';

										if($btnElimina)
											$newRow.= ' <button type="button" class="btn btn-danger icon-button" title="Eliminar" onClick="actionCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'delete\', '.$idUser.')">
															<i class="simple-icon-trash"></i>
														</button> ';
				$newRow.= '	  	    </div>
								</td>
							</tr>';
			}
		break;
	}

	echo json_encode(array("valAdmon"=>$valAdmon, "alert"=>$alert, "idReturn"=>$idReturn, "txtReturn"=>$txtReturn, "newRow"=>$newRow, "newSubRow"=>$newSubRow));