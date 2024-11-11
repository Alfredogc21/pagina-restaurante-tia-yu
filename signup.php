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

if (isset($_POST['cedula']) && isset($_POST['nombres']) && isset($_POST['apellidos']) && isset($_POST['correo']) && isset($_POST['password']) && isset($_POST['telefono'])) {

    $cedula = $_POST['cedula'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];

    // Validar que las contraseñas coincidan
    if ($password !== $passwordConfirm) {
        echo "<script> alert('Las contraseñas no coinciden. Intenta nuevamente.') </script>";
    } else {
        // Encriptar la contraseña usando password_hash
        $password_encriptada = password_hash($password, PASSWORD_DEFAULT);

        // Buscar si ya existe un usuarios con esa cédula
        $buscar_clientes = $conexion->prepare("SELECT * FROM usuarios WHERE cedula = :cedula");
        $buscar_clientes->bindParam(":cedula", $cedula);
        $buscar_clientes->execute();
        $cliente_encontrado = $buscar_clientes->fetch(PDO::FETCH_ASSOC);

        if (empty($cliente_encontrado)) {
            // Registrar nuevo usuarios

            if (!empty($nombres) && !empty($apellidos)) {
                $registrar_cliente = $conexion->prepare("INSERT INTO usuarios (cedula, nombres, apellidos, telefono, correoElectronico, password, idRoles, idEstadoUsuario) VALUES (:cedula, :nombres, :apellidos, :telefono, :correo, :password, 3, 1)");

                $registrar_cliente->bindParam(":cedula", $cedula);
                $registrar_cliente->bindParam(":nombres", $nombres);
                $registrar_cliente->bindParam(":apellidos", $apellidos);
                $registrar_cliente->bindParam(":telefono", $telefono);
                $registrar_cliente->bindParam(":correo", $correo);
                $registrar_cliente->bindParam(":password", $password_encriptada);
            }


            if ($registrar_cliente->execute()) {
                $_SESSION['cedula'] = $cedula;
                echo "<script> alert('Usuario Registrado, Incia sesion') </script>";

                header("Refresh: 1; url=login.php");
                exit();

            } else {
                echo "<script> alert('Error al registrar usuarios') </script>";
            }
        } else {
            echo "<script> alert('Usuario Registrado') </script>";
        }
    }
} else {
    //echo "Datos no recibidos";
}

require "views/signup.view.php" ;


?>