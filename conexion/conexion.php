<?php

    //Hacemos la conexion a la base de datos
    try {
        $conexion = new PDO('mysql:host=localhost;dbname=educasen', 'root', '');
        $conexion->exec("SET CHARACTER SET utf8");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        die("Error en el servidor");
    }

?>