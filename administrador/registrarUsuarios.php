<?php session_start();

// Validamos si hay una sesion
if (isset($_SESSION['usuarios'])) {
    $correo = $_SESSION['usuarios'];

	//Hacemos la conexion a la base de datos
	require '../conexion/conexion.php';

    // Conocer el rol del usuario
    $consultarROl = $conexion->prepare('SELECT idRoles, nombres, apellidos FROM usuarios WHERE correoElectronico = :correo');
    $consultarROl->execute(array(':correo' => $correo));
    $resultadoConsulta = $consultarROl->fetch();

    $consultaRoles = $conexion->prepare("SELECT idRoles, roles FROM roles");
    $consultaRoles->execute();
    $roles = $consultaRoles->fetchAll(PDO::FETCH_ASSOC);

    //Nombre y apellido del usuario
    $nombreUsuario = $resultadoConsulta['nombres'] . ' ' . $resultadoConsulta['apellidos'];


    if ($resultadoConsulta['idRoles'] == 1) { // Administrador
        require 'views/registrarUsuarios.view.php';
    } else if ($resultadoConsulta['idRoles'] == 2) { // Empleado
        header('Location: ../empleado/dashboard.php');
    } else if ($resultadoConsulta['idRoles'] == 3) { // Cliente
        header('Location: ../cliente/dashboard.php');
    }

} else {
    // Devolvemos al login
    header('Location: ../login.php');
}

if (isset($_POST['cedula']) && isset($_POST['nombres']) && isset($_POST['apellidos']) && isset($_POST['correo']) && isset($_POST['password']) && isset($_POST['passwordConfirm']) && isset($_POST['telefono']) && isset($_POST['rol'])) {

    $cedula = $_POST['cedula'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $rolUsuario = $_POST['rol'];
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
                $registrar_cliente = $conexion->prepare("INSERT INTO usuarios (cedula, nombres, apellidos, telefono, correoElectronico, password, idRoles, idEstadoUsuario) VALUES (:cedula, :nombres, :apellidos, :telefono, :correo, :password, :rolUsuario, 1)");

                $registrar_cliente->bindParam(":cedula", $cedula);
                $registrar_cliente->bindParam(":nombres", $nombres);
                $registrar_cliente->bindParam(":apellidos", $apellidos);
                $registrar_cliente->bindParam(":telefono", $telefono);
                $registrar_cliente->bindParam(":correo", $correo);
                $registrar_cliente->bindParam(":rolUsuario", $rolUsuario);
                $registrar_cliente->bindParam(":password", $password_encriptada);
            } 


            if ($registrar_cliente->execute()) {
                $_SESSION['cedula'] = $cedula;
                //echo "ID DE LA SESION: ", $_SESSION['cedula'];
                echo "<script> alert('Usuario Registrado, Incia sesion') </script>";



            } else {
                echo "<script> alert('Error al registrar usuarios') </script>";
            }
        } else {
            //echo "<script> alert('Usuario Registrado') </script>";
        }
    }
} else {
    //echo "Datos no recibidos";
}

