<?php
session_start();

// Validamos si hay una sesión activa
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
            require 'views/configurarCambioPassword.view.php';
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

// Verificar si se envió el formulario para cambiar la contraseña
if (isset($_POST['passwordNueva'], $_POST['passwordConfirmar'])) {
    $passwordNueva = $_POST['passwordNueva'];
    $passwordConfirmar = $_POST['passwordConfirmar'];

    // Verificar que la nueva contraseña y la confirmación coincidan
    if ($passwordNueva !== $passwordConfirmar) {
        echo "<script> alert('Las contraseñas no coinciden.'); </script>";
        exit;
    }

    // Encriptar la nueva contraseña
    $passwordHash = password_hash($passwordNueva, PASSWORD_DEFAULT);

    // Actualizar la contraseña en la base de datos
    $actualizarPassword = $conexion->prepare('UPDATE usuarios SET password = :password WHERE idUsuarios = :idUsuarios');
    $actualizarPassword->bindParam(':password', $passwordHash);
    $actualizarPassword->bindParam(':idUsuarios', $idUsuarios);

    if ($actualizarPassword->execute()) {
        echo "<script> alert('Contraseña actualizada correctamente.'); </script>";

        // Redirigir al usuario a la página deseada (por ejemplo, login o dashboard)
        echo '
        <script>
            window.location = "../login.php";
        </script>';
    } else {
        echo "<script> alert('Error al actualizar la contraseña. Por favor, inténtelo de nuevo.'); </script>";
    }
} else {
    // echo "Datos no recibidos";
}
?>
