<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Practica 3</title>
	<style>
	  table {
	      border-collapse: collapse;
	      width: 100%;
	  }

	  th, td {
	      text-align: left;
	      padding: 8px;
	  }

	  tr:nth-child(even){background-color: #f2f2f2}

	  th {
	      background-color: #4CAF50;
	      color: white;
	  }
	  .error {
	    color: red;
	  }
	</style>
</head>
<body>
	<?php 

	$almacenContactos = "";
	$almacenNumeros = "";
	//variable que rige si se muestra o no la agenda de contactos (<table>)
	$hayContactos = false;

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		//variables para controlar si mostramos o no un mensaje de que algun campo esta vacio
		$contactoVacio = true;
		$numeroVacio = true;
		//valores que recibimos del post
		$inputNombre = trim($_POST['nombreContacto']);
		$inputNombreSinEspacios = str_replace(' ', '', $inputNombre);
		$inputTlf = trim($_POST['numeroTlf']);
		$inputTlf = str_replace(' ', '', $inputTlf);
		$inputTlfSinEspacios = str_replace(' ', '', $inputTlf);

		//comprobamos y actualizamos el almacen de contactos
		if (isset($_POST['almacenContactos']) && strlen($_POST['almacenContactos']) > 1) {
			$almacenContactos.= $_POST['almacenContactos'];
			$almacenNumeros.= $_POST['almacenNumeros'];
			$hayContactos = true;
		}
		
		//agregar contacto si los campos no estan vacios (es decir si la longitud del string es mayor que 1 y no contiene espacios)
		if (strlen($inputNombreSinEspacios) > 1 && strlen($inputTlfSinEspacios) > 1 && is_numeric($inputTlf)) {
			$contactoVacio = false;
			$numeroVacio = false;
			//si el almacen esta vacio agregamos el contacto ya que ya ha pasado los filtros necesarios
			if ($almacenContactos == "") {
				$hayContactos = true;
				$almacenContactos.= $inputNombre;
				$almacenNumeros.= $inputTlf;
			} else {
			//sino, el almacen no esta vacio habra que comprobar si este nombre esta o no en la lista
				$hayContactos = true;
				/*removemos la ultima coma del input para que al construir el array a partir de este input no meta un
				 item vacio despues de la coma*/
				if (substr($almacenContactos, -1) == ",") {
					$almacenContactos = substr($almacenContactos, 0, -1);
				}
				if (substr($almacenNumeros, -1) == ",") {
					$almacenNumeros = substr($almacenNumeros, 0, -1);
				}
				//a partir del valor tipo string construimos arrays usando las comas como separadores
	  		$almacenContactos = explode(',', $almacenContactos);
	  		$almacenNumeros = explode(',', $almacenNumeros);	
	  		
	  		//si el nombre no esta en la agenda lo agregamos 
	  		if (!in_array($inputNombre, $almacenContactos)) {
  				array_push($almacenContactos, $inputNombre);
  				array_push($almacenNumeros, $inputTlf);
  			} else {
  				//sino como el nombre ya estaba, actualizamos el numero de telefono
  				$posicion = array_search($inputNombre, $almacenContactos);
  				$almacenNumeros[$posicion] = $inputTlf;
  			}
  			//volvemos a pasar a string las arrays para meterlas en el input
  			$almacenContactos = implode(',', $almacenContactos);
  			$almacenNumeros = implode(',', $almacenNumeros);
			}
		} else if (strlen($inputNombreSinEspacios) > 1 && strlen($inputTlfSinEspacios) < 1) {
			//si el nombre esta escrito y el numero esta vacio, tenemos que comprobar si el nombre existia para borrarlo
			$contactoVacio = false;
			$numeroVacio = false;
			//si la agenda no esta vacia, comprobamos si el nombre ya existia
			if ($almacenContactos != "") {
				$hayContactos = true;
				/*removemos la ultima coma del input para que al construir el array a partir de este input no meta un
				item vacio despues de la coma*/
				if (substr($almacenContactos, -1) == ",") {
					$almacenContactos = substr($almacenContactos, 0, -1);
				}
				if (substr($almacenNumeros, -1) == ",") {
					$almacenNumeros = substr($almacenNumeros, 0, -1);
				}
				//a partir del valor tipo string construimos arrays usando las comas como separadores
	  		$almacenContactos = explode(',', $almacenContactos);
	  		$almacenNumeros = explode(',', $almacenNumeros);	
	  		
	  		//si el nombre no esta en la agenda, sabemos que el telefono viene vacio, asi que lo borramos
	  		if (in_array($inputNombre, $almacenContactos)) {
  				$posicion = array_search($inputNombre, $almacenContactos);
  				unset($almacenContactos[$posicion]);
  				unset($almacenNumeros[$posicion]);
  				$almacenContactos = array_values($almacenContactos);
  				$almacenNumeros = array_values($almacenNumeros);
  				if (count($almacenContactos) < 1) {
  					$hayContactos = false;
  				}
  			} else {
  				$numeroVacio = true;
  			}
  			$almacenContactos = implode(',', $almacenContactos);
  			$almacenNumeros = implode(',', $almacenNumeros); 
			} else {
				//de no estar en la agenda, enviamos el mensaje de error de que no puede agregar un nuevo contacto con el numero vacio
				$numeroVacio = true;
			}			
		}
	}
	else {
		//ha entrado por GET, es decir, por primera vez y no hay que tratar nada
		$contactoVacio = false;
		$numeroVacio = false;
	}

	?>

  <form action="" method="post">
  	<fieldset>
  		<legend>Agregar contacto:</legend>
  		<input type="hidden" name="almacenContactos" value="<?php echo $almacenContactos; ?>">
  		<input type="hidden" name="almacenNumeros" value="<?php echo $almacenNumeros; ?>">
  		Nombre: <input type="text" name="nombreContacto"><br>
  		<?php 
  			if ($contactoVacio == true) {
  				echo '<span class="error">El nombre de contacto no puede estar vacio</span><br>';
  			}
  		?>
  		Número: <input type="text" name="numeroTlf"><br>
   		<?php 
  			if ($numeroVacio == true) {
  				echo '<span class="error">El campo no puede estar vacio y tiene que ser numérico</span><br>';
  			}
  		?>
  		<input type="submit" value="Guardar contacto">
  	</fieldset>
  </form>

  <?php
  	if ($hayContactos == true) {
  		/*
			Si hay contactos, montamos una tabla con cada uno de ellos y su respectivo numero de telefono
  		*/
	  	$almacenContactos = explode(',', $almacenContactos);
	  	$almacenNumeros = explode(',', $almacenNumeros);
			$output = "<h3>Agenda (".count($almacenContactos).")</h3><table><thead><tr><th>Contacto: </th><th>Número: </th></tr></thead><tbody>";
			for ($i=0; $i<count($almacenContactos); $i++) {
	      $output.='<tr><td>'.$almacenContactos[$i].'</td><td>'.$almacenNumeros[$i].'</td></tr>';
	    }
			echo $output;
  	} 
  ?>

</body>
</html>