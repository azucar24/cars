$(document).ready(function() {
	$("#mostrar_menu").on("click", function() {
		$("ul.navigation").slideToggle(100);
	});

	$("#main_container").slidesjs({
		navigation: false,
        play: {
        	active: true,
	        auto: true,
	        interval: 5000,
	        swap: true,
        }
	});

	$("#form_register").validate({
		rules: {
			departamento: true,
			nombre: {
				required: true,
				minlength: 5,
				maxlength: 30
			},
			usuario: {
				required: true,
				minlength: 3,
				maxlength: 40
			},
			password: {
				required: true,
				minlength: 5,
				maxlength: 100
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			email: {
				required: true,
				email: true
			},
			dui: {
				required: true,
				maxlength: 10,
				minlength: 10
			}
		},
		messages: {
			departamento: {
				required: "Este campo es requerido",
			},
			nombre: {
				required: "Este campo es requerido",
				minlength: "Por favor, introduzca al menos 5 caracteres.",
				maxlength: "Por favor, introduzca al menos 5 caracteres."
			},
			usuario: {
				required: "Este campo es requerido",
				minlength: "Por favor, introduzca al menos 3 caracteres.",
				maxlength: "Por favor, introduzca no más de 40 caracteres."
			},
			password: {
				required: "Este campo es requerido",
				minlength: "Por favor, introduzca al menos 5 caracteres.",
				maxlength: "Por favor, introduzca no más de 100 caracteres."
			},
			confirm_password: {
				required: "Este campo es requerido",
				minlength: "Por favor, introduzca al menos 5 caracteres.",
				equalTo: "Por favor, introduzca el mismo valor de nuevo."
			},
			email: {
				required: "Este campo es requerido",
				email: "Por favor, introduce una dirección de correo electrónico válida."
			},
			dui: {
				required: "Este campo es requerido",
				minlength: "Por favor, introduzca al menos 10 caracteres.",
				maxlength: "Por favor, introduzca no más de 10 caracteres."
			}
		}
	});

	$("#form_login").validate({
		rules: {
			usuario: {
				required: true,
				minlength: 3,
				maxlength: 100
			},
			password: {
				required: true,
				minlength: 5,
				maxlength: 100
			}
		},
		messages: {
			usuario: {
				required: "Este campo es requerido",
				minlength: "Por favor, introduzca al menos 3 caracteres.",
				maxlength: "Por favor, introduzca no más de 40 caracteres."
			},
			password: {
				required: "Este campo es requerido",
				minlength: "Por favor, introduzca al menos 5 caracteres.",
				maxlength: "Por favor, introduzca no más de 100 caracteres."
			}
		}
	});
  
});
function registrarUsuario() {
	var nombre_ap = $("#nombre").val();
	var username = $("#usuario").val();
	var email = $("#email").val();
	var dui = $("#dui").val();
	var departamento = $("#departamento").val();
	var password = $("#password").val();

	$.ajax({
		url:'php/includes/new_register.php',
		data:{
			nombre_ap : nombre_ap,
			username : username,
			email : email,
			dui : dui,
			departamento : departamento,
			password : password
		},
		type: 'POST',
		success:function(data){
			if(!data.error){
				if (data == 1) {
					alert("Error, el nombre de usuario ya existe en nuestra base de datos.");
					$("#usuario").val("").focus();
					limpiarPass();
				} else if(data == 2) {
					alert("Se ha registrado correctamente.");
					window.location.href = window.location.origin + "/cars/login.php";
				}
			}
		}
	});
}

function limpiarPass() {
	$("#password").val("");
	$("#confirm_password").val("");
}

function login() {
	var username = $("#usuario").val();
	var password = $("#password").val();

	$.ajax({
		url:'php/includes/login.php',
		data:{
			username : username,
			password : password
		},
		type: 'POST',
		success:function(data){
			if(!data.error){
				if(data == 0) {
					alert("Error, nombre de usuario o contraseña incorrectos.");
				} else if (data == 1) {
					window.location.href = window.location.origin + "/cars/login.php";
				}
			}
		}
	});
}