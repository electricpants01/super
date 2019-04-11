<?php

    session_start();
    include 'sql.php';

    $sql = sprintf("select * from carrito where idusuario = '%s'", $_SESSION["id"]);
    $resul = $coneccion->query($sql);
    if ( $resul === false) die ("primer sql linea 8 error en la consulta");
    while( $fila = $resul->fetch_array()){
    $sql2 = sprintf("select cantidad from productos where id = '%s' limit 1",$fila["idproducto"]);
    $r = $coneccion->query($sql2); // cantidad del id de un producto
    if( $r === false) die("sql2 error en la consulta");
    $r2 = $r->fetch_array();
    $cantproducto = $r2["cantidad"];
    // ahora editamos la BD disminuyendo lo que se compro
    $sql3 = sprintf("update productos set cantidad = '%s' where id = '%s'", $cantproducto-$fila["cantidad"],$fila["idproducto"]);
    $re = $coneccion->query($sql3);
    if( $re === false) die("error en sql3 de la linea 18");
    // insertamos ahora a la tabla ventas
    $sql4 = sprintf("insert into ventas(idusuario,idproducto,cantidad) values ('%s','%s','%s')",$_SESSION["id"],$fila["idproducto"],$fila["cantidad"]);
    $res = $coneccion->query($sql4);
    if($res === false) die("erro en la sql4 de la linea 22");
    }
    // AQUI ELIMINAMOS TODO LA TABLA CARRITO DEL IDUSUARIO ACTUAL
    $sql5 = sprintf("delete from carrito where idusuario = '%s'",$_SESSION["id"]);
    $resul = $coneccion->query($sql5);
    if($resul === false) die ("sql5 error en la linea 26");
    // ahora redirijimos a la pagina success.hp
    $host = $_SERVER["HTTP_HOST"];
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    header("Location: http://$host$uri/success.php");
exit;
?>
