<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Biensurtido</title>
    <link rel="stylesheet" href="estilos/index.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>
<body>
<form action="">
    <div class="nav1">
        <a id="logo" href="index.php"><i class="fas fa-store">BienSurtido</i></a>
        <select>
            <option>CATEGORIA</option>
            <?php
            //session_start(); INICIO DE SESION YA REALIZADA EN "indexinicio.php"

            include "sql.php"; // Incluimos la base de datos

            $sql = "select * from categoria";
            $resul = $coneccion->query($sql);
            if( $resul === false){
                die("error en la consulta");
            }
            while( $fila = $resul->fetch_array()){
                echo "<option>".$fila["nombre"]."</option>>";
            }
            ?>
        </select>
        <input type="text">
        <input type="submit" value="buscar">
        <a href="carro.php" class="logocarro"><i class="fas fa-shopping-cart"></i></a>
    </div>
</form>
        <?php
        session_start();
        if( isset($_SESSION["authenticated"])){
        if ($_SESSION["authenticated"] === true ) {
            ?>
            <!--Contenido de nav de usuario -->
            <div class="login">
                <div class="dropdown">
                    <a href="login.html"><?php echo($_SESSION["nombre"]); ?></a>
                    <div class="dropdown-content">
                        <a href="cuenta.php">Cuenta</a><br>
                        <a href="cerrar.php">Cerrar sesion</a>
                    </div>
                </div>
            </div>
            <?php
        }}else{
            $host = $_SERVER["HTTP_HOST"];
            $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: http://$host$uri/login.html");
            exit;
        }
        /* fin del fin*/
        ?>
        <table class="tablecarrito">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Descuento</th>
                <th>Precio</th>
                <th></th>
            </tr>
        <?php
        $subtotal = 0.00;
        $total = 0.00;
            $sql = sprintf("select carrito.id,productos.fullnombre,carrito.cantidad,productos.descuento,productos.precio from productos,carrito where carrito.idproducto = productos.id and carrito.idusuario = '%s'",$_SESSION["id"]);
            $resul = $coneccion->query($sql);
            if($resul === false){
                die("Error en la consulta del carrito en carro.php linea 73");
            }
            while($fila = $resul->fetch_array()){
                $subtotal = $subtotal + $fila["precio"] * $fila["cantidad"];
                if($fila["descuento"] === 0.00){
                    $total = $total + $fila["precio"] * $fila["cantidad"];
                }else{
                    $total = $total + ($fila["precio"] - $fila["descuento"]*$fila["precio"]) * $fila["cantidad"];
                }
                echo '<tr>';
                    echo '<td>'.$fila["fullnombre"].'</td>';
                    echo '<td>'.$fila["cantidad"].'</td>';
                    echo '<td>'.$fila["descuento"].'</td>';
                    echo '<td>'.$fila["precio"].'</td>';
                    echo '<td><a href="removercarrito.php?idproducto='.$fila["id"].'"><button type="submit">Remover</button></a></td>';
                echo '</tr>';
            }
        ?>
        </table>
        <?php

        ?>
        <div id="pagar" >
            <p>Subtotal a pagar : <?php echo number_format($subtotal,3); ?></p>
            <p id="pagarp">Total a pagar con descuento :    <?php echo number_format($total,3); ?> </p>

        </div>
        <div class="tipopago">
            <form action="ventas.php">
                <input type="text" placeholder="Nombre de la targeta">
                <input type="text"  placeholder="Numero de la targeta">
                <select name="fecha">
                    <?php
                    for( $i = 1 ; $i<=12;$i++){
                        echo '<option>'.$i.'</option>';
                    }
                    ?>
                </select>
                <select name="fecha">
                    <?php
                    for( $i = 2018 ; $i<=2038;$i++){
                        echo '<option>'.$i.'</option>';
                    }
                    ?>
                </select>
            <input type="submit" value="Pagar">
            </form>
        </div>
</body>
</html>