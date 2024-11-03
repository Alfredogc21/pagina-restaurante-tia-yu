<?php
session_start();

// Hacemos la conexión a la base de datos
require 'conexion/conexion.php';

$errores = 0;

if (isset($_SESSION['usuarios'])) {
    $email = $_SESSION['usuarios'];
    $consultarRol = $conexion->prepare('SELECT idRoles FROM usuarios WHERE correoElectronico = :correo');
    $consultarRol->execute(array(':correo' => $email));
    $resultadoConsulta = $consultarRol->fetch();

    if ($resultadoConsulta['idRoles'] == 1) { // Administrador
        header('Location: administrador/dashboard.php');
    } else if ($resultadoConsulta['idRoles'] == 2) { // Empleado
        header('Location: empleado/dashboard.php');
    } else if ($resultadoConsulta['idRoles'] == 3) { // Cliente
        header('Location: cliente/dashboard.php');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Correo = isset($_POST['usuario']) ? $_POST['usuario'] : null;
    $password = isset($_POST['Contrasena']) ? $_POST['Contrasena'] : null;

    // Validar que no estén vacíos
    if (empty($Correo) || empty($password)) {
        echo "<script>
                alert('Todos los campos son obligatorios');
                window.location = 'login.php';
            </script>";
    } else {
        // Consultar si el usuario existe solo por correo
        $q = $conexion->prepare("SELECT * FROM usuarios WHERE correoElectronico = :correo");
        $q->execute(array(':correo' => $Correo));

        $usuario = $q->fetch();

        if ($usuario && password_verify($password, $usuario['password'])) {
            // Contraseña correcta
            $_SESSION['usuarios'] = $Correo;

            // Redireccionar según el rol del usuario
            if ($usuario['idRoles'] == 1) { // Administrador
                header('Location: administrador/dashboard.php');
            } else if ($usuario['idRoles'] == 2) { // Empleado
                header('Location: empleado/dashboard.php');
            } else if ($usuario['idRoles'] == 3) { // Cliente
                header('Location: cliente/dashboard.php');
            }
        } else {
            // Datos incorrectos
            echo '
                <script>
                    alert("Datos incorrectos");
                    window.location = "signup.php";
                </script>';
        }
    }
}

require "views/login.view.php";
