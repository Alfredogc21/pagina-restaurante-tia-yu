<?php
session_start();

// Validar si hay sesión activa
if (isset($_SESSION['usuarios'])) {
    $correo = $_SESSION['usuarios'];

    // Conexión a la base de datos
    require '../conexion/conexion.php';

    // Variable para acumular errores
    $errores = '';
    $success = '';

    // Conocer el rol del usuario
    $consultarROl = $conexion->prepare('SELECT nombres, apellidos, idRoles FROM usuarios WHERE correoElectronico = :correo');
    $consultarROl->execute(array(':correo' => $correo));
    $resultadoConsulta = $consultarROl->fetch();

    // Nombre y apellido del usuario
    $nombreUsuario = $resultadoConsulta['nombres'] . ' ' . $resultadoConsulta['apellidos'];

    // Obtener filtros desde el formulario
    $cedula = isset($_POST['filtro-cedula']) ? $_POST['filtro-cedula'] : '';
    $estado = isset($_POST['filtro-estado']) ? $_POST['filtro-estado'] : '';
    $rol = isset($_POST['filtro-rol']) ? $_POST['filtro-rol'] : '';
    $fecha = isset($_POST['filtro-fechaRegistro']) ? $_POST['filtro-fechaRegistro'] : '';

    // Consulta base con filtros dinámicos
    $sql = "SELECT usuarios.idUsuarios AS id,
                usuarios.cedula,
                usuarios.nombres,
                usuarios.apellidos,
                usuarios.correoElectronico AS correo,
                usuarios.fechaRegistro AS fecha,
                roles.roles AS rol,
                estadoUsuario.estado AS estado
            FROM usuarios
            INNER JOIN roles ON usuarios.idRoles = roles.idRoles
            INNER JOIN estadoUsuario ON usuarios.idEstadoUsuario = estadoUsuario.idEstadoUsuario
            WHERE 1=1";

    $params = [];

    if (!empty($estado)) {
        $sql .= ' AND estadoUsuario.idEstadoUsuario = :estado';
        $params[':estado'] = $estado;
    }

    if (!empty($rol)) {
        $sql .= ' AND roles.idRoles = :rol';
        $params[':rol'] = $rol;
    }

    if (!empty($fecha)) {
        $sql .= ' AND DATE(usuarios.fechaRegistro) = :fecha';
        $params[':fecha'] = $fecha;
    }

    if (!empty($cedula)) {
        $sql .= ' AND usuarios.cedula = :cedula';
        $params[':cedula'] = $cedula;
    }

    // Agregar la ordenación DESC por id
    $sql .= ' ORDER BY usuarios.idUsuarios DESC';

    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $registrosPorPagina = 5;
    $offset = ($pagina - 1) * $registrosPorPagina;

    $sql .= " LIMIT :limit OFFSET :offset";

    $consultaUsuarios = $conexion->prepare($sql);

    foreach ($params as $key => $value) {
        $consultaUsuarios->bindValue($key, $value);
    }

    $consultaUsuarios->bindValue(':limit', $registrosPorPagina, PDO::PARAM_INT);
    $consultaUsuarios->bindValue(':offset', $offset, PDO::PARAM_INT);

    $consultaUsuarios->execute();
    $resultadoConsultaUsuarios = $consultaUsuarios->fetchAll();

    // Conteo total para calcular el número de páginas
    $sqlCount = "SELECT COUNT(*) 
                 FROM usuarios
                 INNER JOIN roles ON usuarios.idRoles = roles.idRoles
                 INNER JOIN estadoUsuario ON usuarios.idEstadoUsuario = estadoUsuario.idEstadoUsuario
                 WHERE 1=1";

    $params = [];

    // Construcción dinámica de la consulta de conteo
    if (!empty($estado)) {
        $sqlCount .= ' AND estadoUsuario.idEstadoUsuario = :estado';
        $params[':estado'] = $estado;
    }

    if (!empty($rol)) {
        $sqlCount .= ' AND roles.idRoles = :rol';
        $params[':rol'] = $rol;
    }

    if (!empty($fecha)) {
        $sqlCount .= ' AND DATE(usuarios.fechaRegistro) = :fecha';
        $params[':fecha'] = $fecha;
    }

    if (!empty($cedula)) {
        $sqlCount .= ' AND usuarios.cedula = :cedula';
        $params[':cedula'] = $cedula;
    }

    $totalConsulta = $conexion->prepare($sqlCount);

    // Agregar los parámetros a la consulta de conteo
    foreach ($params as $key => $value) {
        $totalConsulta->bindValue($key, $value);
    }

    $totalConsulta->execute();
    $totalRegistros = $totalConsulta->fetchColumn();
    $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

    if (isset($_GET['id'])) {
        $idUsuario = $_GET['id'];
        $consultaUsuario = $conexion->prepare(
            'SELECT usuarios.idUsuarios AS id, usuarios.cedula AS cedula, usuarios.nombres AS nombres, usuarios.apellidos AS apellidos, usuarios.correoElectronico AS correoElectronico, roles.roles AS rol, estadoUsuario.estado AS estado 
            FROM usuarios INNER JOIN roles ON usuarios.idRoles = roles.idRoles INNER JOIN estadoUsuario ON usuarios.idEstadoUsuario = estadoUsuario.idEstadoUsuario WHERE usuarios.idUsuarios = :id'
        );
        $consultaUsuario->execute([':id' => $idUsuario]);
        $usuarioEditar = $consultaUsuario->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe y devolver JSON
        if ($usuarioEditar) {
            header('Content-Type: application/json');
            echo json_encode($usuarioEditar);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
        exit();
    }

    // Procesar actualización de usuario
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
        $idActualizar = $_POST['id'];
        $cedula = $_POST['cedula'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
        $rol = $_POST['rol'];
        $estado = $_POST['estado'];

        $actualizarUsuario = $conexion->prepare('UPDATE usuarios SET cedula = :cedula, nombres = :nombres, apellidos = :apellidos, idRoles = :rol, idEstadoUsuario = :estado, correoElectronico = :correo WHERE idUsuarios = :id');
        $resultado = $actualizarUsuario->execute(array(
            ':id' => $idActualizar,
            ':cedula' => $cedula,
            ':nombres' => $nombres,
            ':apellidos' => $apellidos,
            ':rol' => $rol,
            ':estado' => $estado,
            ':correo' => $correo
        ));

        if ($resultado) {
            echo "<script>alert('Usuario actualizado correctamente');</script>";
            header('Location: consultarUsuarios.php');
        } else {
            echo "<script>alert('Error: No se pudo actualizar el usuario.');</script>";
        }
    }


    if ($resultadoConsulta['idRoles'] == 1) {
        require 'views/consultarUsuarios.view.php';
    } elseif ($resultadoConsulta['idRoles'] == 2) {
        header('Location: ../empleado/dashboard.php');
    } elseif ($resultadoConsulta['idRoles'] == 3) {
        header('Location: ../cliente/dashboard.php');
    }
} else {
    header('Location: ../login.php');
}
