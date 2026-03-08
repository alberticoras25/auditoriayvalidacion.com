<?php
    include_once("control.php");

    function muestraContenido()
    {
        $cuerpo = muestra_login();
        if(isset($_SESSION["idUser"]) && isset($_SESSION["token"]))
        {
            if(isset($_SESSION["reConnect"]) && $_SESSION["reConnect"] == 1)
                $cuerpo = muestra_screenlock();
            else
                $cuerpo = muestra_sistema();
        }
        else
        {
            if(isset($_SESSION["reConnect"]) && $_SESSION["reConnect"] == 1)
                $cuerpo = muestra_screenlock();
        }
        echo $cuerpo;
    }