<?php
    include "sql.php";
    $idproducto = $_GET["idproducto"];
    $sql = sprintf("delete from carrito where carrito.id = '%s'",$idproducto);
    $resul = $coneccion->query($sql);
    if($resul ===false){
        die("Error en la consulta sql de removercarrito.php");
    }
?>
<script>
    window.location = "carro.php";
</script>