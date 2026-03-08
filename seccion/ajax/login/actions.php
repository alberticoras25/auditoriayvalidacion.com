<?php
    session_start();
    error_reporting(E_ERROR);
    include_once("../../../portal/motor/conexionSitio.php");
    include_once("../../../portal/motor/globales.php");
    conectarSistema();
    $valAction = "true";
    $alert = $txtReturn = '';
    $idReturn = 0;

    switch($_POST["catTipo"])
    {
        case '0':
            $actualDate = date("d-m-Y");
            $valDate = false;
            switch($_POST["action"])
            {
                case 'changeSuc':
                case 'login':
                    $user = str_replace(' ', '', mb_convert_case($_POST['txtUsuario'], MB_CASE_UPPER, "UTF-8"));
                    $pass = mb_convert_case($_POST['txtPassword'], MB_CASE_UPPER, "UTF-8");
                    $x = $_POST['txtPassword'];
                    $a = str_replace(' ', '', $x);
                    $aa = sanear_string($a);
                    $pass = strtoupper($aa);

                    liberar_bd();
                    $selectDatosUSuario = 'CALL sp_login_select_exist_usuario(  "'.utf8_desconvert($user).'",
                                                                                "'.utf8_desconvert($pass).'");';

                    $datosUsuario = consulta($selectDatosUSuario);
                    $ctaDatosUsuario = cuenta_registros($datosUsuario);
                    if($ctaDatosUsuario == 1)
                    {
                        $datUser = siguiente_registro($datosUsuario);
                        $idPerfilAdmin = $datUser["idPerfil"];

                        $_SESSION["reConnect"] = $_SESSION["connect"] = 0;
                        $_SESSION["idUser"] = $datUser['id'];
                        $_SESSION[$varIdUser] = $datUser['id'];
                        $_SESSION['token'] = md5(rand().$_SESSION["idUser"]);
                        $_SESSION['usuario'] = utf8_convert($datUser['usuario']);
                        $_SESSION['login'] = utf8_convert($datUser['login']);
                        $_SESSION['tipoUser'] = $datUser['tipoUser'];
                        $_SESSION['idPerfil'] = $datUser['idPerfil'];
                        $_SESSION['perfil'] = $datUser['perfil'];
                        //COOKIES
                        setcookie("id", $datUser['id'], strtotime("+1 day"), "/", "", "", TRUE);

                        //ACTUALIZAMOS TOKEN DEL USUARIO
                        liberar_bd();
                        $updateToken = 'CALL sp_login_update_token_user('.$_SESSION["idUser"].', "'.$_SESSION["token"].'");';
                        $updateTok = consulta($updateToken);

                        $alert = $_SESSION['usuario'];
                    }
                    else
                    {
                        $valAction = "false";
                        $alert = 'Los datos introducidos son incorrectos';
                    }
                break;
                case 'reconnect':
                    $user = str_replace(' ', '', mb_convert_case($_SESSION['login'], MB_CASE_UPPER, "UTF-8"));
                    $x = mb_convert_case($_POST['txtRePassword'], MB_CASE_UPPER, "UTF-8");
                    $a = str_replace(' ', '', $x);
                    $aa = sanear_string($a);
                    $pass = strtoupper($aa);

                    session_start();
                    $_SESSION["reConnect"] = 0;
                    $_SESSION["connect"] = 1;
                    liberar_bd();
                    $selectDatosUSuario = 'CALL sp_login_select_exist_usuario(  "'.utf8_desconvert($user).'",
                                                                                "'.utf8_desconvert($pass).'");';

                    $datosUsuario = consulta($selectDatosUSuario);
                    $ctaDatosUsuario = cuenta_registros($datosUsuario);
                    if($ctaDatosUsuario == 1)
                    {
                        $_SESSION["reConnect"] = $_SESSION["connect"] = 0;
                        $_SESSION['txtRePassword'] = '';
                        $datUser = siguiente_registro($datosUsuario);
                        $_SESSION["idUser"] = $datUser['id'];
                        $_SESSION[$varIdUser] = $datUser['id'];
                        $_SESSION['token'] = md5(rand().$_SESSION["idUser"]);
                        $_SESSION['usuario'] = utf8_convert($datUser['usuario']);
                        $_SESSION['login'] = utf8_convert($datUser['login']);
                        $_SESSION['tipoUser'] = $datUser['tipoUser'];
                        $_SESSION['idPerfil'] = $datUser['idPerfil'];
                        $_SESSION['perfil'] = $datUser['perfil'];
                        setcookie("id", $datUser['id'], strtotime("+1 day"), "/", "", "", TRUE);

                        //ACTUALIZAMOS TOKEN DEL USUARIO
                        liberar_bd();
                        $updateToken = 'CALL sp_login_update_token_user('.$_SESSION["idUser"].', "'.$_SESSION["token"].'");';
                        $updateTok = consulta($updateToken);

                        //ACTUALIZAMOS LA ULTIMA CONEXION
                        liberar_bd();
                        $updateConexion = 'CALL sp_sistema_update_ultima_conexion(  '.$_SESSION["idUser"].',
                                                                                    "'.todayComplete().'");';
                        $updateConect = consulta($updateConexion);

                        $alert = $_SESSION['usuario'];
                    }
                    else
                    {
                        $valAction = "false";
                        $alert = 'Los datos introducidos son incorrectos';
                    }
                break;
            }
        break;
        case '1':
            switch($_POST["action"])
            {
                case 'valToken':
                    if($_SESSION["idUser"] == "x")
                    {
                        $valAction = "close";
                        break;
                    }

                    liberar_bd();
                    $selectTokenUsuario = 'CALL sp_sistema_select_token_usuario('.$_SESSION["idUser"].');';
                    $tokenUsuario = consulta($selectTokenUsuario);
                    $tokenUs = siguiente_registro($tokenUsuario);
                    if($tokenUs["token"] != $_SESSION["token"])
                    {
                        $valAction = "false";
                        $alert = 'Se ha iniciado sesión en otro dispositivo.';
                        break;
                    }
                break;
                case 'closeCorte':
                    $_SESSION["idUser"] = "x";
                    $valAction = "false";
                    $alert = 'Corte realizado. Cerrar para salir.';
                break;
            }
        break;
    }

    echo json_encode(array("valAction"=>$valAction, "alert"=>$alert, "idReturn"=>$idReturn, "txtReturn"=>$txtReturn));