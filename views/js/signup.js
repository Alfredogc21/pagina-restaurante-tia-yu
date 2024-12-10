document.getElementById("signup").addEventListener("submit", function(event) {
    // Detener el envío para validar
    event.preventDefault();

    // Obtener los valores de los campos
    const cedula = document.querySelector("input[name='cedula']").value;
    const nombres = document.querySelector("input[name='nombres']").value;
    const apellidos = document.querySelector("input[name='apellidos']").value;
    const telefono = document.querySelector("input[name='telefono']").value;
    const correo = document.querySelector("input[name='correo']").value;
    const password = document.querySelector("input[name='password']").value;
    const passwordConfirm = document.querySelector("input[name='passwordConfirm']").value;

    // Expresión regular para validar correo
    const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    // Expresión regular para validar número de teléfono
    const telefonoRegex = /^\d{7,10}$/;
    // Expresión regular para validar la contraseña (al menos 1 mayúscula, 1 minúscula, 1 número, 1 carácter especial y 8 caracteres)
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>-_]).{8,}$/;

    // Validaciones
    if (cedula.length < 5) {
        alert("La cédula debe tener al menos 5 dígitos.");
        return;
    }
    if (nombres.length < 3) {
        alert("El nombre debe tener al menos 3 caracteres.");
        return;
    }
    if (apellidos.length < 4) {
        alert("El apellido debe tener al menos 4 caracteres.");
        return;
    }
    if (!telefonoRegex.test(telefono)) {
        alert("El teléfono debe tener entre 7 y 10 dígitos.");
        return;
    }
    if (!correoRegex.test(correo)) {
        alert("El correo no tiene un formato válido.");
        return;
    }
    if (password.length < 8) {
        alert("La contraseña debe tener al menos 8 caracteres.");
        return;
    }
    if (!passwordRegex.test(password)) {
        alert("La contraseña debe contener al menos una letra mayúscula, una minúscula, un número y un carácter especial.");
        return;
    }
    if (password !== passwordConfirm) {
        alert("Las contraseñas no coinciden.");
        return;
    }

    // Si todo es válido, enviar el formulario
    alert("Formulario enviado correctamente.");
    this.submit();
});
