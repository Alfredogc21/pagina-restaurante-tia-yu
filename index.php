<?php session_start();

//Hacemos la conexion a la base de datos
require 'conexion/conexion.php';

if (isset($_SESSION['usuarios'])) {
    $email = $_SESSION['usuarios'];
    $consultarROl = $conexion->prepare('SELECT idRoles FROM usuarios WHERE correoElectronico = :correo');
    $consultarROl->execute(array(':correo' => $email));
    $resultadoConsulta = $consultarROl->fetch();

    if ($resultadoConsulta['idRoles'] == 1) { // Administrador
        require 'views/dashboard.view.php';
    } else if ($resultadoConsulta['idRoles'] == 2) { // Empleado
        header('Location: ../empleado/dashboard.php');
    } else if ($resultadoConsulta['idRoles'] == 3) { // Cliente
        header('Location: ../cliente/dashboard.php');
    }
} else {
    require 'views/index.view.php';
}

?>