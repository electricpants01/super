<?php

        include "sql.php";
        $arrayconsulta  = array();
        $arrayscript = array();
        if( isset($_POST["iload"]))
        {
            $limite = $_POST["iload"];
        }else { $limite = 1;}
        if( isset($_POST["oset"]))
        {
            $oset = $_POST["oset"];
        }else { $oset = 0;}
        $arrayscript["limite"] = $limite;
        $arrayscript["oset"] = $_POST["oset"];
        $sql = "select * from productos order by id asc limit ".$limite."  offset ".$oset;
        $arrayscript["consulta"] = $sql;
        $resul = $coneccion->query($sql);
        if( $resul === false){
            die("error en indexinicio1.php error de consulta");
        }
        while( $fila = $resul->fetch_array()){
            $arrayconsulta[] = array(
                "id" => $fila["id"],
                "nombre" => $fila["fullnombre"],
                "precio" => $fila["precio"],
                "imagen" => $fila["imagen"]
            );
        }
        $arrayscript["contenido"] = $arrayconsulta;

        echo json_encode($arrayscript);
		?>