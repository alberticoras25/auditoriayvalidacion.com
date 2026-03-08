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
        case '0':
            switch($_POST["action"])
            {
                case 'getBulks':
                    unset($_SESSION['per_tables']);
                    //PERMISOS TABLA PERFIL
                    liberar_bd();
                    $selectPermisosTablasPerfil = 'CALL sp_sistema_select_permisos_tablas_perfil('.$_SESSION['idPerfil'].');';
                    $permisosTablasPerfil = consulta($selectPermisosTablasPerfil);
                    while($perTabPerf = siguiente_registro($permisosTablasPerfil))
                    {
                        $_SESSION['per_tables'][] = array('idPer' => $perTabPerf["id"], 'valor' => 1);
                    }
                break;
                case 'getSessionVar':
                    session_start();
                    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800))
                    {
                        // last request was more than 30 minutes ago
                        session_unset();     // unset $_SESSION variable for the run-time
                        session_destroy();   // destroy session data in storage
                    }
                    $_SESSION['LAST_ACTIVITY'] = time();
                break;
                case 'setSessionConnect':
                    session_start();
                    $_SESSION["reConnect"] = 1;
                break;
                case 'setSessionReConnect':
                    session_start();
                    $_SESSION["reConnect"] = 0;
                    $_SESSION["txtRePassword"] = $_POST["txtRePassword"];
                    $_SESSION["connect"] = 1;
                break;
                case 'setSessionInit':
                    session_start();
                    session_unset();
                    session_destroy();
                break;
            }
        break;
        case '10001':
            switch($_POST["action"])
            {
                case 'edit':
                    $usuario = mb_convert_case($_POST['usuario'], MB_CASE_UPPER, "UTF-8");

                    //EDITAMOS LOS DATOS DEL USUARIO
                    liberar_bd();
                    $update = "	UPDATE
                                    _usuarios
                                SET
                                    login_usuario = '".utf8_desconvert($usuario)."',
                                    nombre_usuario = '".utf8_desconvert($_POST["nombre"])."',
                                    id_usuarioCreate = ".$_SESSION["idUser"]." ";

                    if($_POST["pass"] != "")
                    {
                        $pass = mb_convert_case($_POST['pass'], MB_CASE_UPPER, "UTF-8");
                        $update .= ", password_usuario = '".md5($pass)."'";
                    }
                    $update .= " WHERE id_usuario = '".$_SESSION["idUser"]."'";
                    $updateUsuario = consulta($update);

                    liberar_bd();
                    $updateUser = 'CALL sp_sistema_update_datos_usuario('.$_SESSION["idUser"].', "'.utf8_desconvert($_POST["calle"]).'",
                                                                        "'.utf8_desconvert($_POST["numExt"]).'", "'.utf8_desconvert($_POST["numInt"]).'",
                                                                        "'.utf8_desconvert($_POST["colonia"]).'", "'.$_POST["cp"].'",
                                                                        "'.normalize_date2($_POST["fechaNat"]).'",
                                                                        "'.strtolower($_POST["email"]).'", "'.$_POST["telefono"].'");';
                    $updateU = consulta($updateUser);

                    $alert = 'Datos del usuario actualizados';
                break;
            }
        break;
        case '10002':
            switch($_POST["action"])
            {
                case 'edit':
                    switch($_POST["idElem"])
                    {
                        case 8:
                            $alert = 'Configuraciones de notificaciones actualizadas';
                            $confiLim = array_values(array_sort($_POST['confiLim'], 'idConf', SORT_ASC));
                            foreach($confiLim as $value)
                            {
                                extract($value);
                                //ACTUALIZAMOS LOS LIMITES DE NOTIFICACIONES
                                liberar_bd();
                                $updateLimiteConfig = 'CALL sp_sistema_update_limite_config_notificacion(   '.$idConf.', '.$valLim.',
                                                                                                            '.$_SESSION["idUser"].');';
                                $updateLim = consulta($updateLimiteConfig);
                            }
                        break;
                    }
                break;
            }
        break;
        case '11701':
            //PREMISOS DE ACCIONES
            liberar_bd();
            $selectPermisosAcciones = 'CALL sp_sistema_select_permisos_acciones_modulo('.$_SESSION["idPerfil"].', '.$_POST["catTipo"].');';
            $permisosAcciones = consulta($selectPermisosAcciones);
            while($acciones = siguiente_registro($permisosAcciones))
            {
                switch(utf8_convert($acciones["accion"]))
                {
                    case 'Modificación':$btnEdita = true;break;
                    case 'Permisos de tablero':$btnPermisos = true;break;
                    case 'Eliminación':$btnElimina = true;break;
                }
            }

            switch($_POST["action"])
            {
                case 'new':
                    liberar_bd();
                    $selectPerfiles= "SELECT *
                                      FROM
                                        _perfiles
                                      WHERE
                                        nombre_perfil = '".utf8_desconvert($_POST['nombrePerfil'])."'";

                    $perfiles = consulta($selectPerfiles);
                    $numPerfiles =  cuenta_registros($perfiles);
                    if($numPerfiles == 0)
                    {
                        liberar_bd();
                        $insertPerfile = "CALL sp_sistema_insert_perfil('".utf8_desconvert($_POST['nombrePerfil'])."', ".$_POST["isAdmin"].")";
                        $insertPer = consulta($insertPerfile);
                        if($insertPer)
                        {
                            $inPerf = siguiente_registro($insertPer);
                            $idReturn = $idPerfil = $inPerf["idPer"];

                            $chkMod = array_values(array_sort($_POST['chkMod'], 'idMod', SORT_ASC));
                            foreach($chkMod as $value)
                            {
                                extract($value);
                                //GUARDAMOS EL PERMISO DE MODULO
                                liberar_bd();
                                $insertPermisos = "CALL sp_sistema_insert_permiso_modulo(".$idPerfil.", ".$idMod.")";
                                $insertPer = consulta($insertPermisos);
                            }

                            $chkSubMod = array_values(array_sort($_POST['chkSubMod'], 'idSubMod', SORT_ASC));
                            foreach($chkSubMod as $value1)
                            {
                                extract($value1);
                                //GUARDAMOS EL PERMISO DE MODULO
                                liberar_bd();
                                $insertPermisos = "CALL sp_sistema_insert_permiso_modulo(".$idPerfil.", ".$idSubMod.")";
                                $insertPer = consulta($insertPermisos);
                            }

                            $chkSubSubMod = array_values(array_sort($_POST['chkSubSubMod'], 'idSubSubMod', SORT_ASC));
                            foreach($chkSubSubMod as $value2)
                            {
                                extract($value2);
                                //GUARDAMOS EL PERMISO DE MODULO
                                liberar_bd();
                                $insertPermisos = "CALL sp_sistema_insert_permiso_modulo(".$idPerfil.", ".$idSubSubMod.")";
                                $insertPer = consulta($insertPermisos);
                            }

                            $chkSubSubSubMod = array_values(array_sort($_POST['chkSubSubSubMod'], 'idSubSubSubMod', SORT_ASC));
                            foreach($chkSubSubSubMod as $value5)
                            {
                                extract($value5);
                                //GUARDAMOS EL PERMISO DE MODULO
                                liberar_bd();
                                $insertPermisos = "CALL sp_sistema_insert_permiso_modulo(".$idPerfil.", ".$idSubSubSubMod.")";
                                $insertPer = consulta($insertPermisos);
                            }

                            $chkAccSubSubMod = array_values(array_sort($_POST['chkAccSubSubMod'], 'idAccSubSubMod', SORT_ASC));
                            foreach($chkAccSubSubMod as $value3)
                            {
                                extract($value3);
                                //GUARDAMOS EL PERMISO DE ACCION
                                liberar_bd();
                                $insertPermisosAccion = "CALL sp_sistema_insert_permiso_accion(".$idPerfil.", ".$idAccSubSubMod.")";
                                $insertPerAcci = consulta($insertPermisosAccion);
                            }

                            $chkAccSubMod = array_values(array_sort($_POST['chkAccSubMod'], 'idAccSubMod', SORT_ASC));
                            foreach($chkAccSubMod as $value4)
                            {
                                extract($value4);
                                //GUARDAMOS EL PERMISO DE ACCION
                                liberar_bd();
                                $insertPermisosAccion = "CALL sp_sistema_insert_permiso_accion(".$idPerfil.", ".$idAccSubMod.")";
                                $insertPerAcci = consulta($insertPermisosAccion);
                            }

                            $chkAccSubSubSubMod = array_values(array_sort($_POST['chkAccSubSubSubMod'], 'idAccSubSubSubMod', SORT_ASC));
                            foreach($chkAccSubSubSubMod as $value6)
                            {
                                extract($value6);
                                //GUARDAMOS EL PERMISO DE ACCION
                                liberar_bd();
                                $insertPermisosAccion = "CALL sp_sistema_insert_permiso_accion(".$idPerfil.", ".$idAccSubSubSubMod.")";
                                $insertPerAcci = consulta($insertPermisosAccion);
                            }

                            /*$chkTab = array_values(array_sort($_POST['chkTab'], 'idTab', SORT_ASC));
                            foreach($chkTab as $value5)
                            {
                                extract($value5);
                                //GUARDAMOS EL PERMISO DE TABLERO
                                liberar_bd();
                                $insertPermisosTablero = "CALL sp_sistema_insert_permiso_tablero(".$idPerfil.", ".$idTab.")";
                                $insertPerTab = consulta($insertPermisosTablero);
                            }

                            $chkSubTab = array_values(array_sort($_POST['chkSubTab'], 'idSubTab', SORT_ASC));
                            foreach($chkSubTab as $value6)
                            {
                                extract($value6);
                                //GUARDAMOS EL PERMISO DE SUB TABLERO
                                liberar_bd();
                                $insertPermisosSTablero = "CALL sp_sistema_insert_permiso_tablero(".$idPerfil.", ".$idSubTab.")";
                                $insertPerSTab = consulta($insertPermisosSTablero);
                            }

                            $chkAccSubTab = array_values(array_sort($_POST['chkAccSubTab'], 'idAccSubTab', SORT_ASC));
                            foreach($chkAccSubTab as $value7)
                            {
                                extract($value7);
                                //GUARDAMOS EL PERMISO DE ACCION DE TABLERO
                                liberar_bd();
                                $insertPermisosAccionTablero = "CALL sp_sistema_insert_permiso_accion_tablero(".$idPerfil.", ".$idAccSubTab.")";
                                $insertPerAcciTab = consulta($insertPermisosAccionTablero);
                            }*/

                            //DATOS DEL PERFIL
                            liberar_bd();
                            $selectDatosPerfil = 'CALL sp_sistema_select_datos_perfil('.$idPerfil.');';
                            $datosPerfil = consulta($selectDatosPerfil);
                            $perf = siguiente_registro($datosPerfil);

                            $tipo = 'NO';
                            if($perf["tipo"] == 1)
                                $tipo = 'SI';


                            $newRow.= ' <tr id="'.$idPerfil.'">
                                            <td>'.utf8_convert($perf["nombre"]).'</td>
                                            <td>'.$tipo.'</td>
                                            <td>
                                                <div class="btn-group top-right-button-container" role="group">';
                                                    if($btnEdita)
                                                        $newRow.= ' <button type="button" class="btn btn-primary icon-button" title="Editar" onClick="formCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'edit\', '.$idPerfil.')">
                                                                        <i class="simple-icon-pencil"></i>
                                                                    </button> ';
                                                    if($btnElimina)
                                                        $newRow.= ' <button type="button" class="btn btn-danger icon-button" title="Eliminar" onClick="actionCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'delete\', '.$idPerfil.')">
                                                                       <i class="simple-icon-trash"></i>
                                                                    </button> ';
                            $newRow.= '	  	    </div>
                                            </td>
                                        </tr>';

                            $alert = 'Perfil agregado existosamente';
                        }
                        else
                        {
                            $valAction = "false";
                            $alert = 'No se pudo agregar el perfil';
                        }
                    }
                    else
                    {
                        $valAction = "false";
                        $alert = 'Ya existe un perfil con este nombre';
                    }
                break;
                case 'edit':
                    $idReturn = $idPerfil = $_POST["idElem"];

                    liberar_bd();
                    $selectPerfiles = "	SELECT * FROM _perfiles
	                                    WHERE nombre_perfil = '".utf8_desconvert($_POST['nombrePerfil'])."'
                                        AND id_perfil <> ".$idPerfil;

                    $perfiles = consulta($selectPerfiles);
                    $numPerfiles =  cuenta_registros($perfiles);
                    if($numPerfiles == 0)
                    {
                        liberar_bd();
                        $updatePerfiles = 'CALL sp_sistema_update_perfil(   "'.utf8_desconvert($_POST['nombrePerfil']).'",
                                                                            '.$_POST["isAdmin"].',
                                                                            '.$_POST["idElem"].');';
                        $updateP = consulta($updatePerfiles);

                        if($updateP)
                        {
                            liberar_bd();
                            $deletePermisosId = 'CALL sp_sistema_delete_permisos_modulos('.$_POST["idElem"].');';
                            $permisosId = consulta($deletePermisosId);

                            $idPerfil = $_POST["idElem"];

                            $chkMod = array_values(array_sort($_POST['chkMod'], 'idMod', SORT_ASC));
                            foreach($chkMod as $value)
                            {
                                extract($value);
                                //GUARDAMOS EL PERMISO DE MODULO
                                liberar_bd();
                                $insertPermisos = "CALL sp_sistema_insert_permiso_modulo(".$idPerfil.", ".$idMod.")";
                                $insertPer = consulta($insertPermisos);
                            }

                            $chkSubMod = array_values(array_sort($_POST['chkSubMod'], 'idSubMod', SORT_ASC));
                            foreach($chkSubMod as $value1)
                            {
                                extract($value1);
                                //GUARDAMOS EL PERMISO DE MODULO
                                liberar_bd();
                                $insertPermisos = "CALL sp_sistema_insert_permiso_modulo(".$idPerfil.", ".$idSubMod.")";
                                $insertPer = consulta($insertPermisos);
                            }

                            $chkSubSubMod = array_values(array_sort($_POST['chkSubSubMod'], 'idSubSubMod', SORT_ASC));
                            foreach($chkSubSubMod as $value2)
                            {
                                extract($value2);
                                //GUARDAMOS EL PERMISO DE MODULO
                                liberar_bd();
                                $insertPermisos = "CALL sp_sistema_insert_permiso_modulo(".$idPerfil.", ".$idSubSubMod.")";
                                $insertPer = consulta($insertPermisos);
                            }

                            $chkSubSubSubMod = array_values(array_sort($_POST['chkSubSubSubMod'], 'idSubSubSubMod', SORT_ASC));
                            foreach($chkSubSubSubMod as $value5)
                            {
                                extract($value5);
                                //GUARDAMOS EL PERMISO DE MODULO
                                liberar_bd();
                                $insertPermisos = "CALL sp_sistema_insert_permiso_modulo(".$idPerfil.", ".$idSubSubSubMod.")";
                                $insertPer = consulta($insertPermisos);
                            }

                            $chkAccSubSubMod = array_values(array_sort($_POST['chkAccSubSubMod'], 'idAccSubSubMod', SORT_ASC));
                            foreach($chkAccSubSubMod as $value3)
                            {
                                extract($value3);
                                //GUARDAMOS EL PERMISO DE ACCION
                                liberar_bd();
                                $insertPermisosAccion = "CALL sp_sistema_insert_permiso_accion(".$idPerfil.", ".$idAccSubSubMod.")";
                                $insertPerAcci = consulta($insertPermisosAccion);
                            }

                            $chkAccSubMod = array_values(array_sort($_POST['chkAccSubMod'], 'idAccSubMod', SORT_ASC));
                            foreach($chkAccSubMod as $value4)
                            {
                                extract($value4);
                                //GUARDAMOS EL PERMISO DE ACCION
                                liberar_bd();
                                $insertPermisosAccion = "CALL sp_sistema_insert_permiso_accion(".$idPerfil.", ".$idAccSubMod.")";
                                $insertPerAcci = consulta($insertPermisosAccion);
                            }

                            $chkAccSubSubSubMod = array_values(array_sort($_POST['chkAccSubSubSubMod'], 'idAccSubSubSubMod', SORT_ASC));
                            foreach($chkAccSubSubSubMod as $value6)
                            {
                                extract($value6);
                                //GUARDAMOS EL PERMISO DE ACCION
                                liberar_bd();
                                $insertPermisosAccion = "CALL sp_sistema_insert_permiso_accion(".$idPerfil.", ".$idAccSubSubSubMod.")";
                                $insertPerAcci = consulta($insertPermisosAccion);
                            }

                            /*$chkTab = array_values(array_sort($_POST['chkTab'], 'idTab', SORT_ASC));
                            foreach($chkTab as $value5)
                            {
                                extract($value5);
                                //GUARDAMOS EL PERMISO DE TABLERO
                                liberar_bd();
                                $insertPermisosTablero = "CALL sp_sistema_insert_permiso_tablero(".$idPerfil.", ".$idTab.")";
                                $insertPerTab = consulta($insertPermisosTablero);
                            }

                            $chkSubTab = array_values(array_sort($_POST['chkSubTab'], 'idSubTab', SORT_ASC));
                            foreach($chkSubTab as $value6)
                            {
                                extract($value6);
                                //GUARDAMOS EL PERMISO DE SUB TABLERO
                                liberar_bd();
                                $insertPermisosSTablero = "CALL sp_sistema_insert_permiso_tablero(".$idPerfil.", ".$idSubTab.")";
                                $insertPerSTab = consulta($insertPermisosSTablero);
                            }

                            $chkAccSubTab = array_values(array_sort($_POST['chkAccSubTab'], 'idAccSubTab', SORT_ASC));
                            foreach($chkAccSubTab as $value7)
                            {
                                extract($value7);
                                //GUARDAMOS EL PERMISO DE ACCION DE TABLERO
                                liberar_bd();
                                $insertPermisosAccionTablero = "CALL sp_sistema_insert_permiso_accion_tablero(".$idPerfil.", ".$idAccSubTab.")";
                                $insertPerAcciTab = consulta($insertPermisosAccionTablero);
                            }*/

                            //DATOS DEL PERFIL
                            liberar_bd();
                            $selectDatosPerfil = 'CALL sp_sistema_select_datos_perfil('.$idPerfil.');';
                            $datosPerfil = consulta($selectDatosPerfil);
                            $perf = siguiente_registro($datosPerfil);

                            $tipo = 'NO';
                            if($perf["tipo"] == 1)
                                $tipo = 'SI';

                            $newRow.= ' <tr id="'.$idPerfil.'">
                                            <td>'.utf8_convert($perf["nombre"]).'</td>
                                            <td>'.$tipo.'</td>
                                            <td>
                                                <div class="btn-group top-right-button-container" role="group">';
                                                    if($btnEdita)
                                                        $newRow.= ' <button type="button" class="btn btn-primary icon-button" title="Editar" onClick="formCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'edit\', '.$idPerfil.')">
                                                                        <i class="simple-icon-pencil"></i>
                                                                    </button> ';
                                                    if($btnElimina)
                                                        $newRow.= ' <button type="button" class="btn btn-danger icon-button" title="Eliminar" onClick="actionCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'delete\', '.$idPerfil.')">
                                                                       <i class="simple-icon-trash"></i>
                                                                    </button> ';
                            $newRow.= '	  	    </div>
                                            </td>
                                        </tr>';

                            $alert = 'Perfil actualizado existosamente';
                        }
                        else
                        {
                            $valAction = "false";
                            $alert = 'No se pudo actualizar el perfil';
                        }
                    }
                    else
                    {
                        $valAction = "false";
                        $alert = 'Ya existe un perfil con este nombre';
                    }
                break;
                case 'delete':
                    $idReturn = $idPerfil = $_POST["idElem"];

                    liberar_bd();
                    $deletePerfil = 'CALL sp_sistema_delete_perfil('.$_POST["idElem"].');';
                    $delete = consulta($deletePerfil);

                    if($delete)
                    {
                        $alert = 'Perfil eliminado existosamente';
                    }
                    else
                    {
                        $valAction = "false";
                        $alert = 'No se pudo eliminar el perfil';
                    }
                break;
            }
        break;
        case '11702':
            switch($_POST["action"])
            {
                case 'delete':
                    $idReturn = $idUser = $_POST["idElem"];

                    liberar_bd();
                    $sqlUpdateUsuario = "CALL sp_sistema_delete_usuario('".$idUser."');";
                    $updateUsuario = consulta($sqlUpdateUsuario);

                    if($updateUsuario)
                    {
                        $alert = 'Usuario eliminado existosamente';
                    }
                    else
                    {
                        $valAction = "false";
                        $alert = 'No se pudo eliminar el usuario';
                    }
                break;
            }
        break;
    }

    echo json_encode(array("valAction"=>$valAction, "alert"=>$alert, "idReturn"=>$idReturn, "txtReturn"=>$txtReturn, "newRow"=>$newRow, "newSubRow"=>$newSubRow));