<?php session_start();

//Hacemos la conexion a la base de datos
require 'conexion/conexion.php';

if (isset($_SESSION['usuarios'])) {
    // $email = $_SESSION['usuarios'];
    // $consultarROl = $conexion->prepare('SELECT roles_id FROM usuarios WHERE correo = :correo');
    // $consultarROl->execute(array(':correo' => $email));
    // $resultadoConsulta = $consultarROl->fetch();

    // if($resultadoConsulta['roles_id'] == 2){ // El cliente
    //     header('Location: dashboard.php');
    // } else if($resultadoConsulta['roles_id'] == 1){ // Si es administrador
    //     header('Location: admin/dashboard.php');
    // }
} else {
    header('Location: views/index.view.php');
}

?>