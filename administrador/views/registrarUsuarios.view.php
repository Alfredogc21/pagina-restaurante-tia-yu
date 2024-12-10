<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar Usuarios</title>
  <link rel="stylesheet" href="views/estilos/dashboard.css">
  <link rel="stylesheet" href="views/estilos/registrarUsuarios.css">
  <link rel="shortcut icon" href="../views/iconos/logo_1.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
  <div class="dashboard">
    <nav class="sidebar">
      <div class="sidebar-header">
        <h2>Restaurante</h2>
      </div>
      <ul class="nav-list">
        <li class="nav-item">
          <a href="dashboard.php"><i class="fas fa-home"></i><span class="nav-text">Inicio</span></a>
        </li>
        <li class="nav-item has-submenu">
          <a href="#"><i class="fas fa-calendar-alt"></i><span class="nav-text">Usuario</span><i class="fas fa-caret-down"></i></a>
          <ul class="submenu">
          <li><a href="registrarUsuarios.php">Registrar</a></li>
            <li><a href="consultarUsuarios.php">Consultar</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#"><i class="fas fa-utensils"></i><span class="nav-text">Menú</span></a>
        </li>
        <li class="nav-item has-submenu">
          <a href="#"><i class="fas fa-calendar-alt"></i><span class="nav-text">Reservas</span><i class="fas fa-caret-down"></i></a>
          <ul class="submenu">
            <li><a href="#">Ver Reservas</a></li>
            <li><a href="registrarReservas.php">Nueva Reserva</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#"><i class="fas fa-concierge-bell"></i><span class="nav-text">Pedidos</span></a>
        </li>
        <li class="nav-item">
          <a href="#"><i class="fas fa-chart-line"></i><span class="nav-text">Estadísticas</span></a>
        </li>
        <li class="nav-item has-submenu">
          <a href="#"><i class="fas fa-cogs"></i><span class="nav-text">Configuración</span></a>
          <ul class="submenu">
          <li><a href="configurarCambioPassword.php">Cambiar Contraseña</a></li>
          <li><a href="configurarCambioCorreo.php">Actualizar Correo</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#"><i class="fas fa-question-circle"></i><span class="nav-text">Ayuda</span></a>
        </li>
      </ul>
    </nav>
    <div class="main-content">
      <header class="header">
        <div class="header-left">
          <span>Usuario: <?php echo $nombreUsuario; ?></span>
        </div>
        <div class="header-right">
          <a href="../cerrarSesion.php" class="cerrarSesion"><button id="menu-toggle"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button></a>
        </div>
      </header>
      <main class="content">
        <div class="welcome-card">
            <main>
                <form method="post" id="signup" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="form-singup">
                    <h5>Registro de Usuario</h5>
                    <input class="controls" type="number" min="1" name="cedula" value="" placeholder="Cedula" required>
                    <div class="box">
                        <input class="controls" type="text" minlength="3" name="nombres" placeholder="Primer Nombre" required>
                    </div>
                    <div class="box">
                        <input class="controls" type="text" minlength="4" name="apellidos" placeholder="Primer Apellido" required>
                    </div>
                    <input class="controls" type="number" min="0" name="telefono" placeholder="Telefono" require>
                    <input class="controls" type="mail" name="correo" placeholder="Correo" require>
                    <select class="controls2" id="rol" name="rol" required>
                      <option value="" disabled selected>Seleccione un rol</option>
                        <?php foreach ($roles as $rol):?>
                          <option value="<?php echo $rol['idRoles'];?>">
                            <?php echo $rol['roles'];?></option>
                        <?php endforeach;?>
                    </select>
                    <input class="controls" type="password" name="password" placeholder="Contraseña" required>
                    <input class="controls" type="password" name="passwordConfirm" placeholder="Confirmar Contraseña" required>
                    <br></br>
                    <input class="buttons" type="submit" name="" value="Registrarse">
                </form>
            </main>
        </div>
      </main>
    </div>
  </div>

  <script src="views/js/dashboard.js"></script>
  <script src="views/js/registrarUsuarios.js"></script>
</body>
</html>
