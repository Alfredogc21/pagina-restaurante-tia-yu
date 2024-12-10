<?php 
session_start();

// Validamos si hay una sesión
if (isset($_SESSION['usuarios'])) {
    $correo = $_SESSION['usuarios'];

    // Hacemos la conexión a la base de datos
    require '../conexion/conexion.php';

    // Conocer el rol del usuario
    $consultarRol = $conexion->prepare('SELECT idUsuarios, idRoles, nombres, apellidos FROM usuarios WHERE correoElectronico = :correo');
    $consultarRol->execute(array(':correo' => $correo));
    $resultadoConsulta = $consultarRol->fetch();

    // Validar si se obtuvo un resultado
    if ($resultadoConsulta) {
        $idUsuarios = $resultadoConsulta['idUsuarios']; // Guardar el idUsuarios
        $nombreUsuario = $resultadoConsulta['nombres'] . ' ' . $resultadoConsulta['apellidos'];

        // Redirigir según el rol
        if ($resultadoConsulta['idRoles'] == 1) { // Administrador
            require 'views/configurarCambioCorreo.view.php';
        } else if ($resultadoConsulta['idRoles'] == 2) { // Empleado
            header('Location: ../empleado/dashboard.php');
        } else if ($resultadoConsulta['idRoles'] == 3) { // Cliente
            header('Location: ../cliente/dashboard.php');
        }
    } else {
        // Si no se encuentra el usuario, cerrar sesión y redirigir al login
        session_destroy();
        header('Location: ../login.php');
        exit;
    }
} else {
    // Redirigir al login si no hay sesión
    header('Location: ../login.php');
    exit;
}

// Verificar si se envió el formulario para cambiar el correo
if (isset($_POST['correo'])) {
    $email = $_POST['correo'];

    // Verificar si ya existe un usuario con el nuevo correo
    $buscarCorreo = $conexion->prepare("SELECT * FROM usuarios WHERE correoElectronico = :correo");
    $buscarCorreo->bindParam(":correo", $email);
    $buscarCorreo->execute();
    $correoExistente = $buscarCorreo->fetch(PDO::FETCH_ASSOC);

    if ($correoExistente) {
        echo "<script> alert('El correo ya está en uso. Por favor, elija otro.'); </script>";
    } else {
        // Actualizar el correo del usuario que tiene la sesión iniciada
        $actualizarCorreoUsuario = $conexion->prepare("UPDATE usuarios SET correoElectronico = :correo WHERE idUsuarios = :idUsuarios");
        $actualizarCorreoUsuario->bindParam(":correo", $email);
        $actualizarCorreoUsuario->bindParam(":idUsuarios", $idUsuarios);

        if ($actualizarCorreoUsuario->execute()) {
            // Actualización exitosa
            echo "<script> alert('Correo actualizado correctamente.'); </script>";

            // Actualizar el correo en la sesión
            $_SESSION['usuarios'] = $email;

            echo '
            <script>
                window.location = "configurarCambioCorreo.php";
            </script>';  
        } else {
            echo "<script> alert('Error al actualizar el correo. Por favor, inténtelo de nuevo.'); </script>";
        }
    }
} else {
    // echo "Datos no recibidos";
}
