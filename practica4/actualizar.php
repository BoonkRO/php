<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Actualizar datos</title>
</head>
<body>
  <?php
  //si han entrado por post y la accion ha sido la de actualizar, actualizamos y despues redirigimos a listado.php
  //sino, redirigiremos directamente a listado.php
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["accion"] == 'Actualizar') {
    try {
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $dwes = new mysqli('localhost', 'root', '', 'dwes');
      $error = $dwes->connect_errno;
      $dwes->connect('localhost', 'root', '', 'dwes');
      $acentos = $dwes->query("SET NAMES 'utf8'");
    } catch(Exception $e) {
      echo "<p>Ooops! Se produjó un error al conectar a la base de datos.</p>";
      exit();
    }
    $cod_producto = $_POST["codProducto"];
    $nombre_corto = $_POST["nombreCorto"];
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $pvp = $_POST["pvp"];
    $actualizar = $dwes->query(
      "UPDATE producto SET nombre_corto='".$nombre_corto."', nombre='".$nombre."', descripcion='".$descripcion."', pvp='".$pvp."' WHERE cod='".$cod_producto."'"
    );
  }
  header('Location: listado.php');
  die();
  ?>
</body>
</html>