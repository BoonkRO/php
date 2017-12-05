<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 5 - Guillermo Cirer</title>
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
  <h3> Arrays precargadas </h3>

  <?php
    //Inicializamos las arrays precargadas
    $garbage = [
      [1],
      [1,2],
      [2,1],
      [0,0,2,2],
      [0,0,-2,2,-17,17,4],
      [9,8,7,6,5,4,3,2,1,0],
      [0,0,0,0,0,0,0,0,1,0],
      [1,2,3,4,5,6,7,8,9],
    ];
    //Creamos un array con todos los metodos de ordenacion de los que disponemos
    $sorts = [
      'ordenar_array_por_burbuja',
      'ordenar_array_por_intercambio',
      'ordenar_array_por_quick_sort',
    ];
    //obtenemos los valores de las variables que vienen por POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $sort = $_POST['metodoOrdenacion']; //de este modo sabemos que metodo tenemos que aplicar
      if (isset($sort)) {
        //sabiendo el metodo, formateamos el nombre para posterior uso en el html
        $methodName=str_replace('_', ' ', $sorts[$sort]);     
      }
    }
    
    function assert_failed() {
      //personalizamos el mensaje del assert
      print "El algoritmo de ordenacion burbuja no ha podido ser verificado con el metodo sort()
       proporcionado por PHP";
      echo '<br>';
    }
    
    function ordenar_array_por_burbuja($garbage) {
      //Metodo escogido para comprobar mediante un assert
      $input = $garbage;
      do {
        $swap = false;
        for ($i=0; $i<count($garbage)-1; $i++) {
          $temp = $garbage[$i];
          if ($garbage[$i] > $garbage[$i+1]) {
            $garbage[$i] = $garbage[$i+1];
            $garbage[$i+1] = $temp;
            $swap = true;
          }
        }
      }
      while ($swap);
      //comprobamos que el resultado que va a devolver es igual que el que devolveria el metodo sort() de PHP
      $verify = sort($input);
      assert_options (ASSERT_CALLBACK, 'assert_failed');
      assert_options (ASSERT_WARNING, 0);
      assert($verify == $garbage);
      return $garbage;
    }

    function ordenar_array_por_intercambio($garbage) {
      for($i=0; $i<count($garbage); $i++) {
        $lowest = $garbage[$i];
        $j = $i;
        $index = $i;
        while($j < count($garbage)) {
          if($garbage[$j] < $lowest) {
            $lowest = $garbage[$j];
            $index = $j;
          }
          $j++;
        }
        $garbage[$index] = $garbage[$i];
        $garbage[$i] = $lowest;
      }
      return $garbage;    
    }

    function ordenar_array_por_quick_sort($garbage) {
      $length = count($garbage);
      //caso base: si la array es mas pequeña que 0 entonces no hace falta ordenar
      if ($length <= 1) {
        return $garbage;
      } else {
        //seleccionamos un numero como pivote, en este caso el primero que aparece
        $pivot = $garbage[0];
        //declaramos dos arrays que actuan como particiones
        $left = $right = array();
        //recorremos y comparamos cada numero en la array con el valor del pivote, y lo colocamos en el puesto que corresponde
        for($i = 1; $i < count($garbage); $i++) {
          if($garbage[$i] < $pivot) {
            $left[] = $garbage[$i];
          } else {
            $right[] = $garbage[$i];
          }
        }
        //usamos recursion para ordenar las arrays que quedan a la izquierda y a la derecha
        return array_merge(ordenar_array_por_quick_sort($left), array($pivot), ordenar_array_por_quick_sort($right));
      }
    }
    //construimos una tabla de resultados
    $output = "<table><thead><tr><th>Array sin ordenar</th><th>Ordenada por burbuja</th><th>Ordenada por intercambio</th><th>Ordenada por quick sort</th></tr></thead><tbody>";
    /*por cada array precargado mostramos los valores en la primera columna de la tabla
    por cada metodo en la lista de sorts, añadimos una columna en la que mostraremos el resultado de haber 
    aplicado dicho sort al array precargado que estemos leyendo en ese momento*/
    foreach ($garbage as $g) {
      $output.='<tr><td>'.implode(', ', $g).'</td>';
        foreach ($sorts as $s) {
            $output.='<td>'.implode(', ', $s($g)).'</td>';
        }
      $output.='</tr>';
    };
    $output.='</tbody></table>';
    echo $output;
  ?>

  <hr><h3>1. Generacion aleatoria de Arrays</h3>
  <form action="" method="post" enctype="multipart/form-data">
  Cantidad de numeros a generar: <input type="number" name="cantidadNumeros">
  <br><br>

  <?php
    //si tenemos la variable por parte del usuario inicializaremos la construccion aleatoria del array
    if (isset($_POST['cantidadNumeros']) && $_POST['cantidadNumeros'] > 0) {
      $size = $_POST['cantidadNumeros'];
      $garbage = [];
      //creamos tantos numeros como nos ha introducido el usuario, limitamos el tamaño de estos por legibilidad
      for ($i=0; $i<$size; $i++) {
        $garbage[$i] = rand(0, 80);
      }
      //una vez construido el array aleatorio, lo pasamos por el metodo de sort que se haya elegido y construimos una
      //tabla de resultados
      $output = '<table><thead><tr><th>Array generada aleatoriamente</th><th>Despues de '.$methodName.' </th></tr></thead><tbody><tr>';
      $output.='<td>'.implode(', ', $garbage).'</td>';
      $sortedArray = $sorts[$sort]($garbage);
      $output.='<td>'.implode(', ', $sortedArray).'</td>';
      $output.='</tbody></table>';
      echo $output;
    }
  ?>

  <br><hr><h3>2. Introducir array manualmente</h3>
  Array (números enteros separados por comas): <input type="text" name="arrayManual">
  <br><br>
  <?php
    if (isset($_POST['arrayManual']) && $_POST['arrayManual'] != "") {
      //comprobaremos que el input cumple con el formato pedido => ejemplo: 1, 4, 5, 2, 6
      $input = $_POST['arrayManual'];
      $input = str_replace(' ', '', $input);
      $garbage = explode(',', $input);
      $garbage_are_numbers = true;
      foreach($garbage as $value) {
        if (!is_numeric($value)) {
          $garbage_are_numbers = false;
        }
      }
      //construimos tabla de resultados
      if ($garbage_are_numbers == true) {
        $output = '<table><thead><tr><th>Array introducida</th><th>Despues de '.$methodName.' </th></tr></thead><tbody><tr>';
        $output.='<td>'.implode(', ', $garbage).'</td>';
        $sortedArray = $sorts[$sort]($garbage);
        $output.='<td>'.implode(', ', $sortedArray).'</td>';
        $output.='</tbody></table>';  
        echo $output;
      } else {
        //de no haberse cumplido el formato solicitado avisaremos al usuario
        $output = '<h4 class="error">Por favor, introduce valores númericos enteros!</h4>';
        echo $output;
      }
    }
  ?>

  <br><hr><h3>3. Cargar array por archivo</h3>
  Selecciona archivo (txt, json):  <input type="file" name="archivoSubido" id="archivoSubido">
  <br><br>

  <?php
    if (isset($_FILES['archivoSubido']['name']) && $_FILES['archivoSubido']['name'] != "") {
      //obtenemos la posicion en la que se encuentra el . en el archivo subido
      $point = strpos($_FILES['archivoSubido']['name'], '.');
      //una vez tenemos el . leemos el resto del string para saber la extension (.txt o .json soportados)
      $extension = substr($_FILES['archivoSubido']['name'], $point, strlen($_FILES['archivoSubido']['name']));
      //cargamos el archivo en memoria
      $file_content = file_get_contents($_FILES['archivoSubido']['tmp_name']);
      //construimos la cabecera de la tabla de resultados
      $output = '<table><thead><tr><th>Array cargada de ['.$_FILES['archivoSubido']['name'].']</th><th>Despues de '.$methodName.' </th></tr></thead><tbody><tr>';
      if ($extension == '.json') {
        //si el archivo es un json lo decodificamos (ya que al estar cargado en memoria es un string) para 
        //poder tratarlo y aplicarle el sort. Finalmente construimos el cuerpo de la tabla de resultado
        $json_file = json_decode($file_content, true);
        $output.='<td>'.implode(', ', $json_file['array']).'</td>';
        $sortedArray = $sorts[$sort]($json_file['array']);
        $output.='<td>'.implode(', ', $sortedArray).'</td>';
        $output.='</tbody></table>';  
        echo $output;
      }
      else if ($extension == '.txt') {
        //si el archivo es un txt lo tratamos (ya que al estar cargado en memoria es un string) para 
        //poder aplicarle el sort. Finalmente construimos el cuerpo de la tabla de resultado
        $garbage = explode(', ', $file_content);
        $output.='<td>'.implode(', ', $garbage).'</td>';
        $sortedArray = $sorts[$sort]($garbage);
        $output.='<td>'.implode(', ', $sortedArray).'</td>';
        $output.='</tbody></table>';  
        echo $output;        
      }
      else {
        //si el archivo no era ni txt ni json avisamos al usuario
        echo '<h4 class="error">El formato del archivo no está soportado<h4>';
      }
    } 
  ?>

  <br><br><hr>

  <h3>4. Elige un método de ordenacion</h3>
  Métodos: 
  <?php 
    //creamos un select que tendra como opciones cada metodo cargado en la lista de sorts.
    //el valor que pasaremos por post sera la posicion del metodo en la array (0, 1, 2)
    $output='<select name="metodoOrdenacion">';
    foreach($sorts as $i=>$s) {
      $output.='<option value="'.$i.'">'.str_replace('_', ' ', $s).'</option>';
    }
    echo $output;
  ?>
  <input type="submit">

  </form>
  <br>

</body>
</html>