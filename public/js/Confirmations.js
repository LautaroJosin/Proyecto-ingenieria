
function confirmLogout() {
    if (window.confirm('¿Estás seguro de que deseas cerrar sesión?')) {
        document.getElementById('logout-form').submit();// Formulario para el logout en la versión de escritorio
}}

function confirmDeleteDog() {
    if(window.confirm('¿Estás seguro de que deseas eliminar este perro?')){
        document.getElementById('destroy-dog-form').submit();
    }
    
}

function confirmDeleteCaregiver() {
    if(window.confirm('¿Estás seguro de que deseas eliminar este negocio?')){
        document.getElementById('destroy-caregiver-form').submit();
    }
}
