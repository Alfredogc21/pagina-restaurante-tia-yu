document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modalEditar');
    const cerrarBtn = document.querySelector('.cerrar');
    const editarBtns = document.querySelectorAll('.editar-btn');

    editarBtns.forEach((btn) => {
        btn.addEventListener('click', async (e) => {
            const idUsuario = e.currentTarget.dataset.id;

            console.log('Editar usuario con id:', idUsuario);

            try {
                // Realizar una petición AJAX para obtener los datos del usuario usando su id
                const response = await fetch(`consultarUsuarios.php?id=${idUsuario}`);
                if (!response.ok) throw new Error('Error al obtener datos del usuario');

                const data = await response.json();

                // Verificar si los datos existen antes de rellenar el formulario
                if (data) {
                    const idInput = document.getElementById('id-editar');
                    const cedulaInput = document.getElementById('cedula-editar');
                    const nombresInput = document.getElementById('nombres-editar');
                    const apellidosInput = document.getElementById('apellidos-editar');
                    const correoInput = document.getElementById('correo-editar');
                    const rolInput = document.getElementById('idRoles-editar');
                    const estadoInput = document.getElementById('estado-editar');

                    // Asignar valores a los inputs del formulario
                    if (idInput) idInput.value = data.id;
                    if (cedulaInput) cedulaInput.value = data.cedula;
                    if (nombresInput) nombresInput.value = data.nombres;
                    if (apellidosInput) apellidosInput.value = data.apellidos;
                    if (correoInput) correoInput.value = data.correoElectronico;
                    if (rolInput) rolInput.value = data.rol;
                    if (estadoInput) estadoInput.value = data.estado;
                } else {
                    console.error('No se encontraron datos para el usuario.');
                }

                // Mostrar el modal
                modal.style.display = 'block';
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });

    // Cerrar el modal al hacer clic en el botón de cerrar
    cerrarBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Cerrar el modal si se hace clic fuera de él
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
