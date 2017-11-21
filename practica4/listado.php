<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Listado</title>
</head>
<body>
<?php 
  /* si entra por post sabemos que ya ha elegido una familia, asi que guardamos 
  el nombre de la familia para su posterior uso */
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cod_familia = $_POST['familia'];
  }
  // conectar a la base de datos
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
<form action="" method="post">
<fieldset style="background: aquamarine">
  <legend><h3>Tarea: Listado de productos de una familia</h3></legend>
  <select name="familia">
  <?php 
  if ($error == null) {
    $familias = $dwes->query('SELECT * FROM familia');
    /* obtener el array de objetos de la tabla familia
    mientras haya objetos que sacar creamos opciones para el select */
    while ($obj = $familias->fetch_object()) {
      //si el codigo de familia que vino por post es el que estamos tratando en este punto,
      //ponemos la opcion a selected ya que sabemos que es la que ha elegido el usuario
      if (isset($cod_familia) && $cod_familia == $obj->cod) {
        echo "<option value=".$obj->cod." selected>".$obj->nombre."</option>";
      }
      else {
        echo "<option value=".$obj->cod.">".$obj->nombre."</option>";
      }
    }
    // $dwes->close();
  }    
  ?>
  </select>
  <input type="submit" value="Mostrar productos">
</fieldset>
</form>

<?php 
if (isset($cod_familia)) {
  //inicializamos una tabla
  $table = '<h3>Productos de la familia:</h3><table>';
  $productos = $dwes->query('SELECT * FROM producto WHERE familia="'.$cod_familia.'"');
  /* obtener el array de objetos en los productos que sean de la familia seleccionada*/
  while ($obj = $productos->fetch_object()) {
    //generamos una fila para la tabla (con un formulatio insertado) en la que tengamos un td
    // para el nombre y otro para el pvp
    $table.= '<tr><form action="editar.php" method="post"><td>Producto '.$obj->nombre_corto.': </td>';
    $table.= '<td><b>'.$obj->PVP.'</b> euros</td>';
    //metemos un input hidden con el codigo del objeto en cuestion para que la siguiente vista
    //pueda recibir el codigo del objeto para buscarlo en la bbdd
    $table.= '<td><input type="hidden" name="codigoProducto" value="'.$obj->cod.'">';
    $table.= '<input type="submit" value="Editar"></td></form></tr>';
  }
  $dwes->close();
  $table.= '</table>';
  echo $table;
}

?>

</body>
</html>