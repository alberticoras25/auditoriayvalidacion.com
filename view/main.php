<?php
    $url = $_SERVER["SCRIPT_NAME"];
    $parts = explode('/', $url);
    $file = $parts[count($parts) - 1];
    $directory = 'view/pages/';
    switch($file)
    {
        case 'index.php':
            $page = "index_page.php";
        break;
        case '404.php':
            $page = "error.php";
        break;
    }

    include $directory.$page;

