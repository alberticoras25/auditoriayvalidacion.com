<?php
    session_start();
    error_reporting(E_ERROR);
    include_once("../../../portal/motor/conexionSitio.php");
    include_once("../../../portal/motor/globales.php");
    conectarSistema();
    $valCatalogo = "true";
    $alert = '';
    $catalogo = '';

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

            liberar_bd();
            $selectCatalogos = 'SELECT
                                    correoNoti.id_correos_notificaciones AS id,
                                    correoNoti.value_correos_notificaciones AS valor,
                                    correoNoti.descripcion_correos_notificaciones AS txt
                                FROM correos_notificaciones AS correoNoti
                                WHERE correoNoti.estatus_correos_notificaciones <> 0';

            $catalogos = consulta($selectCatalogos);

            $catalogo = '   <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="data-table tableOrder table-striped nowrap">
                                            <thead>
                                                <tr>
                                                    <th>CORREO</th>
                                                    <th>DESCRIPCI&Oacute;N</th>
                                                    <th>ASIGNACIONES</th>
                                                    <th>ACCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                            while($cat = siguiente_registro($catalogos))
                                            {
                                                $tdCatalogo = '';
                                                //ASIGNACIONES DEL CORREO
                                                liberar_bd();
                                                $selectAsiganCorreo = 'CALL sp_sistema_select_asignaciones_correo('.$cat["id"].');';
                                                $asignaCorreo = consulta($selectAsiganCorreo);
                                                $ctaAsigna = cuenta_registros($asignaCorreo);
                                                if($ctaAsigna != 0)
                                                {
                                                    $tdCatalogo.= ' <div class="dropdown d-inline-block">
                                                                        <button class="btn btn-outline-primary dropdown-toggle mb-1" type="button"
                                                                            id="dropdownMenuButton'.$cat["id"].'" data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            Asignaciones
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton'.$cat["id"].'">';
                                                                            while($asiCo = siguiente_registro($asignaCorreo))
                                                                            {
                                                                                $tdCatalogo.= '<a class="dropdown-item" href="#">'.utf8_convert($asiCo["nombre"]).'</a>';
                                                                            }
                                                    $tdCatalogo.= '     </div>
                                                                    </div>';
                                                }

                                                $catalogo.= '   <tr id="'.$cat["id"].'">
                                                                    <td class="text-lowercase">'.utf8_convert($cat["valor"]).'</td>
                                                                    <td>'.utf8_convert($cat["txt"]).'</td>
                                                                    <td>'.$tdCatalogo.'</td>
                                                                    <td>
                                                                        <div class="btn-group top-right-button-container" role="group">';
                                                                            if($btnEdita)
                                                                                $catalogo.= ' <button type="button" class="btn btn-primary icon-button see_sidemenu_r_cat" title="Editar" onClick="muestra_page(\'myModalContent\', '.$_POST["catTipo"].', \'edit\', '.$cat["id"].')">
                                                                                                    <i class="simple-icon-pencil"></i>
                                                                                                </button> ';

                                                                            if($btnAsigna)
                                                                                $catalogo.= ' <button type="button" class="btn btn-dark icon-button" title="Asignar" onClick="formCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'assign\', '.$cat["id"].')">
                                                                                                    <i class="glyph-icon iconsminds-mail-link"></i>
                                                                                                </button> ';

                                                                            if($btnElimina)
                                                                                $catalogo.= ' <button type="button" class="btn btn-danger icon-button" title="Eliminar" onClick="actionCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'delete\', '.$cat["id"].')">
                                                                                                <i class="simple-icon-trash"></i>
                                                                                            </button> ';

                                                $catalogo.= '	  	    </div>
                                                                    </td>
                                                                </tr>';
                                            }
            $catalogo.= '                  </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>';
        break;
    }

    echo json_encode(array("valCatalogo"=>$valCatalogo, "alert"=>$alert, "catalogo"=>$catalogo));