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
  /* aqui esta el navbar de registro y usuario !!!!!!!!!*/
  include 'indexinicio1.php';
  ?>

</body>
</html>