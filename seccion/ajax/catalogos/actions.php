<?php
    session_start();
    error_reporting(E_ERROR);
    include_once("../../../portal/motor/conexionSitio.php");
    include_once("../../../portal/motor/globales.php");
    conectarSistema();
    $valAction = "true";
    $newRow = $newSubRow = $alert = $txtReturn = '';
    $idReturn = 0;

    switch($_POST["catTipo"])
    {
        case '11601':
            $server = $_SERVER['SERVER_NAME'];
            if($server == "localhost")
                $txtBase = '/proyectos/valaudita/';
            else
                $txtBase = 'https://validacionyauditoria.com/';

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
                    $valFolio = true;
                    if($_POST["folio"] != "")
                    {
                        //CHECAMOS FOLIO EXISTENTE
                        liberar_bd();
                        $selectFolioExist = 'CALL sp_sistema_select_cat_doc_folio("'.utf8_desconvert(strtolower($_POST["folio"])).'")';
                        $folioExist = consulta($selectFolioExist);
                        $ctaFolioExist = cuenta_registros($folioExist);
                        if($ctaFolioExist != 0)
                        {
                            $valAction = "false";
                            $alert = 'Ya existe un documento con este folio.';
                            $valFolio = false;
                        }
                    }

                    if($valFolio)
                    {
                        include('../../../clases/phpqrcode/qrlib.php');
                        $codeFile = date("YmdHis").'.png';
                        $codesDir = "../../../portal/imagenes/qr/".$codeFile;
                        $src = '';

                        if(isset($_FILES['archivo']))
                        {
                            //GUARDAMOS EL DOCUMENTO
                            $ext = explode(".", $_FILES["archivo"]["name"]);
                            $src = date("YmdHis").".".end($ext);
                            $ruta = "../../../portal/imagenes/documentos/".$src;
                            move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta);
                        }

                        //INSERTAMOS EL DOCUMENTO
                        liberar_bd();
                        $insertDocumento = 'CALL sp_sistema_insert_catalogo_documentos( "'.utf8_desconvert($_POST["titulo"]).'",
                                                                                        "'.strtolower(utf8_desconvert($_POST["folio"])).'",
                                                                                        "'.htmlentities($_POST["descripcion"]).'",
                                                                                        "'.$src.'", "'.$codeFile.'", '.$_SESSION["idUser"].');';
                        $insertDoc = consulta($insertDocumento);

                        if($insertDoc)
                        {
                            $doc = siguiente_registro($insertDoc);
                            $idReturn = $idCatAdm = $doc["idCat"];

                            QRcode::png($txtBase."index.php?folio=".strtolower($_POST["folio"]), $codesDir, "H", "10");

                            $valReturn = true;
                            $alert = "Documento guardado exitosamente";
                        }
                        else
                    {
                        $valAction = "false";
                        $alert = "No se guardó el documento";
                    }
                    }
                break;
                case 'edit':
                    $valFolio = true;

                    if($_POST["folio"] != "")
                    {
                        //CHECAMOS FOLIO EXISTENTE
                        liberar_bd();
                        $selectFolioExist = 'CALL sp_sistema_select_cat_doc_folio_id(   '.$_POST["idElem"].',
                                                                                        "'.utf8_desconvert(strtolower($_POST["folio"])).'")';
                        $folioExist = consulta($selectFolioExist);
                        $ctaFolioExist = cuenta_registros($folioExist);
                        if($ctaFolioExist != 0)
                        {
                            $valAction = "false";
                            $alert = 'Ya existe un documento con este folio.';
                            $valFolio = false;
                        }
                    }

                    if($valFolio)
                    {
                        $idReturn = $idCatAdm = $_POST["idElem"];

                        //DATOS DEL DOCUMENTO
                        liberar_bd();
                        $selectDocumento = 'CALL sp_sistema_select_datos_catalogo_documento_id('.$idCatAdm.');';
                        $documento = consulta($selectDocumento);
                        $doc = siguiente_registro($documento);
                        $src = $doc["url"];
                        $qr = '../../../portal/imagenes/qr/'.$doc["qr"];

                        if(isset($_FILES['archivo']))
                        {
                            //GUARDAMOS EL DOCUMENTO
                            $ext = explode(".", $_FILES["archivo"]["name"]);
                            $src = date("YmdHis") . "." . end($ext);
                            $ruta = "../../../portal/imagenes/documentos/".$src;
                            move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta);
                        }

                        //EDITAMOS EL DOCUMENTO
                        liberar_bd();
                        $updateDocumento = 'CALL sp_sistema_update_catalogo_documentos( '.$idCatAdm.',
                                                                                        "'.utf8_desconvert($_POST["titulo"]).'",
                                                                                        "'.strtolower(utf8_desconvert($_POST["folio"])).'",
                                                                                        "'.htmlentities($_POST["descripcion"]).'",
                                                                                        "'.$src.'", '.$_SESSION["idUser"].');';
                        $updateDoc = consulta($updateDocumento);

                        if($updateDoc)
                        {
                            include('../../../clases/phpqrcode/qrlib.php');
                            $codeFile = date("YmdHis").'.png';
                            $codesDir = "../../../portal/imagenes/qr/".$codeFile;

                            $valReturn = true;
                            $alert = "Documento editado exitosamente";

                            //ACTUALIZAMOS EL QR
                            liberar_bd();
                            $updateQr = 'CALL sp_sistema_update_qr_catalogo_documento('.$idCatAdm.', "'.$codeFile.'", '.$_SESSION["idUser"].');';
                            $updQr = consulta($updateQr);
                            if($updQr)
                            {
                                unlink($qr);
                                QRcode::png($txtBase."index.php?folio=".strtolower($_POST["folio"]), $codesDir, "H", "10");
                            }
                        }
                        else
                        {
                            $valAction = "false";
                            $alert = "No se editó el documento";
                        }
                    }
                break;
                case 'delete':
                    $idReturn = $idCatAdm = $_POST["idElem"];

                    //CAMBIAMOS DE ESTATUS DEL DOCUMENTO
                    liberar_bd();
                    $updateStsCatDoc = 'CALL sp_sistema_update_estatus_cat_doc('.$idCatAdm.', 0, '.$_SESSION["idUser"].');';
                    $sqlAction = consulta($updateStsCatDoc);

                    if($sqlAction)
                    {
                        $valReturn = true;
                        $alert = "Documento eliminado exitosamente";
                    }
                    else
                    {
                        $valAction = "false";
                        $alert = "No se eliminó el documento";
                    }
                break;
            }

            if($valReturn)
            {
                //DATOS DEL DOCUMENTO
                liberar_bd();
                $selectDatosDocumento = 'CALL sp_sistema_select_datos_catalogo_documento_id('.$idCatAdm.');';
                $datosDocumento = consulta($selectDatosDocumento);
                $cat = siguiente_registro($datosDocumento);

                $newRow.= ' <tr id="'.$idCatAdm.'">
                                <td>'.utf8_convert($cat["titulo"]).'</td>
                                <td>'.strtolower(utf8_convert($cat["folio"])).'</td>
                                <td><button type="button" class="btn btn-primary mb-1 see_sidemenu_r_cat" title="Ver QR" onClick="muestra_page(\'myModalContent\', '.$_SESSION["mod"].', \'qr\', '.$idCatAdm.')">Ver QR</button></td>
                                <td>
                                    <div class="btn-group top-right-button-container" role="group">';
                                        if($btnEdita)
                                            $newRow.= ' <button type="button" class="btn btn-primary icon-button" title="Editar" onClick="formCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'edit\', '.$idCatAdm.')">
                                                            <i class="simple-icon-pencil"></i>
                                                        </button> ';

                                        if($btnElimina)
                                            $newRow.= ' <button type="button" class="btn btn-danger icon-button" title="Eliminar" onClick="actionCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'delete\', '.$idCatAdm.')">
                                                           <i class="simple-icon-trash"></i>
                                                        </button> ';

                $newRow.= '         </div>
                                </td>
                            </tr>';
            }
        break;
    }

    echo json_encode(array("valAction"=>$valAction, "alert"=>$alert, "idReturn"=>$idReturn, "txtReturn"=>$txtReturn, "newRow"=>$newRow, "newSubRow"=>$newSubRow));