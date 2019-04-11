<?php

    session_start();
    if($_SESSION["authenticated"]){ ?>
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
    <div class="login">
        <div class="dropdown">
            <a href="login.html"><?php echo($_SESSION["nombre"]);?></a>
            <div class="dropdown-content">
                <a href="cuenta.php">Cuenta</a><br>
                <a href="cerrar.php">Cerrar sesion</a>
            </div>
        </div>
    </div>
        <div class="sidenav">
        <a href="cuenta.php">Datos Personales</a>
        <a href="cuenta/reporte.php">Reportes</a>
        <a href="#clients">Cambiar contraseña</a>
        </div>
    <?php
     include  'sql.php';
     $sql = sprintf("select * from usuario where id = '%s' limit 1",$_SESSION["id"]);
     $resul = $coneccion->query($sql);
     if( $resul === false) die("sql mal hecho en linea 57 en cuenta.php");

     $fila = $resul->fetch_array();
    ?>
    <form class="frmcuenta" action="cuenta/actualizar.php" method="POST">
        Nombre  : <input type="text" name="nombre" value=" <?php echo $fila["nombre"]?>" required><br>
        Apellido: <input type="text" name="apellido" value="<?php echo $fila["apellidos"]?>" required><br>
        Correo  :   <input type="text" name="correo" value="<?php echo $fila["correo"]?>" required><br>
        Direccion : <input type="text" name="direccion" value="<?php echo $fila["direccion"]?>" required><br>
        <input type="submit" value="Actualizar">
        </form>
    </body>
        </html>
<?php
    }else{
        $host = $_SERVER["HTTP_HOST"];
        $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
        header("Location: http://$host$uri/login.html");
    }


?>