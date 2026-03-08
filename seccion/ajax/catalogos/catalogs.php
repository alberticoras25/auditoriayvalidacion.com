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
        case '11601':
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

            liberar_bd();
            $selectCatalogos = 'SELECT
                                    catDoc.id_catalogo_documentos AS id,
                                    catDoc.titulo_catalogo_documentos AS titulo,
                                    catDoc.folio_catalogo_documentos AS folio,
                                    catDoc.txt_catalogo_documentos AS txt,
                                    catDoc.url_catalogo_documentos AS url,
                                    catDoc.estatus_catalogo_documentos AS estatus
                                FROM catalogo_documentos AS catDoc
                                WHERE catDoc.estatus_catalogo_documentos <> 0 ';

            $catalogos = consulta($selectCatalogos);

            $catalogo .= '  <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="data-table tableOrder table-striped nowrap">
                                            <thead>
                                                <tr>
                                                    <th>T&Iacute;TULO</th>
                                                    <th>FOLIO</th>
                                                    <th>QR</th>
                                                    <th>ACCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                            while($cat = siguiente_registro($catalogos))
                                            {
                                                $catalogo.= '   <tr id="'.$cat["id"].'">
                                                                    <td>'.utf8_convert($cat["titulo"]).'</td>
                                                                    <td>'.strtolower(utf8_convert($cat["folio"])).'</td>
                                                                    <td><button type="button" class="btn btn-primary mb-1 see_sidemenu_r_cat" title="Ver QR" onClick="muestra_page(\'myModalContent\', '.$_SESSION["mod"].', \'qr\', '.$cat["id"].')">Ver QR</button></td>
                                                                    <td>
                                                                        <div class="btn-group top-right-button-container" role="group">';
                                                                            if($btnEdita)
                                                                                $catalogo.= '   <button type="button" class="btn btn-primary icon-button" title="Editar" onClick="formCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'edit\', '.$cat["id"].')">
                                                                                                    <i class="simple-icon-pencil"></i>
                                                                                                </button> ';

                                                                            if($btnElimina)
                                                                                $catalogo.= '   <button type="button" class="btn btn-danger icon-button" title="Eliminar" onClick="actionCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'delete\', '.$cat["id"].')">
                                                                                                   <i class="simple-icon-trash"></i>
                                                                                                </button> ';

                                                $catalogo.= '           </div>
                                                                    </td>
                                                                </tr>';
                                            }
            $catalogo.= '			        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>';
        break;
    }

    echo json_encode(array("valCatalogo"=>$valCatalogo, "alert"=>$alert, "catalogo"=>$catalogo));