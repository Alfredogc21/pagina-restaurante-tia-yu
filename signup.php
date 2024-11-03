<?php session_start();

//Hacemos la conexion a la base de datos
require 'conexion/conexion.php';

if (isset($_SESSION['usuarios'])) {
    $email = $_SESSION['usuarios'];
    $consultarROl = $conexion->prepare('SELECT idRoles FROM usuarios WHERE correoElectronico = :correo');
    $consultarROl->execute(array(':correo' => $email));
$resultadoConsulta = $consultarROl->fetch();

    if($resultadoConsulta['idRoles'] == 2){ // El usuarios
        header('Location: dashboard.php');
    } else if($resultadoConsulta['idRoles'] == 1){ // Si es administrador
        header('Location: admin/dashboard.php');
    }
}

if (isset($_POST['cedula']) && isset($_POST['nombre1']) && isset($_POST['apellido1']) && isset($_POST['correo']) && isset($_POST['password']) && isset($_POST['telefono'])) {

    $cedula = $_POST['cedula'];
    $nombre1 = $_POST['nombre1'];
    $nombre2 = $_POST['nombre2'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    //var_dump($_POST);


    // Encriptar la contraseña usando password_hash
    $password_encriptada = password_hash($password, PASSWORD_DEFAULT);

    // Buscar si ya existe un usuarios con esa cédula
    $buscar_clientes = $conexion->prepare("SELECT * FROM usuarios WHERE cedula = :cedula");
    $buscar_clientes->bindParam(":cedula", $cedula);
    $buscar_clientes->execute();
    $cliente_encontrado = $buscar_clientes->fetch(PDO::FETCH_ASSOC);

    if (empty($cliente_encontrado)) {
        // Registrar nuevo usuarios

        if (empty($nombre2) && empty($apellido2)) {
            $registrar_cliente = $conexion->prepare("INSERT INTO usuarios (cedula, p_Nombre, p_Apellidos, telefono, correoElectronico, password, idRoles, idDispon) VALUES (:cedula, :nombre1, :apellido1, :telefono, :correo, :password, 2, 1)");

            $registrar_cliente->bindParam(":cedula", $cedula);
            $registrar_cliente->bindParam(":nombre1", $nombre1);
            $registrar_cliente->bindParam(":apellido1", $apellido1);
            $registrar_cliente->bindParam(":telefono", $telefono);
            $registrar_cliente->bindParam(":correo", $correo);
            $registrar_cliente->bindParam(":password", $password_encriptada);
        } elseif (empty($nombre2)) {
            $registrar_cliente = $conexion->prepare("INSERT INTO usuarios (cedula, p_Nombre, p_Apellidos, s_Apellido, telefono, correoElectronico, password, idRoles, idDispon) VALUES (:cedula, :nombre1, :apellido1, :apellido2, :telefono, :correo, :password, 2, 1)");

            $registrar_cliente->bindParam(":cedula", $cedula);
            $registrar_cliente->bindParam(":nombre1", $nombre1);
            $registrar_cliente->bindParam(":apellido1", $apellido1);
            $registrar_cliente->bindParam(":apellido2", $apellido2);
            $registrar_cliente->bindParam(":telefono", $telefono);
            $registrar_cliente->bindParam(":correo", $correo);
            $registrar_cliente->bindParam(":password", $password_encriptada);
        } elseif (empty($apellido2)) {
            $registrar_cliente = $conexion->prepare("INSERT INTO usuarios (cedula, p_Nombre, s_Nombre, p_Apellidos, telefono, correoElectronico, password, idRoles, idDispon) VALUES (:cedula, :nombre1, :nombre2, :apellido1, :telefono, :correo, :password, 2, 1)");

            $registrar_cliente->bindParam(":cedula", $cedula);
            $registrar_cliente->bindParam(":nombre1", $nombre1);
            $registrar_cliente->bindParam(":nombre2", $nombre2);
            $registrar_cliente->bindParam(":apellido1", $apellido1);
            $registrar_cliente->bindParam(":telefono", $telefono);
            $registrar_cliente->bindParam(":correo", $correo);
            $registrar_cliente->bindParam(":password", $password_encriptada);
        } else {
            $registrar_cliente = $conexion->prepare("INSERT INTO usuarios (cedula, p_Nombre, s_Nombre, p_Apellidos, s_Apellido, telefono, correoElectronico, password, idRoles, idDispon) VALUES (:cedula, :nombre1, :nombre2, :apellido1, :apellido2, :telefono, :correo, :password, 2, 1)");

            $registrar_cliente->bindParam(":cedula", $cedula);
            $registrar_cliente->bindParam(":nombre1", $nombre1);
            $registrar_cliente->bindParam(":nombre2", $nombre2);
            $registrar_cliente->bindParam(":apellido1", $apellido1);
            $registrar_cliente->bindParam(":apellido2", $apellido2);
            $registrar_cliente->bindParam(":telefono", $telefono);
            $registrar_cliente->bindParam(":correo", $correo);
            $registrar_cliente->bindParam(":password", $password_encriptada);
        }


        if ($registrar_cliente->execute()) {
            $_SESSION['cedula'] = $cedula;
            //echo "ID DE LA SESION: ", $_SESSION['cedula'];
            echo "<script> alert('Usuario Registrado, Incia sesion') </script>";

            header("Refresh: 1; url=login.php");
            exit();



        } else {
            echo "<script> alert('Error al registrar usuarios') </script>";
        }
    } else {
        //echo "<script> alert('Usuario Registrado') </script>";
    }
} else {
    //echo "Datos no recibidos";
}

require "views/signup.view.php" ;


?>