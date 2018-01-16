<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'pdo/Conexion.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Testing</title>
</head>
<body>
    <h1>Testing BBDD connections</h1>
    <?php
        $conexion = new Conexion();
        $conexion->insert('INSERT INTO test(nombre) VALUES ("Crypthat")');

        $aplicaciones = $conexion->select('SELECT * FROM test');
        foreach($aplicaciones as $aplicacion){
            echo $aplicacion->nombre;
            echo '<br>';
        }
        
        echo '<br><br><br><br>';
        $aplicacionCrypthat = $conexion->select('SELECT * FROM test WHERE nombre = :nombre', ['nombre' => 'Crypthat']);
        foreach($aplicacionCrypthat as $aplicacion){
            echo $aplicacion->nombre;
            echo '<br>';
        }
        echo '<br><br><br><br>';
        $aplicacionTest = $conexion->select('SELECT * FROM test WHERE nombre = :nombre', ['nombre' => 'ok']);
        foreach($aplicacionTest as $aplicacion){
            echo $aplicacion->nombre;
            echo '<br>';
        }
    ?>
</body>
</html>