<?php session_start();

// Validamos si hay una sesion
if (isset($_SESSION['usuarios'])) {
    $correo = $_SESSION['usuarios'];

	//Hacemos la conexion a la base de datos
	require '../conexion/conexion.php';

    // Conocer el rol del usuario y la idUsuarios
    $consultarROl = $conexion->prepare('SELECT idRoles, nombres, apellidos, idUsuarios FROM usuarios WHERE correoElectronico = :correo');
    $consultarROl->execute(array(':correo' => $correo));
    $resultadoConsulta = $consultarROl->fetch();

    $consulMesasDipon = $conexion->prepare("SELECT m.idMesa, d.estado AS nombre_disponibilidad FROM mesa AS m JOIN disponibilidadmesa AS d ON m.disponibilidad = d.idDisponibilidadMesa WHERE m.disponibilidad = 2");
    $consulMesasDipon->execute();
    $mesasDisponibles = $consulMesasDipon->fetchAll(PDO::FETCH_ASSOC);

    //Nombre y apellido del usuario
    $nombreUsuario = $resultadoConsulta['nombres'] . ' ' . $resultadoConsulta['apellidos'];


    if ($resultadoConsulta['idRoles'] == 1) { // Administrador
        require 'views/registrarReservas.view.php';
    } else if ($resultadoConsulta['idRoles'] == 2) { // Empleado
        header('Location: ../empleado/dashboard.php');
    } else if ($resultadoConsulta['idRoles'] == 3) { // Cliente
        header('Location: ../cliente/dashboard.php');
    }

} else {
    // Devolvemos al login
    header('Location: ../login.php');
}

if (isset($_POST['fecha']) && isset($_POST['hora']) && isset($_POST['mesaDispon']) && isset($_POST['numPersonas']) && isset($_POST['comentario'])) {

    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $mesaDispon = $_POST['mesaDispon'];
    $numMesas = $_POST['numPersonas'];
    $comentario = $_POST['comentario'];

    $fechaHoraSeleccionada = strtotime($fecha . ' ' . $hora);
    $fechaHoraActual = time();

    if ($fechaHoraSeleccionada < $fechaHoraActual) {
        echo "<script>alert('No se puede hacer una reserva en una fecha o hora pasada.');</script>";
        exit();
    }


   // Consumo de la API para días festivos
   $response = file_get_contents("https://date.nager.at/Api/v3/PublicHolidays/2024/CO");
   $festivos = json_decode($response, true);
   $esfestivo = false;

   // Verificar si la fecha seleccionada es festiva
   foreach ($festivos as $festivo) {
       if ($festivo['date'] == $fecha) {
           $esfestivo = true;
           break;
       }
   }

   if ($esfestivo) {
       echo "<script> alert('No se puede hacer una reserva en un día festivo.'); </script>";
       exit();
   }



    // Buscar si ya existe un usuarios con esa cédula
    $buscar_clientes = $conexion->prepare("SELECT * FROM usuarios WHERE cedula = :cedula");
    $buscar_clientes->bindParam(":cedula", $cedula);
    $buscar_clientes->execute();
    $cliente_encontrado = $buscar_clientes->fetch(PDO::FETCH_ASSOC);

    $idUsuarios = $resultadoConsulta['idUsuarios'];

    if (empty($cliente_encontrado)) {
        // Registrar la nueva reserva
        $registrar_reservas = $conexion->prepare("INSERT INTO reserva (hora, fecha, comentario, numPersonas, idUsuarios, idMesa) VALUES (:hora, :fecha, :comentario, :numPersonas, :cliente, :mesaDisp)");

        // Vincular los parámetros con las variables
        $registrar_reservas->bindParam(":hora", $hora);
        $registrar_reservas->bindParam(":fecha", $fecha);
        $registrar_reservas->bindParam(":comentario", $comentario);
        $registrar_reservas->bindParam(":numPersonas", $numMesas);
        $registrar_reservas->bindParam(":cliente", $idUsuarios); 
        $registrar_reservas->bindParam(":mesaDisp", $mesaDispon);  


        if ($registrar_reservas->execute()) {
            // Actualizar el estado de la mesa a "reservada"
            $actualizarEstadoMesa = $conexion->prepare("UPDATE mesa SET disponibilidad = 1 WHERE idMesa = :mesaId");
            $actualizarEstadoMesa->bindParam(":mesaId", $mesaDispon); 
            $actualizarEstadoMesa->execute();

            $_SESSION['cedula'] = $cedula;
            echo "<script> alert('Reservacion Realizada') </script>";

            echo '
            <script>
                window.location = "registrarReservas.php";
            </script>';  


        } else {
            echo "<script> alert('Error al reservar') </script>";
        }
    } else {
        //echo "<script> alert('Usuario Registrado') </script>";
    }
} else {
    //echo "Datos no recibidos";
}

