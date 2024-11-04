document.addEventListener('DOMContentLoaded', function() {
    const alternarMenu = document.getElementById('menu-toggle');
    const barraLateral = document.querySelector('.sidebar');
    const elementosNavegacion = document.querySelectorAll('.nav-item > a');
    const submenus = document.querySelectorAll('.has-submenu > a');

    // Alternar ancho de la barra lateral
    alternarMenu.addEventListener('click', () => {
        if (barraLateral.style.width === '60px') {
            barraLateral.style.width = '250px';
        } else {
            barraLateral.style.width = '60px';
        }
    });

    // Alternar submenús
    submenus.forEach(item => {
        item.addEventListener('click', () => {
            const submenu = item.nextElementSibling;
            const estaExpandido = submenu.classList.contains('open');

            // Cerrar todos los submenús
            document.querySelectorAll('.submenu').forEach(sub => {
                sub.classList.remove('open');
            });

            // Alternar el submenú seleccionado
            submenu.classList.toggle('open', !estaExpandido);
        });
    });

    // Asegurar que el elemento de menú predeterminado esté activo
    const elementoActivo = document.querySelector('.nav-item.active');
    if (elementoActivo) {
        const submenu = elementoActivo.querySelector('.submenu');
        if (submenu) {
            submenu.classList.add('open');
        }
    }
});
