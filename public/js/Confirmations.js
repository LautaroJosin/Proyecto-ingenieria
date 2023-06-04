
function confirmLogout() {
    if (window.confirm('¿Estás seguro de que deseas cerrar sesión?')) {
        document.getElementById('logout-form').submit();// Formulario para el logout en la versión de escritorio
}}

function confirmDeleteDog() {
    if(window.confirm('¿Estás seguro de que deseas eliminar este perro?')){
        document.getElementById('destroy-dog-form').submit();
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
