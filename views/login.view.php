<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante las Delicias de la Tía Yú</title>
    <link rel="shortcut icon" href="views/iconos/logo_1.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/9836403ffa.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="views/Estilos/style.css">
    <link rel="stylesheet" href="views/Estilos/login.css">

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header>
        <div class="header__superior">
            <div class="logo">
                <img src="views/iconos/LAS DELICIAS.png" alt="">
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
                        <li><a href="login.php">Login</a></li>
                    </ul>
                </nav>
    </header>
    <main>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="form-login">
    <h5>Formulario Login</h5>
    <input class="controls" type="text" name="usuario" placeholder="Usuario" required>
    <input class="controls" type="password" name="Contrasena" placeholder="Contraseña" required>
    <input class="buttons" type="submit" value="Ingresar">
    <p><a href="#">¿Olvidaste tu Contraseña?</a></p>
    <p><a href="signup.php">Registrarse</a></p>
</form>

    </main>


    <footer>
        <div class="container_footer_all">
            <div class="container_body">
                <div class="columna">
                    <img src="views/iconos/LAS DELICIAS.png">

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
                            <img src="views/iconos/icons8-edificio-de-restaurante-50.png">
                            <label>Mz B Casa 28 Barrio El Futuro Espinal, Tolima.
                            </label>
                        </a>
                    </div>
                    <div class=row2>
                        <a href="https://api.whatsapp.com/send?phone=573214172645&text=¿Cuál es el Menú para el Día de Hoy?" target="_blank">
                            <img src="views/iconos/whatsapp30.png" href="">
                            <label>3214172645</label>
                        </a>
                    </div>
                    <div class=row2>
                        <a href="tel:573178338178">
                            <img src="views/iconos/icons8-teléfono-desconectado-50.png">
                            <label>3178338178</label>
                        </a>
                    </div>
                    <div class=row2>
                        <a href="mailto:lasdeliciasdelatiayu@gmail.com" target="_blank">
                            <img src="views/iconos/msj.png">
                            <label>lasdeliciasdelatiayu@gmail.com</label>
                        </a>
                    </div>
                </div>
                <div class="columna2">
                    <h2>Nuestras Redes Sociales</h2>
                    <div class=row>
                        <a href="https://www.facebook.com/profile.php?id=100087026563677" target="_blank">
                            <img src="views/iconos/facebook50.png">
                        </a>
                        <a href="https://www.instagram.com/lasdeliciasdelatiayu/" target="_blank">
                            <img src="views/iconos/instagram30.png">
                        </a>
                        <a href="https://pin.it/5DxHbnw" target="_blank">
                            <img src="views/iconos/pinterest30.png">
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