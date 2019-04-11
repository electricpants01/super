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
                    <a href="">Cuenta</a><br>
                    <a href="cerrar.php">Cerrar sesion</a>
                </div>
            </div>
        </div>
        <!--Contenido de Productos -->
        <?php
        include "sql.php";
        $sql = "select * from productos";
        $resul = $coneccion->query($sql);
        if( $resul === false){
            die("indexinicio.php consulta sql de productos error");
        }
        echo"<table class='tablesql'>";
        while( $fila = $resul->fetch_array()){
            echo"<tr>";
                echo"<td>";
                    echo $fila["fullnombre"]."</br>";
                    echo "<img src='photos/".$fila["imagen"]."' width='500' height='300'> </br>";
                    echo $fila["precio"]."</br>";
                    echo"<button>Comprar ahora</button>";
                echo"</td>";
            echo"</tr>";
        }
        echo"</table>";
    }}else{
    ?>
    <div class="login">
        <div class="dropdown">
            <a href="login.html">Ingresar</a>
            <div class="dropdown-content">
                <a href="login.html">Login</a><br>
                <a href="registro.html">Registrate</a>
            </div>
        </div>
    </div>
    <div class="hero-image">
        <div class="hero-text">
            <h3>Bienvenido a Biensurtido</h3>
        </div>
    </div>
    <?php
}
?>

