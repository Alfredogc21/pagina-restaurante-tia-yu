<?php
// Incluir el archivo de conexión
require 'conexion/conexion.php';

// Procesar el formulario solo si se ha enviado una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar y validar los datos del formulario
    $nombre = filter_input(INPUT_POST, 'nombre');
    $correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);
    $celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_NUMBER_INT);
    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_NUMBER_INT);
    $mensaje = filter_input(INPUT_POST, 'mensaje');

    // Verificar campos obligatorios
    if (!$nombre || !$correo || !$celular || !$tipo || !$mensaje) {
        echo "<script>alert('Todos los campos son obligatorios. Por favor, completa el formulario.');</script>";
        exit();
    }

    // Verificar que se haya seleccionado un tipo válido
    if ($tipo == 0) {
        echo "<script>alert('Por favor, selecciona un tipo de solicitud válido.');</script>";
        exit();
    }

    // Preparar la consulta para insertar los datos
    $sql = "INSERT INTO pqrs (nombre, correo, celular, cod_tipopqrs, mensaje, fecha) 
            VALUES (:nombre, :correo, :celular, :tipo, :mensaje, NOW())";
    $stmt = $conexion->prepare($sql);

    try {
        // Ejecutar la consulta
        $stmt->execute([
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':celular' => $celular,
            ':tipo' => $tipo,
            ':mensaje' => $mensaje
        ]);

        // Mostrar mensaje de éxito y redirigir al usuario
        echo "<script>alert('Solicitud enviada correctamente.');</script>";
        header("Refresh: 1; url=index.php");
        exit();
    } catch (PDOException $e) {
        // Registrar el error y mostrar mensaje al usuario
        error_log("Error al insertar en la base de datos: " . $e->getMessage());
        echo "<script>alert('Error al enviar la solicitud. Por favor, intenta más tarde.');</script>";
        header("Refresh: 1; url=index.php");
    }
}
