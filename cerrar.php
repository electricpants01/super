<?php

    session_start();
    if( $_SESSION["authenticated"] !== true){
        echo("inicie sesion");
    }
    session_destroy();
    $host = $_SERVER["HTTP_HOST"];
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    header("Location: http://$host$uri/index.php");
exit;
?>