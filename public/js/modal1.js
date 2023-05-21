
function confirmLogout() {
    if (window.confirm('¿Estás seguro de que deseas cerrar sesión?')) {
        document.getElementById('logout-form').submit();// Formulario para el logout en la versión de escritorio
        console.log('Exito cerrado la sesion')
}}