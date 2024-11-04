<?php session_start();

// Validamos si hay una sesion
if (isset($_SESSION['usuarios'])) {
    $correo = $_SESSION['usuarios'];

	//Hacemos la conexion a la base de datos
	require '../conexion/conexion.php';

    // Conocer el rol del usuario
    $consultarROl = $conexion->prepare('SELECT idRoles, p_Nombre, p_Apellido FROM usuarios WHERE correoElectronico = :correo');
    $consultarROl->execute(array(':correo' => $correo));
    $resultadoConsulta = $consultarROl->fetch();

    //Nombre y apellido del usuario
    $nombreUsuario = $resultadoConsulta['p_Nombre'] . ' ' . $resultadoConsulta['p_Apellido'];


    if ($resultadoConsulta['idRoles'] == 1) { // Administrador
        require 'views/dashboard.view.php';
    } else if ($resultadoConsulta['idRoles'] == 2) { // Empleado
        header('Location: ../empleado/dashboard.php');
    } else if ($resultadoConsulta['idRoles'] == 3) { // Cliente
        header('Location: ../cliente/dashboard.php');
    }

} else {
    // Devolvemos al login
    header('Location: ../login.php');
}

