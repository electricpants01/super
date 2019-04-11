<?php
    $coneccion = new mysqli('localhost','root','','super'); //coneccion a la BD
    if( $coneccion === false)
        die('coneccion a la base de datos fallida');
    if( $coneccion->select_db('super') === false)
        die("seleccion de la BD fallida");
    $coneccion->set_charset("utf8");
?>