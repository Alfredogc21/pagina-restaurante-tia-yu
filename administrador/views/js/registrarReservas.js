document.addEventListener('DOMContentLoaded', () => {
    const signupForm = document.getElementById('signup');
    const fechaInput = document.getElementById("fecha");
    const horaInput = document.getElementById("hora");
    
    if (signupForm) {
        signupForm.addEventListener('submit', (event) => {
            let formIsValid = true;

            // Validar número de personas
            const numPersonas = document.getElementById('clienteMesas').value;
            if (numPersonas < 1 || numPersonas > 10) {
                alert('Por favor, ingrese un número entre 1 y 10.');
                formIsValid = false;
            }

            // Validar fecha
            if (fechaInput) {
                const fechaSeleccionada = new Date(fechaInput.value);
                const fechaActual = new Date();
                fechaActual.setHours(0, 0, 0, 0); // Comparar solo la fecha

                if (fechaSeleccionada < fechaActual) {
                    alert("No se puede seleccionar una fecha anterior a la actual.");
                    fechaInput.value = ""; // Limpiar el campo
                    formIsValid = false;
                }
            }

            // Validar hora solo si la fecha es hoy
            if (horaInput && fechaInput) {
                const fechaSeleccionada = new Date(fechaInput.value);
                const fechaActual = new Date();

                if (fechaSeleccionada.toDateString() === fechaActual.toDateString()) {
                    const [horaSeleccionada, minutoSeleccionado] = horaInput.value.split(":");
                    const horaReserva = new Date();
                    horaReserva.setHours(horaSeleccionada, minutoSeleccionado);

                    if (horaReserva < fechaActual) {
                        alert("No se puede seleccionar una hora anterior a la actual.");
                        horaInput.value = ""; // Limpiar el campo
                        formIsValid = false;
                    }
                }
            }

            // Evitar el envío del formulario si alguna validación falla
            if (!formIsValid) {
                event.preventDefault();
            }
        });
    }
});
