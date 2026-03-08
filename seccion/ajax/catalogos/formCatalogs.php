<?php
    session_start();
    error_reporting(E_ERROR);
    include_once("../../../portal/motor/conexionSitio.php");
    include_once("../../../portal/motor/globales.php");
    conectarSistema();
    $valCatalogo = "true";
    $alert = $formulario = '';
    $idReturn = 0;

    switch($_POST["catTipo"])
    {
        case '11601':
            switch($_POST["form"])
            {
                case 'catalogo':
                    //PREMISOS DE ACCIONES
                    liberar_bd();
                    $selectPermisosAcciones = 'CALL sp_sistema_select_permisos_acciones_modulo('.$_SESSION["idPerfil"].', '.$_POST["catTipo"].');';
                    $permisosAcciones = consulta($selectPermisosAcciones);
                    while($acciones = siguiente_registro($permisosAcciones))
                    {
                        switch(utf8_convert($acciones["accion"]))
                        {
                            case 'Alta':$btnAlta = true;break;
                        }
                    }

                    $formulario = ' <div class="divFormCatalogo"></div>
                                    <div class="row divCatFil">
                                        <div class="col-12">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <div class="float-left">
                                                        <div class="d-inline-block">
                                                            <h5 class="d-inline font-weight-bold">Acciones</h5>
                                                        </div>
                                                    </div>
                                                    <div class="btn-group float-right">';

                                                        if($btnAlta)
                                                            $formulario.= '<button class="btn btn-primary ml-1 btn-sm mb-1" type="button" title="Nuevo documento" onclick="formCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'new\', 0)">
                                                                                Nuevo documento
                                                                            </button>';

                    $formulario.= '                 </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row divCatalogo"></div>';
                break;
                case 'new':
                case 'edit':
                    $file = '';
                    if($_POST["idElem"] != 0)
                    {
                        //DATOS DEL DOCUMENTO
                        liberar_bd();
                        $selectDocumento = 'CALL sp_sistema_select_datos_catalogo_documento_id('.$_POST["idElem"].');';
                        $documento = consulta($selectDocumento);
                        $doc = siguiente_registro($documento);
                        $titulo = utf8_convert($doc["titulo"]);
                        $folio = utf8_convert($doc["folio"]);
                        $txt = html_entity_decode($doc["txt"]);

                        if($doc["url"] != "")
                        {
                            $file = '   <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <div class="alert alert-warning alert-dismissable">
                                                    <i class="fa fa-warning pr10"></i>
                                                    <strong>No seleccionar archivo para no modificar</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="nombreProducto">Archivo Actual:</label>
                                                <iframe src="../mydocument.php?id='.$_POST["idElem"].'" style="width:100%; height:300px;" frameborder="0"></iframe>
                                            </div>
                                        </div>';
                        }
                    }

                    $formulario = ' <div class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-10">
                                                        <h5 class="mb-4 font-weight-bold">Datos del documento</h5>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="top-right-button-container">
                                                            <button type="button" class="close" aria-label="Close" onclick="actionCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'close\', '.$_POST["idElem"].')">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="nombreProducto">T&iacute;tulo:</label>
                                                        <input type="text" class="form-control" id="titulo" name="titulo" value="'.$titulo.'">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="nombreProducto">Folio:</label>
                                                        <input type="text" class="form-control" id="folio" name="folio" value="'.$folio.'">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="nombreProducto">Archivo:</label>
                                                        <div class="input-group mb-3">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="archivo">
                                                                <label class="custom-file-label" id="lblarchivo" for="archivo">Seleccionar archivo</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button title="Limpiar" type="button" class="btn btn-danger default" onclick="clearFile(\'archivo\', \'#\')"><span class="glyph-icon iconsminds-eraser-2"></span></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                '.$file.'
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="descripcion">Descripci&oacute;n:</label>
                                                        <div class="html-editor" id="descripcion" name="descripcion">'.$txt.'</div>
                                                    </div>
                                                </div>
                                                <div class="btn-toolbar justify-content-end">
                                                    <button type="button" class="btn btn-dark d-block mt-3" onClick="actionCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \''.$_POST["form"].'\', '.$_POST["idElem"].')">Guardar</button>
                                                    <button type="button" class="btn btn-danger d-block mt-3 ml-3" onclick="actionCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'close\', '.$_POST["idElem"].')">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                break;
            }
        break;
    }

    echo json_encode(array("valCatalogo"=>$valCatalogo, "alert"=>$alert, "formulario"=>$formulario));