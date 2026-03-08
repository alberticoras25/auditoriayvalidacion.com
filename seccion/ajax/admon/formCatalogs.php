<?php
    session_start();
    error_reporting(E_ERROR);
    include_once("../../../portal/motor/conexionSitio.php");
    include_once("../../../portal/motor/globales.php");
    conectarSistema();
    $valCatalogo = "true";
    $alert = $formulario = '';

    switch($_POST["catTipo"])
    {
        case '11704':
            switch($_POST["form"])
            {
                case 'assign':
                    $arrayAsigna = array();
                    //DATOS DEL CORREO
                    liberar_bd();
                    $selectDatosCorreo = 'CALL sp_sistema_select_datos_correo_asignar('.$_POST["idElem"].');';
                    $datosCorreo = consulta($selectDatosCorreo);
                    $datCo = siguiente_registro($datosCorreo);

                    //ASIGNACIONES DEL CORREO
                    liberar_bd();
                    $selectAsiganCorreo = 'CALL sp_sistema_select_asignaciones_correo('.$_POST["idElem"].');';
                    $asignaCorreo = consulta($selectAsiganCorreo);
                    while($asiCo = siguiente_registro($asignaCorreo))
                    {
                        array_push($arrayAsigna, $asiCo["idConf"]);
                    }

                    //LISTA DE NOTIFICACIONES
                    liberar_bd();
                    $selectListaNotificaciones = 'CALL sp_sistema_select_lista_notificaciones_correo();';
                    $listaNotificaciones = consulta($selectListaNotificaciones);
                    while($notif = siguiente_registro($listaNotificaciones))
                    {
                        $checkedNoti1 = $checkedNoti0 = '';
                        if(in_array($notif["id"], $arrayAsigna))
                            $checkedNoti1 = 'checked';
                        else
                            $checkedNoti0 = 'checked';

                        $divNotificaciones.= '  <div class="form-group col-md-3">
                                                    <label for="chkNoti'.$notif["id"].'">'.utf8_convert($notif["nombre"]).'</label>
                                                    <div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" '.$checkedNoti1.' data-idconf="'.$notif["id"].'" name="chkNoti'.$notif["id"].'" id="chkNoti'.$notif["id"].'1" value="1" class="custom-control-input chkNoti">
                                                            <label class="custom-control-label" for="chkNoti'.$notif["id"].'1">Si</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" '.$checkedNoti0.' data-idconf="'.$notif["id"].'" name="chkNoti'.$notif["id"].'" id="chkNoti'.$notif["id"].'0" value="0" class="custom-control-input chkNoti">
                                                            <label class="custom-control-label" for="chkNoti'.$notif["id"].'0">No</label>
                                                        </div>
                                                    </div>
                                                </div>';
                    }

                    $formulario = ' <div class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-10">
                                                        <h5 class="mb-2 font-weight-bold">Asignaci&oacute;n de correo</h5>
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
                                                    <div class="col-md-4">
                                                        <div class="mb-4">
                                                            <p class="font-weight-medium mb-0 ">Correo:</p>
                                                            <p class="text-muted mb-0"><strong>'.utf8_convert($datCo["valor"]).'</strong></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-4">
                                                            <p class="font-weight-medium mb-0 ">Descripci&oacute;n:</p>
                                                            <p class="text-muted mb-0"><strong>'.utf8_convert($datCo["txt"]).'</strong></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="separator mt-5 mb-3"></div>
                                                <div class="row mb-2">
                                                    <div class="col-12">
                                                        <h5 class="mb-2 font-weight-bold">Asignaciones</h5>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    '.$divNotificaciones.'
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