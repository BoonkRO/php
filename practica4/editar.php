<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Editar</title>
</head>
<body>
<h3>Tarea: Edición de un producto</h3>
<?php 
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //recogemos el codigo del producto que nos han enviado
    $cod_producto = $_POST["codigoProducto"];
  }
  //conectamos con la bbdd
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
?>
<form action="actualizar.php" method="post">
<fieldset style="background: #eee">
<legend><h3>Producto</h3></legend>
<?php 
if (isset($cod_producto) && $error == null) {
  //recogemos el producto en cuestion
  $producto = $dwes->query('SELECT * FROM producto WHERE cod="'.$cod_producto.'"');
  $obj = $producto->fetch_object();
  //generamos un input para cada columna de la tabla producto
  $output='Nombre corto:<br><input name="nombreCorto" size="40" type="text" value="'.$obj->nombre_corto.'"><br>';
  $output.='Nombre:<br><textarea name="nombre" rows="2" cols="80">'.$obj->nombre.'</textarea><br>'; 
  $output.='Descripcion:<br><textarea name="descripcion" rows="5" cols="80">'.$obj->descripcion.'</textarea><br>'; 
  $output.='PVP: <input type="number" name="pvp" value="'.$obj->PVP.'"><br><br>';
  $output.='<input type="hidden" name="codProducto" value="'.$cod_producto.'">';
  echo $output;
}
?>
<input type="submit" name="accion" value="Actualizar">
<input type="submit" name="accion" value="Cancelar">
</fieldset>
</form>

</body>
</html>