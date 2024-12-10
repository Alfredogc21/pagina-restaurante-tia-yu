document.addEventListener('DOMContentLoaded', () => {
    // Obtener los parámetros de la URL
    const urlParams = new URLSearchParams(window.location.search);

    // Asignar valores a los campos de filtro desde los parámetros de la URL
    const filtroEstado = urlParams.get('filtro-estado');
    const filtroRol = urlParams.get('filtro-rol');
    const filtroFecha = urlParams.get('filtro-fechaRegistro');
    const filtroCedula = urlParams.get('filtro-cedula');

    const estadoInput = document.getElementById('filtro-estado');
    const rolInput = document.getElementById('filtro-rol');
    const fechaInput = document.getElementById('filtro-fechaRegistro');
    const cedulaInput = document.getElementById('filtro-cedula');

    if (estadoInput && filtroEstado) estadoInput.value = filtroEstado;
    if (rolInput && filtroRol) rolInput.value = filtroRol;
    if (fechaInput && filtroFecha) fechaInput.value = filtroFecha;
    if (cedulaInput && filtroCedula) cedulaInput.value = filtroCedula;

    // Configuración del modal de edición
    const modal = document.getElementById('modalEditar');
    const cerrarBtn = document.querySelector('.cerrar');
    const editarBtns = document.querySelectorAll('.editar-btn');

    // Mostrar el modal con datos cargados
    editarBtns.forEach((btn) => {
        btn.addEventListener('click', async (e) => {
            const idUsuario = e.currentTarget.dataset.id;

            try {
                const response = await fetch(`consultarUsuarios.php?id=${idUsuario}`);
                if (!response.ok) throw new Error('Error al obtener datos del usuario');

                const data = await response.json();
                if (data) {
                    const idInput = document.getElementById('id-editar');
                    const cedulaInput = document.getElementById('cedula-editar');
                    const nombresInput = document.getElementById('nombres-editar');
                    const apellidosInput = document.getElementById('apellidos-editar');
                    const correoInput = document.getElementById('correo-editar');
                    const rolInput = document.getElementById('idRoles-editar');
                    const estadoInput = document.getElementById('estado-editar');

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

                modal.style.display = 'block';
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });

    // Cerrar modal al hacer clic en el botón de cerrar
    cerrarBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Cerrar modal al hacer clic fuera del mismo
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
