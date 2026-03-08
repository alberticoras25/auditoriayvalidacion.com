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
        case '10001':
            switch($_POST["form"])
            {
                case 'edit':
                    //DATOS USUARIO
                    liberar_bd();
                    $selectDatUsuario='CALL sp_sistema_select_datos_usuario('.$_SESSION["idUser"].');';
                    $datUsuario = consulta($selectDatUsuario);
                    $ctaDatUsuario  =cuenta_registros($datUsuario);
                    if($ctaDatUsuario == 0)
                    {
                        //INSERTAMOS NUEVOS DATOS DEFAULT USUARIO
                        liberar_bd();
                        $insertDatosUsuario = 'CALL sp_sistema_insert_datos_usuario('.$_SESSION["idUser"].', "'.currentDateComplate().'");';
                        $insertDatUser = consulta($insertDatosUsuario);

                        //DATOS USUARIO
                        liberar_bd();
                        $selectDatUsuario='CALL sp_sistema_select_datos_usuario('.$_SESSION["idUser"].');';
                        $datUsuario = consulta($selectDatUsuario);
                    }

                    $usu = siguiente_registro($datUsuario);

                    //DATOS GENERALES
                    liberar_bd();
                    $selectPerfil='CALL sp_sistema_select_datos_mi_perfil('.$_SESSION["idUser"].');';
                    $perfil = consulta($selectPerfil);
                    $per = siguiente_registro($perfil);

                    $nombre = utf8_convert($per["nombre"]);
                    $usuario = utf8_convert($per["login"]);
                    $email = utf8_convert($usu["correo"]);
                    $telefono = $usu["telefono"];
                    $calle = utf8_convert($usu["calle"]);
                    $numExt = utf8_convert($usu["numExt"]);
                    $numInt = utf8_convert($usu["numInt"]);
                    $colonia = utf8_convert($usu["colonia"]);
                    $cp = $usu["cp"];
                    $fechaNat = normalize_date_filtro($usu["cumple"]);
                    if($usu["cumple"] == "0000-00-00")
                        $fechaNat = date("d/m/Y");

                    $formulario = ' <div class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-10">
                                                        <h5 class="mb-4 font-weight-bold">Datos generales</h5>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="top-right-button-container"></div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="nombre">Nombre:</label>
                                                        <input type="text" class="form-control" id="nombre" name="nombre" value="'.$nombre.'">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="usuario">Usuario:</label>
                                                        <input type="text" class="form-control" id="usuario" name="usuario" value="'.$usuario.'">
                                                    </div>
                                                </div>
                                                <div class="alert alert-warning alert-dismissable">
                                                    <i class="fa fa-warning pr10"></i>
                                                    <strong>Dejar ambos campos en blanco para no modificar la contrase&ntilde;a</strong>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="pass">Contrase&ntilde;a</label>
                                                        <input type="password" class="form-control inpCont" id="pass" name="pass">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="pass2">Repetir Contrase&ntilde;a</label>
                                                        <input type="password" class="form-control inpCont" id="pass2" name="pass2">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="email">Correo</label>
                                                        <input style="text-transform: lowercase !important;" type="text" class="form-control" id="email" name="email" value="'.$email.'">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="telefono">Tel&eacute;fono:</label>
                                                        <input type="text" class="form-control" id="telefono" name="telefono" value="'.$telefono.'">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="calle">Calle:</label>
                                                        <input type="text" class="form-control" id="calle" name="calle" value="'.$calle.'">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="numExt">N&uacute;m Ext:</label>
                                                        <input type="text" class="form-control" id="numExt" name="numExt" value="'.$numExt.'">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="numInt">N&uacute;m Int:</label>
                                                        <input type="text" class="form-control" id="numInt" name="numInt" value="'.$numInt.'">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="colonia">Colonia:</label>
                                                        <input type="text" class="form-control" id="telefono" name="colonia" value="'.$colonia.'">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="cp">CP:</label>
                                                        <input type="text" class="form-control classGralNum" id="cp" name="cp" value="'.$cp.'">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="fechaNat">Fecha de nacimiento:</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control fechaNat" id="fechaNat" name="fechaNat" value="'.$fechaNat.'">
                                                            <span class="input-group-text input-group-append input-group-addon">
                                                                <i class="simple-icon-calendar"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="btn-toolbar justify-content-end">
                                                    <button type="button" class="btn btn-dark default d-block mt-3" onClick="actionCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \''.$_POST["form"].'\', '.$_SESSION["idUser"].')">Guardar</button>
                                                    <!--<button type="button" class="btn btn-danger d-block mt-3 ml-3">Cancelar</button>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                break;
            }
        break;
        case '10002':
            switch($_POST["form"])
            {
                case 'edit':
                    $btnSave = true;
                    switch($_POST["idElem"])
                    {
                        case 8:
                            $divNotificaciones = '';

                            //LISTA DE NOTIFICACIONES
                            liberar_bd();
                            $selectListaNotificaciones = 'CALL sp_sistema_select_lista_notificaciones_correo();';
                            $listaNotificaciones = consulta($selectListaNotificaciones);
                            while($notif = siguiente_registro($listaNotificaciones))
                            {
                                $divNotificaciones.= '  <label class="form-group has-float-label col-md-4">
                                                            <input type="text" class="form-control classGralNum confiLim" data-idconf="'.$notif["id"].'" id="confiLim'.$notif["id"].'" name="confiLim'.$notif["id"].'" value="'.$notif["dias"].'">
                                                            <span>'.utf8_convert($notif["nombre"]).'</span>
                                                        </label>';
                            }

                            $txtFormulario = '  <div class="row mb-2">
                                                    <div class="col-10">
                                                        <h5 class="mb-4 font-weight-bold">D&iacute;as de expiraci&oacute;n de notificaci&oacute;n por correo</h5>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="top-right-button-container">
                                                            <button type="button" class="close" aria-label="Close" onclick="actionCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'close\', '.$_POST["idElem"].')">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">'.$divNotificaciones.'</div>';

                        break;
                    }

                    $formulario = ' <div class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                '.$txtFormulario.'
                                                <div class="btn-toolbar justify-content-end">';
                                                    if($btnSave)
                                                        $formulario.= '<button type="button" class="btn btn-dark d-block mt-3" onClick="actionCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \''.$_POST["form"].'\', '.$_POST["idElem"].')">Guardar</button>';
                    $formulario.= '            </div>
                                            </div>
                                        </div>
                                    </div>';
                break;
            }
        break;
        case '11702':
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

                    //LISTA DE PERFILES
                    $optPerf = '';
                    liberar_bd();
                    $selectPerfiles = "CALL sp_sistema_lista_perfiles();";
                    $perfiles = consulta($selectPerfiles);
                    while($per = siguiente_registro($perfiles))
                    {
                        $optPerf .= '<option value="'.$per["id"].'">'.utf8_convert($per["nombre"]).'</option>';
                    }

                    $formulario = ' <div class="divFormCatalogo"></div>
                                    <div class="row divCatFil">
                                        <div class="col-12">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <div class="float-left">
                                                        <div class="d-inline-block">
                                                            <h5 class="d-inline font-weight-bold">Acciones/Filtro</h5>
                                                        </div>
                                                    </div>
                                                    <div class="btn-group float-right">';

                                                        if($btnAlta)
                                                            $formulario.= '<button class="btn btn-primary ml-1 mb-1 see_sidemenu_r" type="button" title="Nuevo Usuario" onclick="muestra_page(\'myModalContent\', '.$_POST["catTipo"].', \'new\', 0)">
                                                                                Nuevo Usuario
                                                                            </button>';

                    $formulario.= '                     <button type="button" class="btn btn-outline-primary mb-1 " data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
                                                            <span aria-hidden="true"><i class="iconsminds-filter-2"></i></span>
                                                        </button>
                                                    </div>
                                                    <div class="pt-5 collapse" id="collapseFilter">
                                                        <div class="p-4 border mt-4">
                                                            <div class="form-row">
                                                                <label class="form-group has-float-label col-md-3">
                                                                    <select id="idPerfilFil" name="idPerfilFil" class="form-control" multiple="multiple" data-style="btn-secondary">
                                                                        '.$optPerf.'
                                                                    </select>
                                                                    <span>Perfiles</span>
                                                                </label>
                                                            </div>
                                                            <div class="btn-toolbar justify-content-end">
                                                                <button type="button" class="btn btn-dark d-block mt-3" onclick="cargaCatalogo(\'divCatalogo\', '.$_POST["catTipo"].', 0)">Buscar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row divCatalogo"></div>';
                break;
            }
        break;
        case '11701':
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

                    $formulario = ' <div class="row divFormCatalogo"></div>
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
                                                            $formulario.= '<button class="btn btn-primary mb-1 " type="button" title="Nuevo Perfil" onclick="formCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'new\', 0)">
                                                                                Nuevo Perfil
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
                    if($_POST["idElem"] != 0)
                    {
                        $idPerfil = $_POST["idElem"];
                        //DATOS DEL PERFIL
                        liberar_bd();
                        $selectDatosPerfil = 'CALL sp_sistema_select_datos_perfil('.$_POST['idElem'].');';
                        $datosPerfil = consulta($selectDatosPerfil);
                        $datPer = siguiente_registro($datosPerfil);
                        $nombrePerfil =  utf8_convert($datPer['nombre']);

                        if($datPer["tipo"] == 0)
                            $chkAdmin1 = 'checked';
                        else
                            $chkAdmin2 = 'checked';
                    }
                    else
                    {
                        $idPerfil = '';
                        $chkAdmin1 = 'checked';
                    }

                    //SECCIONES
                    liberar_bd();
                    $selectModulosPadre = 'CALL sp_sistema_select_lista_modulos_padre();';
                    $modulosPadre = consulta($selectModulosPadre);

                    // REVISAR LOS PERMISOS CONCEDIDOS
                    liberar_bd();
                    $selectPermisosModulos = 'CALL sp_sistema_select_permisos_modulos('.$idPerfil.');';
                    $permisosModulos = consulta($selectPermisosModulos);

                    //PREMISOS DE ACCIONES
                    liberar_bd();
                    $selectPermisosAcciones = 'CALL sp_sistema_select_permisos_acciones('.$idPerfil.')';
                    $permisosAcciones = consulta($selectPermisosAcciones);

                    $divPermisos = '';
                    while($modulo = siguiente_registro($modulosPadre))
                    {
                        $checkedParent = '';
                        while($p = siguiente_registro($permisosModulos))
                        {
                            if($p["id_modulo"] == $modulo["id_modulo"])
                                $checkedParent = ' checked="checked" ';
                        }
                        mysqli_data_seek($permisosModulos,0);

                        $divPermisos.='	<div class="col-lg-6 col-sm-12 mb-4">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <div class="float-left">
                                                        <div class="d-inline-block">
                                                            <h6 class="d-inline font-weight-bold color-theme-1">
                                                                <input class="inpMod" '.$checkedParent.' data-tipo="1" type="checkbox" name="modulo_'.$modulo['id_modulo'].'" id="modulo_'.$modulo['id_modulo'].'" onclick="checar_submodulos(this);" value="ok">
                                                                '.utf8_convert($modulo['nombre_modulo']).'
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="btn-group float-right">
                                                        <button type="button" class="btn btn-outline-primary mb-1 " data-toggle="collapse" data-target="#collapsein'.$modulo['id_modulo'].'" aria-expanded="false" aria-controls="collapsein'.$modulo['id_modulo'].'">
                                                            <span aria-hidden="true"><i class="simple-icon-arrow-down"></i></span>
                                                        </button>
                                                    </div>
                                                    <div class="pt-5 collapse" id="collapsein'.$modulo['id_modulo'].'">
                                                        <div class="scroll divPermisos">';
                                                            //SUBMODULOS HIJO
                                                            liberar_bd();
                                                            $selectModulosHijo = 'CALL sp_sistema_select_modulos_hijo('.$modulo["id_modulo"].')';
                                                            $modulosHijo = consulta($selectModulosHijo);

                                                            while($subMod = siguiente_registro($modulosHijo))
                                                            {
                                                                $checkedSon = '';
                                                                while($p = siguiente_registro($permisosModulos))
                                                                {
                                                                    if($p["id_modulo"] == $subMod["id_modulo"])
                                                                        $checkedSon = ' checked="checked" ';
                                                                }
                                                                mysqli_data_seek($permisosModulos,0);

                                                                $divPermisos.= '<div class="card mb-4">
                                                                                    <div class="card-body">
                                                                                        <div class="float-left">
                                                                                            <div class="d-inline-block">
                                                                                                <h6 class="d-inline font-weight-bold color-theme-2">
                                                                                                    <input class="inpMod" data-tipo="2" '.$checkedSon.' type="checkbox" name="modulo_'.$subMod['id_modulo'].'" id="modulo_'.$modulo['id_modulo'].'_'.$subMod['id_modulo'].'" onclick="checa_padre(this);" value="ok">
                                                                                                    '.utf8_convert($subMod['nombre_modulo']).'
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>';
                                                                                        //CHECAMOS SI TIENE NIETOS
                                                                                        liberar_bd();
                                                                                        $selectModulosNietos = 'CALL sp_sistema_select_modulos_hijo('.$subMod["id_modulo"].')';
                                                                                        $modulosNietos = consulta($selectModulosNietos);
                                                                                        $ctaModulosNietos = cuenta_registros($modulosNietos);

                                                                                        if($ctaModulosNietos != 0)
                                                                                        {
                                                                                            $divPermisos.= '<div class="btn-group float-right">
                                                                                                                <button type="button" class="btn btn-outline-warning mb-1 " data-toggle="collapse" data-target="#collapsein'.$subMod['id_modulo'].'" aria-expanded="false" aria-controls="collapsein'.$subMod['id_modulo'].'">
                                                                                                                    <span aria-hidden="true"><i class="simple-icon-arrow-down"></i></span>
                                                                                                                </button>
                                                                                                            </div>
                                                                                                            <div class="pt-5 collapse" id="collapsein'.$subMod['id_modulo'].'">';
                                                                                                                while($nietoMod = siguiente_registro($modulosNietos))
                                                                                                                {
                                                                                                                    $checkedParent = '';
                                                                                                                    while($p = siguiente_registro($permisosModulos))
                                                                                                                    {
                                                                                                                        if($p["id_modulo"] == $nietoMod["id_modulo"])
                                                                                                                            $checkedParent = ' checked="checked" ';
                                                                                                                    }
                                                                                                                    mysqli_data_seek($permisosModulos,0);

                                                                                                                    $divPermisos.=' <div class="card mb-4">
                                                                                                                                        <div class="card-body">
                                                                                                                                            <div class="float-left">
                                                                                                                                                <div class="d-inline-block">
                                                                                                                                                    <h7 class="d-inline font-weight-bold color-theme-3">
                                                                                                                                                        <input class="inpMod" data-tipo="3" '.$checkedParent.' type="checkbox" name="modulo_'.$nietoMod['id_modulo'].'" id="modulo_'.$modulo['id_modulo'].'_'.$subMod['id_modulo'].'_'.$nietoMod['id_modulo'].'" onclick="checa_padre(this);" value="ok">
                                                                                                                                                        '.utf8_convert($nietoMod['nombre_modulo']).'
                                                                                                                                                    </h7>
                                                                                                                                                </div>
                                                                                                                                            </div>';
                                                                                                                                            //ACCIONES DEL MODULO
                                                                                                                                            liberar_bd();
                                                                                                                                            $selectAccionesModulo = 'CALL sp_sistem_select_acciones_modulo('.$nietoMod["id_modulo"].');';
                                                                                                                                            $accionesModulo = consulta($selectAccionesModulo);
                                                                                                                                            $ctaAccionesModulo = cuenta_registros($accionesModulo);
                                                                                                                                            if($ctaAccionesModulo != 0)
                                                                                                                                            {
                                                                                                                                                $divPermisos.= '<div class="btn-group float-right">
                                                                                                                                                                    <button type="button" class="btn btn-outline-danger mb-1 " data-toggle="collapse" data-target="#collapseiny'.$nietoMod['id_modulo'].'" aria-expanded="false" aria-controls="collapseiny'.$nietoMod['id_modulo'].'">
                                                                                                                                                                        <span aria-hidden="true"><i class="simple-icon-arrow-down"></i></span>
                                                                                                                                                                    </button>
                                                                                                                                                                </div>
                                                                                                                                                                <div class="pt-5 collapse" id="collapseiny'.$nietoMod['id_modulo'].'">';
                                                                                                                                                                while($acciones = siguiente_registro($accionesModulo))
                                                                                                                                                                {
                                                                                                                                                                    $checkedAccion = '';
                                                                                                                                                                    while($pA = siguiente_registro($permisosAcciones))
                                                                                                                                                                    {
                                                                                                                                                                        if($pA["id_acciones"] == $acciones["id_acciones"])
                                                                                                                                                                            $checkedAccion = ' checked="checked" ';
                                                                                                                                                                    }
                                                                                                                                                                    mysqli_data_seek($permisosAcciones,0);

                                                                                                                                                                    $divPermisos.='<div class="d-flex flex-row mb-3 pb-3 border-bottom color-theme-5">
                                                                                                                                                                                      <input class="inpMod" data-tipo="4" '.$checkedAccion.' type="checkbox" name="accion_'.$acciones['id_acciones'].'" id="modulo_'.$modulo['id_modulo'].'_'.$subMod['id_modulo'].'_'.$nietoMod['id_modulo'].'_'.$acciones['id_acciones'].'" value="ok" onclick="checa_padre(this);">
                                                                                                                                                                                      <span class="pl-3">'.utf8_convert($acciones['nombre_acciones']).'</span>
                                                                                                                                                                                   </div>';
                                                                                                                                                                }
                                                                                                                                                $divPermisos.= '</div>';
                                                                                                                                            }
                                                                                                                                            else
                                                                                                                                            {
                                                                                                                                                //CHECAMOS SI TIENE BISNIETOS
                                                                                                                                                liberar_bd();
                                                                                                                                                $selectModulosBisNietos = 'CALL sp_sistema_select_modulos_hijo('.$nietoMod["id_modulo"].')';
                                                                                                                                                $modulosBisNietos = consulta($selectModulosBisNietos);
                                                                                                                                                $ctaModulosBisNietos = cuenta_registros($modulosBisNietos);

                                                                                                                                                if($ctaModulosBisNietos != 0)
                                                                                                                                                {
                                                                                                                                                    $divPermisos.= '<div class="btn-group float-right">
                                                                                                                                                                        <button type="button" class="btn btn-outline-danger mb-1 " data-toggle="collapse" data-target="#collapsein'.$nietoMod['id_modulo'].'" aria-expanded="false" aria-controls="collapsein'.$nietoMod['id_modulo'].'">
                                                                                                                                                                            <span aria-hidden="true"><i class="simple-icon-arrow-down"></i></span>
                                                                                                                                                                        </button>
                                                                                                                                                                    </div>
                                                                                                                                                                    <div class="pt-5 collapse" id="collapsein'.$nietoMod['id_modulo'].'">';
                                                                                                                                                                        while($bisNietoMod = siguiente_registro($modulosBisNietos))
                                                                                                                                                                        {
                                                                                                                                                                            $checkedParent = '';
                                                                                                                                                                            while($p = siguiente_registro($permisosModulos))
                                                                                                                                                                            {
                                                                                                                                                                                if($p["id_modulo"] == $bisNietoMod["id_modulo"])
                                                                                                                                                                                    $checkedParent = ' checked="checked" ';
                                                                                                                                                                            }
                                                                                                                                                                            mysqli_data_seek($permisosModulos,0);

                                                                                                                                                                            $divPermisos.=' <div class="card mb-4">
                                                                                                                                                                                                <div class="card-body">
                                                                                                                                                                                                    <div class="float-left">
                                                                                                                                                                                                        <div class="d-inline-block">
                                                                                                                                                                                                            <h7 class="d-inline font-weight-bold color-theme-4">
                                                                                                                                                                                                                <input class="inpMod" data-tipo="9" '.$checkedParent.' type="checkbox" name="modulo_'.$bisNietoMod['id_modulo'].'" id="modulo_'.$modulo['id_modulo'].'_'.$subMod['id_modulo'].'_'.$nietoMod['id_modulo'].'_'.$bisNietoMod['id_modulo'].'" onclick="checa_padre(this);" value="ok">
                                                                                                                                                                                                                '.utf8_convert($bisNietoMod['nombre_modulo']).'
                                                                                                                                                                                                            </h7>
                                                                                                                                                                                                        </div>
                                                                                                                                                                                                    </div>';
                                                                                                                                                                                                    //ACCIONES DEL MODULO
                                                                                                                                                                                                    liberar_bd();
                                                                                                                                                                                                    $selectAccionesModulo = 'CALL sp_sistem_select_acciones_modulo('.$bisNietoMod["id_modulo"].');';
                                                                                                                                                                                                    $accionesModulo = consulta($selectAccionesModulo);
                                                                                                                                                                                                    $ctaAccionesModulo = cuenta_registros($accionesModulo);
                                                                                                                                                                                                    if($ctaAccionesModulo != 0)
                                                                                                                                                                                                    {
                                                                                                                                                                                                        $divPermisos.= '<div class="btn-group float-right">
                                                                                                                                                                                                                            <button type="button" class="btn btn-outline-info mb-1 " data-toggle="collapse" data-target="#collapseiny'.$bisNietoMod['id_modulo'].'" aria-expanded="false" aria-controls="collapseiny'.$bisNietoMod['id_modulo'].'">
                                                                                                                                                                                                                                <span aria-hidden="true"><i class="simple-icon-arrow-down"></i></span>
                                                                                                                                                                                                                            </button>
                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                        <div class="pt-5 collapse" id="collapseiny'.$bisNietoMod['id_modulo'].'">';
                                                                                                                                                                                                                        while($acciones = siguiente_registro($accionesModulo))
                                                                                                                                                                                                                        {
                                                                                                                                                                                                                            $checkedAccion = '';
                                                                                                                                                                                                                            while($pA = siguiente_registro($permisosAcciones))
                                                                                                                                                                                                                            {
                                                                                                                                                                                                                                if($pA["id_acciones"] == $acciones["id_acciones"])
                                                                                                                                                                                                                                    $checkedAccion = ' checked="checked" ';
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                            mysqli_data_seek($permisosAcciones,0);

                                                                                                                                                                                                                            $divPermisos.='<div class="d-flex flex-row mb-3 pb-3 border-bottom color-theme-5">
                                                                                                                                                                                                                                              <input class="inpMod" data-tipo="10" '.$checkedAccion.' type="checkbox" name="accion_'.$acciones['id_acciones'].'" id="modulo_'.$modulo['id_modulo'].'_'.$subMod['id_modulo'].'_'.$nietoMod['id_modulo'].'_'.$bisNietoMod['id_modulo'].'_'.$acciones['id_acciones'].'" value="ok" onclick="checa_padre(this);">
                                                                                                                                                                                                                                              <span class="pl-3">'.utf8_convert($acciones['nombre_acciones']).'</span>
                                                                                                                                                                                                                                           </div>';
                                                                                                                                                                                                                        }
                                                                                                                                                                                                        $divPermisos.= '</div>';
                                                                                                                                                                                                    }
                                                                                                                                                                            $divPermisos.='     </div>
                                                                                                                                                                                            </div>';
                                                                                                                                                                        }
                                                                                                                                                    $divPermisos.= '</div>';
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                    $divPermisos.='     </div>
                                                                                                                                    </div>';
                                                                                                                }
                                                                                            $divPermisos.= '</div>';
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            //ACCIONES DEL MODULO
                                                                                            liberar_bd();
                                                                                            $selectAccionesModulo = 'CALL sp_sistem_select_acciones_modulo('.$subMod["id_modulo"].');';
                                                                                            $accionesModulo = consulta($selectAccionesModulo);
                                                                                            $ctaAccionesModulo = cuenta_registros($accionesModulo);
                                                                                            if($ctaAccionesModulo != 0)
                                                                                            {
                                                                                                $divPermisos.= '<div class="btn-group float-right">
                                                                                                                    <button type="button" class="btn btn-outline-warning mb-1 " data-toggle="collapse" data-target="#collapseinz'.$subMod['id_modulo'].'" aria-expanded="false" aria-controls="collapseinz'.$subMod['id_modulo'].'">
                                                                                                                        <span aria-hidden="true"><i class="simple-icon-arrow-down"></i></span>
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                                <div class="pt-5 collapse" id="collapseinz'.$subMod['id_modulo'].'">';
                                                                                                                while($acciones = siguiente_registro($accionesModulo))
                                                                                                                {
                                                                                                                    $checkedAccion = '';
                                                                                                                    while($pA = siguiente_registro($permisosAcciones))
                                                                                                                    {
                                                                                                                        if($pA["id_acciones"] == $acciones["id_acciones"])
                                                                                                                            $checkedAccion = ' checked="checked" ';
                                                                                                                    }
                                                                                                                    mysqli_data_seek($permisosAcciones,0);

                                                                                                                    $divPermisos.='<div class="d-flex flex-row mb-3 pb-3 border-bottom color-theme-4">
                                                                                                                                      <input class="inpMod" data-tipo="5" '.$checkedAccion.' type="checkbox" name="accion_'.$acciones['id_acciones'].'" id="modulo_'.$modulo['id_modulo'].'_'.$subMod['id_modulo'].'_'.$acciones['id_acciones'].'" value="ok" onclick="checa_padre(this);">
                                                                                                                                      '.utf8_convert($acciones['nombre_acciones']).'
                                                                                                                                  </div>';
                                                                                                                }
                                                                                                $divPermisos.= '</div>';
                                                                                            }
                                                                                        }
                                                                $divPermisos.= '    </div>
                                                                                </div>';

                                                            }
                        $divPermisos .='			    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                    }

                    //TABLEROS
                    liberar_bd();
                    $selectTableros = 'CALL sp_sistema_select_permisos_tablero();';
                    $tableros = consulta($selectTableros);

                    //PERMISOS DEL DASHBOARD
                    liberar_bd();
                    $selectPermisosDashboard = 'CALL sp_sistema_select_permisos_dashboard('.$idPerfil.');';
                    $permisosDashboard = consulta($selectPermisosDashboard);

                    //PREMISOS DE ACCIONES DASHBORD
                    liberar_bd();
                    $selectPermisosAccionesTab = 'CALL sp_sistema_select_permisos_acciones_tablero('.$idPerfil.')';
                    $permisosAccionesTab = consulta($selectPermisosAccionesTab);

                    $divPermisosDashboard = '';
                    while($tab = siguiente_registro($tableros))
                    {
                        $checkedParentTab = '';
                        while($t = siguiente_registro($permisosDashboard))
                        {
                            if($t["idCont"] == $tab["id"])
                                $checkedParentTab = ' checked="checked" ';
                        }
                        mysqli_data_seek($permisosDashboard,0);

                        $divPermisosDashboard.='<div class="col-lg-4 col-sm-12 mb-4">
                                                    <div class="card mb-4">
                                                        <div class="card-body">
                                                            <div class="float-left">
                                                                <div class="d-inline-block">
                                                                    <h6 class="d-inline font-weight-bold color-theme-1">
                                                                        <input class="inpMod" '.$checkedParentTab.' data-tipo="6" type="checkbox" name="tablero_'.$tab['id'].'" id="tablero_'.$tab['id'].'" onclick="checar_submodulos(this);" value="ok">
                                                                        '.utf8_convert($tab['nombre']).'
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                            <div class="btn-group float-right">
                                                                <button type="button" class="btn btn-outline-primary mb-1 " data-toggle="collapse" data-target="#collapseinx'.$tab['id'].'" aria-expanded="false" aria-controls="collapseinx'.$tab['id'].'">
                                                                    <span aria-hidden="true"><i class="simple-icon-arrow-down"></i></span>
                                                                </button>
                                                            </div>
                                                            <div class="pt-5 collapse" id="collapseinx'.$tab['id'].'">
                                                                <div class="scroll divPermisos">
                                                                    <div class="p-4 border mt-4">';
                                                                        //TABLEROS HIJO
                                                                        liberar_bd();
                                                                        $selectTablerosHijo = 'CALL sp_sistema_select_tableros_hijo('.$tab["id"].')';
                                                                        $tablerosHijo = consulta($selectTablerosHijo);

                                                                        while($subTab = siguiente_registro($tablerosHijo))
                                                                        {
                                                                            $checkedSonTab = '';
                                                                            while($st = siguiente_registro($permisosDashboard))
                                                                            {
                                                                                if($st["idCont"] == $subTab["id"])
                                                                                    $checkedSonTab = ' checked="checked" ';
                                                                            }
                                                                            mysqli_data_seek($permisosDashboard,0);

                                                                            $divPermisosDashboard.= '  <div class="card mb-4">
                                                                                                            <div class="card-body">
                                                                                                                <div class="float-left">
                                                                                                                    <div class="d-inline-block">
                                                                                                                        <h6 class="d-inline font-weight-bold color-theme-2">
                                                                                                                            <input class="inpMod" data-tipo="7" '.$checkedSonTab.' type="checkbox" name="tablero_'.$subTab['id'].'" id="tablero_'.$tab['id'].'_'.$subTab['id'].'" onclick="checa_padre(this);" value="ok">
                                                                                                                            '.utf8_convert($subTab['nombre']).'
                                                                                                                        </h6>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="btn-group float-right">
                                                                                                                    <button type="button" class="btn btn-outline-warning mb-1 " data-toggle="collapse" data-target="#collapseinx'.$subTab['id'].'" aria-expanded="false" aria-controls="collapseinx'.$subTab['id'].'">
                                                                                                                        <span aria-hidden="true"><i class="simple-icon-arrow-down"></i></span>
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                                <div class="pt-5 collapse" id="collapseinx'.$subTab['id'].'">';
                                                                                                                    //ACCIONES DEL TABLERO
                                                                                                                    liberar_bd();
                                                                                                                    $selectAccionesTablero = 'CALL sp_sistem_select_acciones_tablero('.$subTab["id"].');';
                                                                                                                    $accionesTablero = consulta($selectAccionesTablero);

                                                                                                                    while($accionesTab = siguiente_registro($accionesTablero))
                                                                                                                    {
                                                                                                                        $checkedAccionTab = '';
                                                                                                                        while($aT = siguiente_registro($permisosAccionesTab))
                                                                                                                        {
                                                                                                                            if($aT["id"] == $accionesTab["id"])
                                                                                                                                $checkedAccionTab = ' checked="checked" ';
                                                                                                                        }
                                                                                                                        mysqli_data_seek($permisosAccionesTab,0);

                                                                                                                        $divPermisosDashboard.='<div class="d-flex flex-row mb-3 pb-3 border-bottom color-theme-4">
                                                                                                                                                    <input class="inpMod" data-tipo="8" '.$checkedAccionTab.' type="checkbox" name="accionTab_'.$accionesTab['id_acciones'].'" id="tablero_'.$tab['id'].'_'.$subTab['id'].'_'.$accionesTab['id'].'" value="ok" onclick="checa_padre(this);">
                                                                                                                                                    '.utf8_convert($accionesTab['nombre']).'
                                                                                                                                                </div>';
                                                                                                                    }
                                                                            $divPermisosDashboard.= '           </div>
                                                                                                            </div>
                                                                                                       </div>';
                                                                        }

                        $divPermisosDashboard .='			        </div>
			                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                    }

                    $formulario = ' <div class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-10">
                                                        <input type="hidden" readonly id="oldNotiRet" name="oldNotiRet" value="'.$configPos["notiRet"].'">
                                                        <h5 class="mb-2 font-weight-bold">Datos generales</h5>
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
                                                    <div class="form-group col-md-4">
                                                        <label for="isAdmin">Perfil administrador:</label>
                                                        <div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" '.$chkAdmin1.' name="isAdmin" id="isAdmin0" value="0" class="custom-control-input">
                                                                <label class="custom-control-label" for="isAdmin0">No</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" '.$chkAdmin2.' name="isAdmin" id="isAdmin1" value="1" class="custom-control-input">
                                                                <label class="custom-control-label" for="isAdmin1">Si</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-group has-float-label col-md-4">
                                                        <input type="text" class="form-control" id="nombrePerfil" name="nombrePerfil" value="'.$nombrePerfil.'">
                                                        <span>Nombre del perfil</span>
                                                    </label>
                                                </div>
                                                <!--<div class="separator mt-5 mb-3"></div>
                                                <div class="row mb-2">
                                                    <div class="col-12">
                                                        <h5 class="mb-2 font-weight-bold">Permisos de tablero</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div id="accordioninpanel2" class="accordion-group">
                                                            <div class="row">
                                                                '.$divPermisosDashboard.'
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>-->
                                                <div class="separator mt-5 mb-3"></div>
                                                <div class="row mb-2">
                                                    <div class="col-12">
                                                        <h5 class="mb-2 font-weight-bold">Permisos y Acciones a secciones</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div id="accordioninpanel1" class="accordion-group">
                                                            <div class="row">
                                                                '.$divPermisos.'
                                                            </div>
                                                        </div>
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