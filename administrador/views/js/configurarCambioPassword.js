document.getElementById("signup").addEventListener("submit", function(event) {
    // Detener el envío para validar
    event.preventDefault();

    // Obtener los valores de los campos
    const password = document.querySelector("input[name='passwordNueva']").value;
    const passwordConfirm = document.querySelector("input[name='passwordConfirmar']").value;

    // Expresión regular para validar la contraseña (al menos 1 mayúscula, 1 minúscula, 1 número, 1 carácter especial y 8 caracteres)
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>-_]).{8,}$/;

    // Validaciones
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
