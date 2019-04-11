<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Biensurtido</title>
    <link rel="stylesheet" href="estilos/index.css">
    <link rel="stylesheet" href="estilos/fontawesome/all.css">
</head>
<body>
<form action="s/search.php" method="GET">
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
        <input type="text" name="search">
        <input type="submit" value="buscar">
        <a href="carro.php" class="logocarro"><i class="fas fa-shopping-cart"></i></a>
    </div>
</form>
<?php
session_start();
if( isset($_SESSION["authenticated"])){
if ($_SESSION["authenticated"] === true ){
?>
<!--Contenido de nav de usuario -->
<div class="login">
    <div class="dropdown">
        <a href="login.html"><?php echo($_SESSION["nombre"]);?></a>
        <div class="dropdown-content">
            <a href="cuenta.php">Cuenta</a><br>
            <a href="cerrar.php">Cerrar sesion</a>
        </div>
    </div>
</div>
    <p style="text-align: center; font-size: 50px; font-family: Calibri">PEDIDO RECIBIDO CORRECTAMENTE :)</p>
    <div class="compraexitosa">
        <div class="textocompra">
            <h1>Gracias por tu compra <?php ECHO $_SESSION["nombre"]?>!</h1>
        </div>
    </div>
<?php }else{
    $host = $_SERVER["HTTP_HOST"];
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    header("Location: http://$host$uri/login.html");
}
}
?>
</body>
</html>