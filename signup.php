<?php session_start();

//Hacemos la conexion a la base de datos
require 'conexion/conexion.php';

if (isset($_SESSION['usuarios'])) {
    $email = $_SESSION['usuarios'];
    $consultarROl = $conexion->prepare('SELECT roles_id FROM usuarios WHERE correo = :correo');
    $consultarROl->execute(array(':correo' => $email));
$resultadoConsulta = $consultarROl->fetch();

    if($resultadoConsulta['roles_id'] == 2){ // El cliente
        header('Location: dashboard.php');
    } else if($resultadoConsulta['roles_id'] == 1){ // Si es administrador
        header('Location: admin/dashboard.php');
    }
}

if ($_POST['cedula'] && $_POST['nombre1'] && $_POST['apellido1'] && $_POST['correo'] && $_POST['password'] && $_POST['telefono']) {

    $cedula = $_POST['cedula'];
    $nombre1 = $_POST['nombre1'];
    $nombre2 = $_POST['nombre2'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Encriptar la contraseña usando password_hash
    $password_encriptada = password_hash($password, PASSWORD_DEFAULT);

    // Buscar si ya existe un cliente con esa cédula
    $buscar_clientes = $conexion->prepare("SELECT * FROM cliente WHERE Cedula = :cedula");
    $buscar_clientes->bindParam(":cedula", $cedula);
    $buscar_clientes->execute();
    $cliente_encontrado = $buscar_clientes->fetch(PDO::FETCH_ASSOC);

    if (empty($cliente_encontrado)) {
        // Registrar nuevo cliente

        if (empty($nombre2) && empty($apellido2)) {
            $registrar_cliente = $conexion->prepare("INSERT INTO cliente (Cedula, P_Nombre, P_Apellidos, Correo_Electronico, Contrasena) VALUES (:cedula, :nombre1, :apellido1, :correo, :password)");

            $registrar_cliente->bindParam(":cedula", $cedula);
            $registrar_cliente->bindParam(":nombre1", $nombre1);
            $registrar_cliente->bindParam(":apellido1", $apellido1);
            $registrar_cliente->bindParam(":correo", $correo);
            $registrar_cliente->bindParam(":password", $password_encriptada);
        } elseif (empty($nombre2)) {
            $registrar_cliente = $conexion->prepare("INSERT INTO cliente (Cedula, P_Nombre, P_Apellidos, S_Apellido, Correo_Electronico, Contrasena) VALUES (:cedula, :nombre1, :apellido1, :apellido2, :correo, :password)");

            $registrar_cliente->bindParam(":cedula", $cedula);
            $registrar_cliente->bindParam(":nombre1", $nombre1);
            $registrar_cliente->bindParam(":apellido1", $apellido1);
            $registrar_cliente->bindParam(":apellido2", $apellido2);
            $registrar_cliente->bindParam(":correo", $correo);
            $registrar_cliente->bindParam(":password", $password_encriptada);
        } elseif (empty($apellido2)) {
            $registrar_cliente = $conexion->prepare("INSERT INTO cliente (Cedula, P_Nombre, S_Nombre, P_Apellidos, Correo_Electronico, Contrasena) VALUES (:cedula, :nombre1, :nombre2, :apellido1, :correo, :password)");

            $registrar_cliente->bindParam(":cedula", $cedula);
            $registrar_cliente->bindParam(":nombre1", $nombre1);
            $registrar_cliente->bindParam(":nombre2", $nombre2);
            $registrar_cliente->bindParam(":apellido1", $apellido1);
            $registrar_cliente->bindParam(":correo", $correo);
            $registrar_cliente->bindParam(":password", $password_encriptada);
        } else {
            $registrar_cliente = $conexion->prepare("INSERT INTO cliente (Cedula, P_Nombre, S_Nombre, P_Apellidos, S_Apellido, Correo_Electronico, Contrasena) VALUES (:cedula, :nombre1, :nombre2, :apellido1, :apellido2, :correo, :password)");

            $registrar_cliente->bindParam(":cedula", $cedula);
            $registrar_cliente->bindParam(":nombre1", $nombre1);
            $registrar_cliente->bindParam(":nombre2", $nombre2);
            $registrar_cliente->bindParam(":apellido1", $apellido1);
            $registrar_cliente->bindParam(":apellido2", $apellido2);
            $registrar_cliente->bindParam(":correo", $correo);
            $registrar_cliente->bindParam(":password", $password_encriptada);
        }


        if ($registrar_cliente->execute()) {
            $_SESSION['cedula'] = $cedula;
            echo "ID DE LA SESION: ", $_SESSION['cedula'];
        } else {
            echo "Error al registrar cliente";
        }
    } else {
        echo "Este usuario ya esta registrado";
    }
} else {
    echo "Datos no recibidos";
}

require "signup.view.php" ;


?>