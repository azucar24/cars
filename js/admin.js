$("#form_registrar_auto").validate({
		rules: {
			nombre : {
				required: true,
				minlength: 3,
				maxlength: 100
			},
			marca : {
				required: true,
				minlength: 2,
				maxlength: 255
			},
			modelo : {
				required: true,
				minlength: 1,
				maxlength: 255
			},
			anio : {
				required: true,
				number: true,
				min: 1988,
				max: 2016
			},
			precio : {
				required: true,
				number: true,
				min: 500,
				max: 100000
			},
			stock : {
				number: true,
				required: true,
				min: 1,
				max: 100
			},
			tipo : {
				required: true
			},
			description : {
				required: true,
				minlength: 2,
				maxlength: 1000
			},
			imagen : {
				required: true
			}
		}
	});
	
	$("#form_registrar_vendedor").validate({
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
