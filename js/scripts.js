$(document).ready(function () {
/// Click en boton ingresar de login
$('button#login').on('click', function (e) {
	e.preventDefault();
	var form = $(this).closest('form').attr('id');
	if (evaluarModal(form)) {
	Cookies.set('info', form);
	loginCheck($('form#'+form)[0]);
	}
});

/// obtiene los inputs de login.
	function evaluarModal(modal) {
		var inputs = new Array();  

		$('div#'+modal).find("form#"+modal+" input").each(function() {
			inputs.push($(this).val());
		});
		
		if (modal == 'student') {
			return evaluarStudent(inputs);
		}else {
			return evaluarPersonal(inputs);
		}		
	}
/// Evalua Estudiante 
function evaluarStudent(inputs) {
	for (var i = 0; i < inputs.length; i++) {
						if (inputs[0] == '' || inputs[0].length != 8 || isNaN(inputs[0])) {
								$('div#msj').html('<div class="message focus animated fadeIn" data-component="message">El No. de Control no tiene formato válido.<span class="close small"></span></div>');
								return false;	
						}
						if (inputs[i].length < 4){
								$('div#msj').html('<div class="message focus animated fadeIn" data-component="message">Algún campo está vacio o incompleto.<span class="close small"></span></div>');
								return false;
						}
		}
		return true;
	}

/// Evalua Personal 
function evaluarPersonal(inputs) {
	for (var i = 0; i < inputs.length; i++) {
						if (inputs[i].length < 4){
								$('div#msj').html('<div class="message focus animated fadeIn" data-component="message">Algún campo está vacio o incompleto.<span class="close small"></span></div>');
								return false;
						}
		}
		return true;
	}
/// Verifica Logeo
function loginCheck(form) {
		var formulario = new FormData(form);
					$.ajax({
                data: formulario, 
                url: 'php/login-session.php',
                type: 'post',
                async: false,
		          cache: false,
		          contentType: false,
		          processData: false,
                beforeSend: function () {
                //¿que hace antes de enviar?
                },
                success: function (infoRegreso) {
                	console.log(infoRegreso);
                    switch(parseInt(infoRegreso))
                    {
                  case 1:
                  	location.replace('panel/alumno/');
                        break;
               	case -1:
                       $('div#msj').html('<div class="message error animated fadeIn" data-component="message">Algún campo es incorrecto o no existe ese usuario.<span class="close small"></span></div>');
                        break;
						case -2:
                        $('div#msj').html('<div class="message error animated fadeIn" data-component="message">Te encuentras dado de baja, consulta a tu profesor o coordinador de carrera.<span class="close small"></span></div>');
                        break;
                  default: 
                  $('div#msj').html('<div class="message error animated fadeIn" data-component="message">Ha ocurrido un error, intenta nuevamente.<span class="close small"></span></div>');
               		}
               	},
                  error: function () {
                     alertify.error("Ups... ha ocurrido un error, intenta nuevamente.");
                  }
            });
		}
});