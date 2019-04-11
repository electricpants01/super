<?php

    session_start();
    // sesion iniciada
    include "sql.php";
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellido"];
    $correo = $_POST["correo"];
    $contra1 = $_POST["password"];
    $contra2 = $_POST["password2"];
    // las contraseñas tienen que ser iguales
    if( isset($contra1) && !empty($contra1) && isset($contra2) && !empty($contra2)){
        if( $contra1 !== $contra2){
            echo("Las contraseñas NO coinciden");
            exit;
        }
    }
    //verificar que el correo introducido sea unico
    if( !empty($nombre) && !empty($apellidos) && !empty($correo) && !empty($contra1) && !empty($contra2)){
        $sql = sprintf("select correo from usuario where correo = '%s' LIMIT 1 ",$coneccion->real_escape_string($correo));
        $resul = $coneccion->query($sql);
        if( $resul === false){
            die("Error en la consulta realizada");
            exit;
        }
        if($resul->num_rows == 1){
            echo("el Usuario ya esta registrado, inicie Sesion");
            exit;
        }
        $sql2 = sprintf("insert into usuario (nombre,apellidos,correo,contra) values ('%s','%s','%s','%s')",
            $coneccion->real_escape_string($nombre),$coneccion->real_escape_string($apellidos),
            $coneccion->real_escape_string($correo), password_hash($coneccion->real_escape_string($contra1),PASSWORD_DEFAULT));
        $resul2 = $coneccion->query($sql2);
        if($resul2 === false){
            die("Consulta 2 esta realizada incorrectamente");
        }else{
            $sql3 = sprintf("select id from usuario where correo = '%s' limit 1",$coneccion->real_escape_string($correo));
            $resul3 = $coneccion->query($sql3);
            if( $resul3 === false){ die("Error en la consulta 3 del archivo registro.php"); exit;}
            $fila2 = $resul3->fetch_array();
            $_SESSION["id"] = $fila2["id"];
            $_SESSION["authenticated"] = true;
			$_SESSION["nombre"] = $nombre;
            $host = $_SERVER["HTTP_HOST"];
            $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: http://$host$uri/index.php");
            exit;
        }
    }else{
        echo ("No deje ningun campo en Blanco");
    }

?>