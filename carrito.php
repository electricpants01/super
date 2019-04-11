<?php

    session_start();
    include "sql.php";
    if( isset($_SESSION["authenticated"])){
        if($_SESSION["authenticated"] === true){
            $idproducto = $_GET["idproducto"];
            // verificamos si ya hay un product anterior que selecciono el usuario
            $sql = sprintf("select count(*) as contar from carrito where idproducto = '%s' and idusuario = '%s' limit 1",$idproducto, $_SESSION["id"]);
            $resul = $coneccion->query($sql);
            if($resul === false){
                die("error en la consulta 1 de carrito.php");
            }
            $fila = $resul->fetch_array();
            $cont1 = $fila["contar"];
            if( $cont1 == 0){
                $sql2 = sprintf("insert into carrito(idusuario,idproducto,cantidad) values('%s','%s','%s')",$_SESSION["id"],$idproducto,1);
                $resul = $coneccion->query($sql2);
                if($resul === false){
                    die("error en la insersion de producto carrito.php");
                }
            }else{
                $sql3 = sprintf("select count(*) as cantcarrito from carrito where idproducto = '%s' and idusuario = '%s' limit 1",$idproducto,$_SESSION["id"]);
                $resul = $coneccion->query($sql3);
                if($resul === false){
                    die("error en la consulta sql3 del archivo carrito.php");
                }
                $fila = $resul->fetch_array();
                $cantcarrito = $fila["cantcarrito"];/*

                Obtenemos la cantidadde productos que hay en la tabla productos

            */
                $sql4 = sprintf("select cantidad from productos where id = '%s'",$idproducto);
                $resul = $coneccion->query($sql4);
                if($resul === false){
                    die("error en sql4 de carrito.php");
                }
                $fila = $resul->fetch_array();
                $cantproducto = $fila["cantidad"];
                if( $cantcarrito <= $cantproducto){
                    $sql5 = sprintf("select cantidad from carrito where idproducto = '%s' ",$idproducto);
                    $resul = $coneccion->query($sql5);
                    if($resul === false){
                        die("error en la consulta 5 de carrito.php");
                    }
                    $fila = $resul->fetch_array();
                    $cantidad = $fila["cantidad"]+1; // aumentamos la cantidad en uno
                    $sql6 = sprintf("update carrito set cantidad = '%s' where idproducto = '%s' and idusuario = '%s'",$cantidad,$idproducto, $_SESSION["id"]);
                    $resul = $coneccion->query($sql6);
                    if($resul === false){
                        die("error en la sql6 de carrito.php");
                    }
                }
            }
        }
    }else{
        $host = $_SERVER["HTTP_HOST"];
        $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
        header("Location: http://$host$uri/login.html");
        exit;
    }
?>
<script>
    window.location = "index.php";
</script>
