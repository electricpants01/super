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
        <table class="tablesql" >
        <!-- AQUI ESTA LA PETICION DEL SCROLL BAR INFINITO -->
        <script src="script/jquery.min.js"></script>
        <script type="text/javascript">
            var oset = 0;
            var iload = 3;
            var ban  = true;
            $(function(){
                leer(iload);
            });
            $(document).ready(function(){

            });
            $(window).scroll(function(){
                console.log("scroll top  = "+$(window).scrollTop());
                console.log("document height  = "+$(document).height());
                console.log("window height  = "+$(window).height());
                if( $(window).scrollTop()+ $(window).height() +100 >= $(document).height()){
                    leer(3);
                    console.log("si corrio la funcion leer");
                }
            });
            //funcion Ajax
            function leer(a){
                console.log(ban);
                if(ban === true) {
                    $.ajax({
                        url: "scroll.php",
                        type: "POST",
                        data: {"oset": oset, "iload": a},
                        dataType: "json",
                        success: function (data) {
                            ban = false;
                            console.log(data);
                            for (var i = 0; i < data.contenido.length; i++) {
                                oset++;
                                var item = data.contenido[i];
                                var html = '<tr><td>' + item.nombre + '</br>' +
                                    '<img src="photos/' + item.imagen + '" width="500px" height="300px">' + '</br>' +
                                    item.precio + '</br>' + '<a href="carrito.php?idproducto='+item.id+'"><button type="submit" value="'+item.id+'">Agregar al Carrito</button></a>' + '</td></tr>';
                                $('.tablesql').append(html);
                            }
                            setTimeout( function(){
                                ban = true;
                            },2000);
                        }
                    });
                }

            }
        </script>
        </table>
        <!--Contenido de Productos -->
        <?php
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
    <?php
    ?>
    <div class="hero-image">
        <div class="hero-text">
            <h1>Bienvenido a Biensurtido</h1>
        </div>
    </div>
    <?php
}
?>