<?php

    session_start();
    include "sql.php";
    $correo = $_POST['correo'];
    $contra = $_POST['password'];
    if (isset($correo) && !empty($correo) && isset($contra) && !empty($contra)){

        // consultar con la base de datos
        $sql = sprintf("select id,nombre,contra from usuario where correo = '%s' limit 1",
            $coneccion->real_escape_string($correo));
        $resul = $coneccion->query($sql);
        if( $resul === false)
            die("error en la consulta");

        if($resul->num_rows == 1) {
            $fila = $resul->fetch_assoc();
            $coneccion->close();   // cierre de la conexion
            if (password_verify($contra,$fila["contra"]) === true) {
                $_SESSION["authenticated"] = true;
                $_SESSION["id"] = $fila["id"];
                $_SESSION["nombre"] = $fila["nombre"];
                $host = $_SERVER["HTTP_HOST"];
                $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
                header("Location: http://$host$uri/index.php");
                exit;
            } else {
                die("contraseña o usuario incorrecto"); // hacer un pop en la misma pagina
            }
        }
        echo("Contraseña o usuario incorrecto");
    }
    else{
        die("escriba usuario y contraseña ");   // hacer un pop en la misma pagina
    }

?>