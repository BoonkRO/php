<?php

include 'pdo/Conexion.php';
$db = null;
try{
    $connect = new PDO("mysql:host=localhost;dbname=test", 'root', '');
    $db = $connect;
} catch(PDOException $e){
    echo $e->getMessage();
}
$aplicaciones = [];
$aplicaciones = $db->query('INSERT INTO aplicaciones(nombre) VALUES ("Restaurante a la carta")');