
function confirmLogout() {
    if (window.confirm('¿Estás seguro de que deseas cerrar sesión?')) {
        document.getElementById('logout-form').submit();// Formulario para el logout en la versión de escritorio
}}

function confirmDeleteDog() {
    if(window.confirm('¿Estás seguro de que deseas eliminar este perro?')){
        document.getElementById('destroy-dog-form').submit();
    }
}

function confirmationPopUp(message, formId) {
    if (window.confirm(message)) {
        document.getElementById(formId).submit();
    }
}
/*
function confirmationPopUp(message, formId, buttonId) {
    document.getElementById(buttonId).addEventListener("click", (event) =>
    {
        if(window.confirm(message)){
            document.getElementById(formId).submit();
        }
        else {
            event.preventDefault();
        }
        event.stopPropagation();
    });
}
*/

function popUpMessageDelay(message) {
    window.onload = function() {
        alert(message);
      };
}

function popUpMessage(message) {
    alert(message);
}

function confirmDeleteCaregiver() {
    if(window.confirm('¿Estás seguro de que deseas eliminar este negocio?')){
        document.getElementById('destroy-caregiver-form').submit();
    }
}
