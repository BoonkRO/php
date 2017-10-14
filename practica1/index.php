<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Practica 1</title>
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
            $th = [
                'Contenido de $var',
                'isset($var)',
                'empty($var)', 
                '(bool) $var',
            ];
            foreach ($th as $value) {
                echo "<th>".$value."</th>";
            }
        ?>
    </tr>
    </thead>
    <tbody>
        <?php
            function myIsSet($variable) {
                return isset($variable) ? 'true' : 'false';
            }
            function myIsEmpty($variable) {
                return empty($variable) ? 'true' : 'false';
            }
            function myBoolean($variable) {
                return (bool) $variable ? 'true' : 'false';
            }
            $values = [null, 0, true, false, "0", "", "foo", array()];
            $str_values = ['null', '0', 'true', 'false', '"0"', '""', 'foo', 'array()'];
            $funcs = ['myIsSet', 'myIsEmpty', 'myBoolean'];
            $output = '';
            foreach ($values as $i=>$var) {
                $output.='<tr><td>$var = '.$str_values[$i].'</td>';
                foreach ($funcs as $f) {
                    $output.='<td>'.$f($var).'</td>';
                }
                $output.='</tr>';
            };
            echo $output;
        ?>
    </tbody>
    </table>

    <?php 
        // echo '';
        // $x=5;
        // echo 'x vale '.$x.'<br>';
        // $y=10;
        // function myTest() {
        //     $GLOBALS['y']=$GLOBALS['x']+$GLOBALS['y'];
        // }
        // myTest();
        // echo $y;
        // una variable declarada como global dentro de una funcion solo existira en el 
        // el ambito global despues de ejecutarse la funcion
    ?>

    <?php 
        // 'la variable estatica dentro de una funcion conserva el valor en llamadas sucesivas a esa funcion'

        // las superglobales se crean al ejecutarse el script

        // si envias una variable por get y por post cual tiene prioridad? p. examen

        // como saber cuantas veces un usuario accede a la web? p.examen
    ?>
</body>
</html>