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

            //FILTROS
            $selectPerf = array_values(array_sort($_POST['selectPerf'], 'idPerf', SORT_ASC));
            $countSelectPerf = count($selectPerf);
            if($countSelectPerf >= 1)
            {
                $i = 1;
                foreach($selectPerf as $value)
                {
                    $conect = ' OR ';
                    if($i ==  $countSelectPerf)
                        $conect = '';

                    extract($value);
                    $sqlPerf.= ' usuar.id_perfil = '.$idPerf.$conect;
                    $i++;
                }

                $sqlPerfiles = ' AND ('.$sqlPerf.') ';
            }

            liberar_bd();
            $selectUsuarios = "  SELECT
                                    usuar.id_usuario AS id,
                                    usuar.login_usuario AS login,
                                    usuar.password_usuario AS pass,
                                    usuar.nombre_usuario AS nombre,
                                    usuar.id_perfil AS idPerf,
                                    perf.nombre_perfil AS perfil,
                                    usuar.estado_usuario AS estatus,
                                    usuar.fecha_ultima_conexion_usuario AS dateConect,
                                    DATE_FORMAT(usuar.fecha_ultima_conexion_usuario,\"%d-%m-%Y %h:%i %p\") AS conexion
                                FROM _perfiles AS perf
                                INNER JOIN _usuarios AS usuar ON perf.id_perfil = usuar.id_perfil
                                WHERE usuar.estado_usuario <> 0
                                AND usuar.id_usuario <> 1"
                                .$sqlPerfiles;

            $usuarios = consulta($selectUsuarios);

            $catalogo = '   <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="data-table tableOrder table-striped nowrap">
                                            <thead>
                                                <tr>
                                                    <th>NOMBRE(login)</th>
                                                    <th>PERFIL</th>
                                                    <th>ACCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                            while($user = siguiente_registro($usuarios))
                                            {
                                                $catalogo.= '   <tr id="'.$user["id"].'">
                                                                    <td>'.utf8_convert($user["nombre"]).' ('.utf8_convert($user["login"]).')</td>
                                                                    <td>'.utf8_convert($user["perfil"]).'</td>
                                                                    <td>
                                                                        <div class="btn-group top-right-button-container" role="group">';
                                                                            if($btnEdita)
                                                                                $catalogo.= ' <button type="button" class="btn btn-primary icon-button see_sidemenu_r_cat" title="Editar" onClick="muestra_page(\'myModalContent\', '.$_POST["catTipo"].', \'edit\', '.$user["id"].')">
                                                                                                <i class="simple-icon-pencil"></i>
                                                                                            </button> ';

                                                                            if($btnElimina)
                                                                                $catalogo.= ' <button type="button" class="btn btn-danger icon-button" title="Eliminar" onClick="actionCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'delete\', '.$user["id"].')">
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

            liberar_bd();
            $selectPerfiles=' SELECT
                                perf.id_perfil AS id,
                                perf.nombre_perfil AS nombre,
                                perf.tipo_perfil AS tipo
                              FROM _perfiles AS perf
                              WHERE perf.estatus_perfiles <> 0
                              AND perf.id_perfil <> 1';

            $perfiles = consulta($selectPerfiles);

            $catalogo = '   <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="data-table tableOrder table-striped nowrap">
                                            <thead>
                                                <tr>
                                                    <th>PERFIL</th>
                                                    <th>ADMINISTRADOR</th>
                                                    <th>ACCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                            while($perf = siguiente_registro($perfiles))
                                            {
                                                $tipo = 'NO';
                                                if($perf["tipo"] == 1)
                                                    $tipo = 'SI';

                                                $valPerf = true;
                                                if($perf["id"] == 2)
                                                    $valPerf = false;

                                                $catalogo.= '   <tr id="'.$perf["id"].'">
                                                                    <td>'.utf8_convert($perf["nombre"]).'</td>
                                                                    <td>'.$tipo.'</td>
                                                                    <td>
                                                                        <div class="btn-group top-right-button-container" role="group">';
                                                                            if($btnEdita && $valPerf)
                                                                                $catalogo.= ' <button type="button" class="btn btn-primary icon-button" title="Editar" onClick="formCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'edit\', '.$perf["id"].')">
                                                                                                <i class="simple-icon-pencil"></i>
                                                                                            </button> ';
                                                                            if($btnElimina && $valPerf)
                                                                                $catalogo.= ' <button type="button" class="btn btn-danger icon-button" title="Eliminar" onClick="actionCatalogo(\'divFormCatalogo\', '.$_POST["catTipo"].', \'delete\', '.$perf["id"].')">
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