<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Ejercicio 4 - Guillermo Cirer</title>
</head>
<body>

<?php 
//primera vez que entramos en la pagina por GET
//inicializamos los intentos, y generamos un numero aleatorio entre 1 y el MAX
$maximo = PHP_INT_MAX;
$intentos = 20;
$numeroGenerado = rand(1, $maximo);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //cada vez que se haga un post se recogen los valores de los inputs hidden
  $numeroIntroducido = $_POST["numeroIntroducido"];
  $numeroGenerado = $_POST["numeroGenerado"];
  $intentos = $_POST["intentos"];
  $mensaje = "";
  if (isset($numeroIntroducido) && isset($numeroGenerado) && isset($intentos)) {
    //si habia intentos entonces restamos 1 intento y comprobamos el numero introducido con el generado
    if ($intentos > 0) {
      $intentos--;
      if ($numeroIntroducido > $numeroGenerado) {
        $mensaje = "El número introducido (".$numeroIntroducido.") es mayor que el número que tratas de adivinar";
      }
      else if ($numeroIntroducido < $numeroGenerado) {
        $mensaje = "El número introducido (".$numeroIntroducido.") es menor que el número que tratas de adivinar";
      } else {
        $mensaje = "Enhorabuena, has adivinado el número: <strong>".$numeroGenerado."</strong>";
      }
    }
    //sino, el usuario se ha quedado sin intentos y ya no comprobamos su numero
    else {
      $mensaje = "Vaya, te has quedado sin intentos, vuelve a empezar";
    }
  }
}

?>

<form action="" method="post">
<fieldset style="background: #eee">
<legend><h3>Introduce un número</h3></legend>
<?php 
//avisamos al usuario de si su numero es mayor, menor, si ha acertado o si se ha quedado sin intentos
if (isset($mensaje) && !empty($mensaje)) {
  echo "<h4>".$mensaje."</h4>";
}
?>
<p>Intentos restantes: <strong><?php echo $intentos ?></strong></p>
<label for="numeroIntroducido">Intenta adivinar el número entre 1 y <?php echo $maximo ?></label>
<br>
<input name="numeroIntroducido" required="true" id="numeroIntroducido" type="number" min="1" max="<?php echo $maximo ?>">
<input type="hidden" name="intentos" value="<?php echo $intentos; ?>">
<input type="hidden" name="numeroGenerado" value="<?php echo $numeroGenerado; ?>">
<input type="submit" value="Probar">
</fieldset>
</form>

</body>
</html>