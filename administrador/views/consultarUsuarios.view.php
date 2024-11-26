<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Restaurante</title>
  <link rel="stylesheet" href="views/estilos/dashboard.css">
  <link rel="stylesheet" href="views/estilos/tablaUsuarios.css">
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
        <li class="nav-item">
          <a href="#"><i class="fas fa-cogs"></i><span class="nav-text">Configuración</span></a>
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
      <main class="card">
        <form method="POST" action="" class="filtros-form">
          <div class="titulo-icono">
            <h1>Consultar Usuarios</h1>
            <i class="fas fa-search"></i>
          </div>

          <div class="filtros">
            <!-- Filtro por Cédula -->
            <label for="filtro-cedula">Cédula:</label>
            <input type="text" id="filtro-cedula" name="filtro-cedula" placeholder="Ingrese cédula">

            <!-- Filtro por Estado -->
            <label for="filtro-estado">Estado:</label>
            <select id="filtro-estado" name="filtro-estado">
              <option value="">Todos</option>
              <option value="1">Activo</option>
              <option value="2">Inactivo</option>
              <option value="3">Desactivado</option>
            </select>

            <!-- Filtro por Rol -->
            <label for="filtro-rol">Rol:</label>
            <select id="filtro-rol" name="filtro-rol">
              <option value="">Todos</option>
              <option value="1">Administrador</option>
              <option value="2">Empleado</option>
              <option value="3">Cliente</option>
            </select>

            <!-- Filtro por Fecha de Registro -->
            <label for="filtro-fechaRegistro">Fecha Registro:</label>
            <input type="date" id="filtro-fechaRegistro" name="filtro-fechaRegistro">

            <!-- Botón para Consultar -->
            <button type="submit" class="botonConsultar">Consultar</button>
          </div>
        </form>

        <div class="tabla-responsive">
          <table>
            <thead>
              <tr>
                <th>Cédula</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Fecha Registro</th>
                <th>Roles</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($resultadoConsultaUsuarios as $usuario): ?>
                <tr>
                  <td><?php echo htmlspecialchars($usuario['cedula']); ?></td>
                  <td><?php echo htmlspecialchars($usuario['nombres']); ?></td> <!-- Nombres concatenados -->
                  <td><?php echo htmlspecialchars($usuario['apellidos']); ?></td> <!-- Apellidos concatenados -->
                  <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                  <td><?php echo htmlspecialchars($usuario['fecha']); ?></td>
                  <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                  <td><?php echo htmlspecialchars($usuario['estado']); ?></td>
                  <td>
                    <button class="editar-btn botonActualizar" data-id="<?php echo $usuario['id']; ?>">
                      <i class="fas fa-edit"></i> <!-- Ícono de edición -->
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="paginacion">
          <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="?pagina=<?php echo $i; ?>" class="<?php echo ($i == $pagina) ? 'activo' : ''; ?>">
              <?php echo $i; ?>
            </a>
          <?php endfor; ?>
        </div>

        <!-- Modal -->
        <div id="modalEditar" class="modal">
          <div class="modal-contenido">
            <span class="cerrar">&times;</span>
            <h2>Editar Usuario</h2>
            <form id="formularioEditar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" name="actualizar">
              <!-- Campo oculto para el ID -->
              <input type="hidden" id="id-editar" name="id">

              <!-- Cédula -->
              <label for="cedula-editar">Cédula:</label>
              <input type="number" id="cedula-editar" name="cedula" required>

              <!-- Nombres -->
              <label for="nombres-editar">Nombres:</label>
              <input type="text" id="nombres-editar" name="nombres" required>

              <!-- Apellidos -->
              <label for="apellidos-editar">Apellidos:</label>
              <input type="text" id="apellidos-editar" name="apellidos" required>

              <!-- Correo Electrónico -->
              <label for="correo-editar">Correo Electrónico:</label>
              <input type="email" id="correo-editar" name="correoElectronico" required>

              <!-- Rol -->
              <label for="idRoles-editar">Rol:</label>
              <select id="idRoles-editar" name="rol" required>
                <option disabled selected>Seleccione el rol</option>
                <option value="1">Administrador</option>
                <option value="2">Empleado</option>
                <option value="3">Cliente</option>
              </select>

              <!-- Estado -->
              <label for="estado-editar">Estado:</label>
              <select id="estado-editar" name="estado" required>
                <option disabled selected>Seleccione el estado</option>
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>
                <option value="3">Desactivado</option>
              </select>

              <!-- Botón de enviar -->
              <button class="botonActualizar" type="submit">Guardar cambios</button>
            </form>
          </div>
        </div>

    </div>
  </div>


  <?php if (!empty($errores)): ?>
    <div class="alert">
      <?php echo $errores; ?>
    </div>
  <?php endif; ?>
  </div>
  </div>

  </div>
  </main>



  </div>
  </div>

  <script src="views/js/dashboard.js"></script>
</body>

</html>