<?php
    session_start();
    error_reporting(E_ERROR);
    include_once("../../../portal/motor/conexionSitio.php");
    include_once("../../../portal/motor/globales.php");
    conectarSistema();
    $valAction = "true";
    $newRow = $newSubRow = $alert = $txtReturn = '';
    $idReturn = 0;
    $valReturn = $valSubReturn = false;

    switch($_POST["catTipo"])
    {
        case '11704':
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
                    case 'Asignación':$btnAsigna = true;break;
                }
            }

            switch($_POST["action"])
            {
                case 'delete':
                    $idReturn = $idCor = $_POST["idElem"];

                    liberar_bd();
                    $sqlDeleteCorreoNoti = "CALL sp_sistema_delete_correo_notificacion('".$idCor."', ".$_SESSION["idUser"].");";
                    $sqlAction = consulta($sqlDeleteCorreoNoti);

                    if($sqlAction)
                    {
                        $valReturn = true;
                        $alert = "Correo eliminado exitosamente";
                    }
                    else
                    {
                        $valReport = "false";
                        $alert = "No se eliminó el correo";
                    }
                break;
                case 'assign':
                    $idReturn = $idCor = $_POST["idElem"];

                    //ELIMINAMOS TODAS LAS ASIGNACIONES DEL CORREO
                    liberar_bd();
                    $deleteAsignaCorreo = 'CALL sp_sistema_delete_asignaciones_correo('.$idCor.');';
                    $delAsigCorreo = consulta($deleteAsignaCorreo);

                    $selectChkNoti = array_values(array_sort($_POST['chkNoti'], 'idConf', SORT_ASC));
                    foreach($selectChkNoti as $value)
                    {
                        extract($value);
                        //ASIGNAMOS LA NOTIFICACION AL CORREO
                        liberar_bd();
                        $insertCorreoNotificacion = 'CALL sp_sistema_insert_correo_asigna_notificacion('.$idCor.', '.$idConf.');';
                        $insertCoNot = consulta($insertCorreoNotificacion);
                    }

                    $valReturn = true;
                    $alert = "Correo asignado exitosamente";
                break;
            }

            if($valReturn)
			{
				//DATOS DEL CORREO
				liberar_bd();
				$datosCorreo = 'CALL sp_sistema_select_datos_correo_notificacion('.$idCor.');';
				$datCorr = consulta($datosCorreo);
				$cat = siguiente_registro($datCorr);

				$newRow.= ' <tr id="'.$idCor.'">
								<td class="text-lowercase">'.utf8_convert($cat["correo"]).'</td>
								<td>'.utf8_convert($cat["txt"]).'</td>
								<td>
									<div class="btn-group top-right-button-container" role="group">';
										if($btnEdita)
											$newRow.= ' <button type="button" class="btn btn-primary icon-button see_sidemenu_r_cat" title="Editar" onClick="muestra_page(\'myModalContent\', '.$_POST["catTipo"].', \'edit\', '.$idCor.')">
																<i class="simple-icon-pencil"></i>
															</button> ';

										if($btnAsigna)
											$newRow.= ' <button type="button" class="btn btn-dark icon-button" title="Asignar" onClick="formCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'assign\', '.$idCor.')">
																<i class="glyph-icon iconsminds-mail-link"></i>
															</button> ';

										if($btnElimina)
											$newRow.= ' <button type="button" class="btn btn-danger icon-button" title="Eliminar" onClick="actionCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'delete\', '.$idCor.')">
															<i class="simple-icon-trash"></i>
														</button> ';

				$newRow.= '	  	    </div>
								</td>
							</tr>';
			}
        break;
    }

    echo json_encode(array("valAction"=>$valAction, "alert"=>$alert, "idReturn"=>$idReturn, "txtReturn"=>$txtReturn, "newRow"=>$newRow, "newSubRow"=>$newSubRow));