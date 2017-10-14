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
  <table>
    <thead>
    <tr>
  <?php
    $output = "<th>Array sin ordenar</th><th>Ordenada por burbuja</th><th>Ordenada por intercambio</th></tr></thead><tbody>";
    $garbage = [
                [1],
                [1,2],
                [2,1],
                [0,0,2,2],
                [0,0,-2,2,-17,17,4],
                [9,8,7,6,5,4,3,2,1,0],
                [0,0,0,0,0,0,0,0,1,0],
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

    foreach($garbage as $g) {
      $output.='<tr>';
      $output.='<td>'.implode(', ', $g).'</td>';
      $burbuja = ordenar_array_por_burbuja($g);
      $output.='<td>'.implode(', ', $burbuja).'</td>';
      $intercambio = ordenar_array_por_intercambio($g);
      $output.='<td>'.implode(', ', $intercambio).'</td>';
    }
    
    echo $output;
  ?>
</body>
</html>