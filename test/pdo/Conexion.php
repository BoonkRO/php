<?php
/**
 * Clase 'Conexion' en la que se englobarán las funciones básicas de mysqli
 * para poder utilizarla en futuros proyectos. Entre las características
 * se pueden destacar:
 *  - Auto-conexión a bbdd predefinida
 *  - Cierre automático de conexión después de cada consulta
 *  - Devolver la consulta como un array de objetos
 */

class Conexion {
    private $host = 'localhost';
    private $DBname = 'testing';
    private $user = 'root';
    private $pass = '';
    private $error = '';
    private $conexion = null;

    function __construct(){
        try{
            $connect = new PDO("mysql:host=$this->host;dbname=$this->DBname", $this->user, $this->pass);
            $this->conexion = $connect;
        } catch(PDOException $e){
            $this->error = $e->getMessage();
        }
    }

    function host_info(){
        return $this->conexion->host_info;
    }

    function select(String $query, array $params = []){
        if(count($params) == 0){ // Si es una query sin parámetros
            $array = [];
            $stmt = $this->conexion->query($query);
            while($row = $stmt->fetchObject()){
                array_push($array, $row);
            }
            return $array;
        } else { // Si es una query con parámetros
            $stmt = $this->conexion->prepare($query);
            $stmt->execute($params);
            $array = [];
            while($row = $stmt->fetchObject()){
                array_push($array, $row);
            }
            return $array;
        }
    }

    function insert(String $query){
        return $this->conexion->query($query);
    }

    function update(){
        return $this->conexion->query($query);
    }

    function delete(){
        return $this->conexion->query($query);
    }

    function errors(){
        return $this->error;
    }

}