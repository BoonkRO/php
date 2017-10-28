<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Practica 2</title>
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
    </style>
</head>

<body>
  <h3> Arrays precargadas </h3>

  <?php
    $output = "<table><thead><tr><th>Array sin ordenar</th><th>Ordenada por burbuja</th><th>Ordenada por intercambio</th><th>Ordenada por quick sort</th></tr></thead><tbody>";
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

    $sorts = [
      'ordenar_array_por_burbuja',
      'ordenar_array_por_intercambio',
      'ordenar_array_por_quick_sort',
    ];

    function ordenar_array_por_burbuja($garbage) {
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
      // find array size
      $length = count($garbage);
      // base case test, if array of length 0 then just return array to caller
      if ($length <= 1) {
        return $garbage;
      } else {
        // select an item to act as our pivot point, since list is unsorted first position is easiest
        $pivot = $garbage[0];
        // declare our two arrays to act as partitions
        $left = $right = array();
        // loop and compare each item in the array to the pivot value, place item in appropriate partition
        for($i = 1; $i < count($garbage); $i++) {
          if($garbage[$i] < $pivot) {
            $left[] = $garbage[$i];
          } else {
            $right[] = $garbage[$i];
          }
        }
        // use recursion to now sort the left and right lists
        return array_merge(ordenar_array_por_quick_sort($left), array($pivot), ordenar_array_por_quick_sort($right));
      }
    }

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

  <hr><h3>Generacion aleatoria de Arrays</h3>
  <form action="" method="get">
  Cantidad de numeros a generar: <input type="number" name="cantidadNumeros">
  Elige un método de ordenación: 
  <?php 
    $output='<select name="metodoOrdenacion">';
    foreach($sorts as $i=>$s) {
      $output.='<option value="'.$i.'">'.str_replace('_', ' ', $s).'</option>';
    }
    echo $output;
  ?>

  <input type="submit">
  <br><br>
  <?php
    if (isset($_GET['cantidadNumeros']) && $_GET['cantidadNumeros'] > 0) {
      $size = $_GET['cantidadNumeros'];
      $sort = $_GET['metodoOrdenacion'];
      $garbage = [];
      for ($i=0; $i<$size; $i++) {
        $garbage[$i] = rand(0, 80);
      }
      $method=str_replace('_', ' ', $sorts[$sort]);

      $output = '<table><thead><tr><th>Array generada aleatoriamente</th><th>Despues de '.$method.' </th></tr></thead><tbody><tr>'; 
      $output.='<td>'.implode(', ', $garbage).'</td>';
      $outputSort = $sorts[$sort]($garbage);
      $output.='<td>'.implode(', ', $outputSort).'</td>';
      $output.='</tbody></table>';
      echo $output;
    }
  ?>
  <br><hr><h3>Introducir array manualmente</h3>

  Array: <input type="text" name="arrayManual">
  <input type="submit">
  <br><br>
  <?php
    if (isset($_GET['arrayManual']) && $_GET['arrayManual'] != "") {
      $input = $_GET['arrayManual'];
      $garbage = [2,32,5];
      $output = '<table><thead><tr><th>Array generada</th><th>Ordenada por burbuja</th><th>Ordenada por intercambio</th><th>Ordenada por quick sort</th></tr></thead><tbody><tr>'; 
      $output.='<td>'.implode(', ', $garbage).'</td>';
      $burbuja = ordenar_array_por_burbuja($garbage);
      $output.='<td>'.implode(', ', $burbuja).'</td>';
      $intercambio = ordenar_array_por_intercambio($garbage);
      $output.='<td>'.implode(', ', $intercambio).'</td>';
      $quick_sort = ordenar_array_por_quick_sort($garbage);
      $output.='<td>'.implode(', ', $quick_sort).'</td>';
      $output.='</tbody></table>';
      echo $output;
    }
  ?>
  <br><hr><h3>Cargar array por archivo</h3>

  Selecciona archivo (txt, json, xml):  <input type="file" name="archivoSubido" id="archivoSubido">
  <input type="submit">
  <br><br>

  </form>
  <br>

</body>
</html>