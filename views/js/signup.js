// Validación de campos de la cedula
function validarNumeroCedula(event) {
    const input = event.target;
    if (input.value.length > 11) {
        input.value = input.value.slice(0, 11);
        alert("El campo de número solo permite un máximo de 11 dígitos.");
    }
}

// Validación de campos numéricos
function validarNumeroCelular(event) {
    const input = event.target;
    if (input.value.length > 10) {
        input.value = input.value.slice(0, 10);
        alert("El campo de número solo permite un máximo de 10 dígitos.");
    }
}

// Validación de la contraseña
function validarContrasena() {
    const password = document.querySelector("input[name='password']").value;
    const regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

    if (!regex.test(password)) {
        alert("La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una minúscula y un número.");
        return false;
    }
    return true;
}

// Asociar las validaciones al formulario
document.addEventListener("DOMContentLoaded", function () {
    const campoCedula = document.querySelector("input[name='cedula']");
    const campoTelefono = document.querySelector("input[name='telefono']");
    const formulario = document.getElementById("signup");

    campoCedula.addEventListener("input", validarNumeroCedula);
    campoTelefono.addEventListener("input", validarNumeroCelular);
    formulario.addEventListener("submit", function (event) {
        if (!validarContrasena()) {
            event.preventDefault();
        }
    });
});
