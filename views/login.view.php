<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante las Delicias de la Tía Yú</title>
    <link rel="shortcut icon" href="iconos/logo_1.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/9836403ffa.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Estilos/style.css">
    <link rel="stylesheet" href="Estilos/login.css">
    
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header>
        <div class="header__superior">
            <div class="logo">
                <img src="iconos/LAS DELICIAS.png" alt="">
            </div>
        </div>

        <div class="container__menu">
            <div class="menu">
                <input type="checkbox" id="check__menu">
                <label id="#label__check" for="check__menu">
                    <i class="fa-solid fa-bars icon__menu"></i>
                </label>
                <nav>
                    <ul>
                        <li><a href="#" id="selected"></a></li>
                       
                        <li><a href="#novedades">Novedades</a></li>
                        <li><a href="#quienessomos">Quienes Somos</a></li>
                        <li><a href="#galeria">Galeria</a></li>
                        <li><a href="registro_cliente.php">Reservas</a></li>
                        <li><a href="#contactos">Contacto</a></li>
                        <li><a href="../login.php">Login</a></li>
                    </ul>
                </nav>
</header>
<main>
<form class="col s12" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" name="login">
        <div class="row">
          <div class="input-field col s12">
            <input id="email" type="email" name="correo" minlength="12" class="validate" required>
            <label for="email">Correo</label>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="input-field col s12">
            <input id="password" type="password" name="password" minlength="7" class="validate" required>
            <label for="password">Contraseña</label>
            <a href="restablecer.php" class="row__olvidar">¿Olvidaste tu Contraseña?</a>
          </div>
        </div>
        <div class="col center-align">
          <a href="registrar.php" class="btn-register">Crear cuenta</a>
          <button class="btn-login" onclick="login.submit()">Iniciar sesión</button>
        </div>

        <?php if (!empty($errores)) : ?>
          <div class="error-message">
            <ul>
              <?php echo $errores; ?>
            </ul>
          </div>
        <?php endif; ?>


      </form>
   
        </main>
   

    <footer>
        <div class="container_footer_all">
            <div class="container_body">
                <div class="columna">
                    <img src="iconos/LAS DELICIAS.png">

                    <h2>Horario de Atención</h2>
                    <p>Lunes a Viernes</p>
                    <p>11:30 AM - 1:30 PM</p>
                    <p>Sábados y Domingos</p>
                    <p>11:00 AM - 2:00 PM</p>
                </div>

                <div class="columna1">
                    <h2>Información de Contacto</h2>
                    <div class=row2>
                        <a href="https://goo.gl/maps/R2zp29zb5QXfWvY59" target="_blank">
                            <img src="iconos/icons8-edificio-de-restaurante-50.png">
                            <label>Mz B Casa 28 Barrio El Futuro Espinal, Tolima.
                            </label>
                        </a>
                    </div>
                    <div class=row2>
                        <a href="https://api.whatsapp.com/send?phone=573214172645&text=¿Cuál es el Menú para el Día de Hoy?" target="_blank">
                            <img src="iconos/whatsapp30.png" href="">
                            <label>3214172645</label>
                        </a>
                    </div>
                    <div class=row2>
                        <a href="tel:573178338178">
                            <img src="iconos/icons8-teléfono-desconectado-50.png">
                            <label>3178338178</label>
                        </a>
                    </div>
                    <div class=row2>
                        <a href="mailto:lasdeliciasdelatiayu@gmail.com" target="_blank">
                            <img src="iconos/msj.png">
                            <label>lasdeliciasdelatiayu@gmail.com</label>
                        </a>
                    </div>
                </div>
                <div class="columna2">
                    <h2>Nuestras Redes Sociales</h2>
                    <div class=row>
                        <a href="https://www.facebook.com/profile.php?id=100087026563677" target="_blank">
                            <img src="iconos/facebook50.png">
                        </a>
                        <a href="https://www.instagram.com/lasdeliciasdelatiayu/" target="_blank">
                            <img src="iconos/instagram30.png">
                        </a>
                        <a href="https://pin.it/5DxHbnw" target="_blank">
                            <img src="iconos/pinterest30.png">
                        </a>
                    </div>
                </div>
            </div>

            <div class="copyright">
                <small>&copy; 2024 <b>Las Delicias de la Tía Yú</b> - Todos los Derechos Reservados</small>
            </div>
        </div>
        </div>
    </footer>

</body>
</html>