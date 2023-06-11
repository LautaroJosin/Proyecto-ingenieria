
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

function buttonDisable(formId, buttonId) {
    var form = document.getElementById(formId);
    var button = document.getElementById(buttonId);
  
    form.addEventListener("submit", function() {
      button.disabled = true;
    });
}

function confirmDeleteCaregiver() {
    if(window.confirm('¿Estás seguro de que deseas eliminar este negocio?')){
        document.getElementById('destroy-caregiver-form').submit();
    }
}
function confirmDeleteAdoptionDog() {
    if(window.confirm('¿Estás seguro de que deseas eliminar este perro?')){
        document.getElementById('destroy-adoption-dog-form').submit();
    }
}

function sendEmail(var1 , var2) {
 
    const input = prompt('Por favor ingresa tu email:');

	d1 = document.getElementById("dato1");
	d1.value = var1; /* owner_Id */
	
	d2 = document.getElementById("dato2");
	d2.value = var2; /* dog temp_name */
	
	d3 = document.getElementById("dato3");
	d3.value = input; /* user email */
	
	var form = document.getElementById("adopt_dog_form").submit();
	
}
