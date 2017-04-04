	/// Variables globales 
	var msjerror1 = '<div class="message error animated fadeIn" data-component="message">El campo: <b>';
	var msjerror2 = '</b> está incorrecto.<span class="close small"></span></div>';
	var msjerror3 = '<div class="message error animated fadeIn" data-component="message"> ';
	var msjerror4 = ' </b><span class="close small"></span></div>';
	
$(document).ready(function () {
	/// Clicks en opciones del menu
	$('div#opciones').on('click', 'a', function (e) {
		e.preventDefault();
		if ($(this).attr('href') == '') {
		var menu = $(this).closest('div').attr('id') +'-'+$(this).attr('id');
		Cookies.set('file', $(this).closest('div').attr('id'));
		Cookies.set('opcion', menu);
		$('div#contenido').load('menu/'+menu+'.php');
		}else location.replace('../php/logout.php');	
	});
	
	/// Click en boton guardar
	$('div#contenido').on('click', 'button#guardar', function (e) {
	e.preventDefault();
	var form = $(this).closest('form').attr('id');
	if (evaluarModal(form)) {
		guardar($('div#contenido').find("form#"+form)[0], Cookies.get('file'));
	}
});

	/// Click en cualquier boton de cancelar
	$('div#contenido').on('click', 'button#cancel', function (e) {
	e.preventDefault();
	$('div#contenido').html('<img class="animated fadeIn" src="../../img/logo.png" alt="">');
});
/// ------------------------------ Inicia todo lo de Carreras (edicion) 
	/// Click en boton editar carrera
	$('div#contenido').on('click', 'i#editar', function (e) {
	var cual = $(this).parent('div').attr('id');
	$(this).removeClass('fa-edit').addClass('fa-check').attr('id', 'confirmar');
	$('div#contenido').find("input#car-"+cual).prop('disabled', false);
	});
	
	/// Click en boton eliminar carrera
	$('div#contenido').on('click', 'i#eliminar', function (e) {
	var cual = $(this).parent('div').attr('id');
	alertify.cancelBtn("Cancelar").confirm("Eliminarás una carrera; se eliminarán todos las materias, grupos y profesores relacionados, ¿estás seguro?", function () {
			 Cookies.set('opcion', 'carreras-eliminar');			 
			 modificarDatos(cual, '', 'carreras.php');
			}, function() {
			  /// no es necesario mostar mensaje
			});
	});
	
	/// Click en boton confirmar edición carrera
	$('div#contenido').on('click', 'i#confirmar', function (e) {
	var cual = $(this).parent('div').attr('id');
	var carrera = $('div#contenido').find("input#car-"+cual).val();
		if (carrera.length > 0 && carrera.length <= 64) {
			alertify.cancelBtn("Cancelar").confirm("Editarás la carrera, ¿estás seguro?", function () {
			 Cookies.set('opcion', 'carreras-editar');			 
			 modificarDatos(cual, carrera, 'carreras.php');    
			}, function() {
			  $('div#contenido').find('i#confirmar').removeClass('fa-check').addClass('fa-edit').attr('id', 'editar');
			  $('div#contenido').find("input#car-"+cual).prop('disabled', true);
			});
		}else {
			$('div#contenido').find('div#msj').html(msjerror1+'Carrera'+msjerror2);
		}
	});
/// ------------------------------ Inicia todo lo de Materias (edicion)
		/// Evento que se ejecuta cuando cambia el select de editar carrera en menu materias
	$('div#contenido').on('change', ' form#materias-editar select#carrera-edit', function (e) {
		var carrera = $(this).val();
		if (carrera != '') {
			consultarInfo(carrera, '', 'materias.php', 'form#materias-editar select#materia-edit');
			$('div#contenido').find('div#new-materia').remove();
		   $('div#contenido').find('i#confirmar-mat').removeClass('fa-check').addClass('fa-edit').attr('id', 'editar-mat');
			}
		else{
		$('div#contenido').find(' form#materias-editar select#materia-edit').html('<option value="">-- Selecciona --</option>');
		$('div#contenido').find('div#new-materia').remove();
		$('div#contenido').find('i#confirmar-mat').removeClass('fa-check').addClass('fa-edit').attr('id', 'editar-mat');
		}
	});
	
		/// Evento que se ejecuta cuando cambia el select de editar materia en menu materias
	$('div#contenido').on('change', ' form#materias-editar select#materia-edit', function (e) {
			$('div#contenido').find('div#new-materia').remove();
			$('div#contenido').find('i#confirmar-mat').removeClass('fa-check').addClass('fa-edit').attr('id', 'editar-mat');
	});
	
	/// Click en boton editar materia
	$('div#contenido').on('click', 'i#editar-mat', function (e) {
	var carrera = $('div#contenido').find(' form#materias-editar select#carrera-edit').val();
	var materia = $('div#contenido').find(' form#materias-editar select#materia-edit').val();
	var desc = $('div#contenido').find(' form#materias-editar select#materia-edit option:selected').text();
	
	if (carrera != '' && materia != '') {
	$(this).removeClass('fa-edit').addClass('fa-check').attr('id', 'confirmar-mat');
		$('div#contenido').find('div#update').append('<div id="new-materia" class="form-item animated fadeIn"><label>Nombre de Materia</label><input value="'+desc+'"  title="Máximo 128 caracteres" type="text" id="materia" name="materia"></div>');
		}
	});
	
		/// Click en boton confirmar edición materia
	$('div#contenido').on('click', 'i#confirmar-mat', function (e) {
	var cual = $('div#contenido').find('form#materias-editar select#materia-edit').val();
	var materia = $('div#contenido').find(' form#materias-editar input#materia').val();
		if (materia.length > 0 && materia.length <= 128) {
			 alertify.cancelBtn("Cancelar").confirm("Editarás la materia, ¿estás seguro?", function () {
			 Cookies.set('opcion', 'materias-actualizar');			 
			 modificarDatos(cual, materia, 'materias.php');    
			}, function() {
				
			});
		}else {
			$('div#contenido').find('div#msj').html(msjerror3+'El nombre de la materia está incorrecto o demasiado largo.'+msjerror4);
		}
	});
	/// Click en boton eliminar materia
	$('div#contenido').on('click', 'i#eliminar-mat', function (e) {
	var cual = $('div#contenido').find('form#materias-editar select#materia-edit').val();
	alertify.cancelBtn("Cancelar").confirm("Eliminarás la materia seleccionada; se eliminarán todos los grupos y actividades relacionadas, ¿estás seguro?", function () {
			 Cookies.set('opcion', 'materias-eliminar');			 
			 modificarDatos(cual, '', 'materias.php');
			}, function() {
			  /// no es necesario mostar mensaje
			});
	});
			/// Evento que se ejecuta cuando cambia el select de catalogo menu materias
	$('div#contenido').on('change', ' form#materias-catalogo select#carrera-cat', function (e) {
		var carrera = $(this).val();
		if (carrera != '') {
			$('div#contenido').find('div#cat-materia').empty();
			consultarInfo(carrera, '', 'materias.php', 'div#cat-materia');
			}
		else{
		$('div#contenido').find('div#cat-materia').empty();
		}
	});
/// ------------------------------ Inicia todo lo de Personal (edicion)
		/// Evento que se ejecuta cuando cambia el select de editar carrera en menu personal
	$('div#contenido').on('change', ' form#personal-editar select#carrera-edit', function (e) {
		var carrera = $(this).val();
		if (carrera != '') {
			$('div#contenido').find('div#cat-personal').empty();
			consultarInfo(carrera, '', 'personal.php', 'div#cat-personal');
			}else{
		$('div#contenido').find('div#cat-personal').empty();
		}
	});
	/// ------------------------------ Inicia todo lo de Grupos
		/// Evento que se ejecuta cuando cambia el select de  carrera en menu grupos
	$('div#contenido').on('change', ' form#grupos-agregar select#carrera-grup', function (e) {
		var carrera = $(this).val();
		if (carrera != '') {
			Cookies.set('tipo', 'mate');
			consultarInfo(carrera, '', 'grupos.php', 'form#grupos-agregar select#materia-grup');
			}
		else{
		$('div#contenido').find(' form#grupos-agregar select#profesor-grup').html('<option value="">-- Selecciona --</option>');
		$('div#contenido').find(' form#grupos-agregar select#materia-grup').html('<option value="">-- Selecciona --</option>');
		}
	});
	
		/// Evento que se ejecuta cuando cambia el select de editar materia en menu materias
	$('div#contenido').on('change', ' form#grupos-agregar select#materia-grup', function (e) {
		var materia = $(this).val();
		if (materia != '') {
			Cookies.set('tipo', 'profe');
			consultarInfo(materia, '', 'grupos.php', 'form#grupos-agregar select#profesor-grup');
			}
		else{
		$('div#contenido').find(' form#grupos-agregar select#profesor-grup').html('<option value="">-- Selecciona --</option>');
		}
	});
		/// Evento que se ejecuta cuando cambia el select de  carrera en menu grupos catalogos
	$('div#contenido').on('change', 'form#grupos-catalogo select#carrera-cat', function (e) {
		var carrera = $(this).val();
		if (carrera != '') { consultarInfo(carrera, '', 'grupos.php', 'select#materia-cata'); }
		else{ $('div#contenido').find('select#materia-cata').html('<option value="">-- Selecciona --</option>');}
	});
			/// Evento que se ejecuta cuando cambia el select de  carrera en menu grupos catalogos
	$('div#contenido').on('change', 'form#grupos-catalogo select#materia-cata', function (e) {
		var materia = $(this).val();
		if (materia != '') { Cookies.set('tipo', 'catalogo'); consultarInfo(materia, '', 'grupos.php', 'div#catalogo'); }
		else{ $('div#contenido').find('div#catalogo').empty();}
	});
	
/********************************************************************
***************** Conjunto de Funciones
********************************************************************/
	/// obtiene los inputs de los modal box.
	function evaluarModal(modal) {
		var inputs = new Array();
		var labels = new Array;  

		$('div#contenido').find("form#"+modal+" input, select").each(function() {
			inputs.push($(this).val());
			labels.push($(this).prev('label').text());
		});
		
		switch(modal) {
			case 'carreras-agregar': 
				return validarCarrera(inputs, labels);
			break;
			case 'materias-agregar': 
				return validarMateria(inputs, labels);
			break;
			case 'personal-agregar': 
				return validarPersonal(inputs, labels);
			break;
			case 'grupos-agregar': 
				return validarGrupo(inputs, labels);
			break;
			}	
	}
	/// validar carrera
function validarCarrera(inputs, labels) {
	for (var i = 0; i < inputs.length; i++) {
						if (i == 0 && (inputs[i].length <= 2 || inputs[i].length > 4)) {
								$('div#contenido').find('div#msj').html(msjerror1+labels[i]+msjerror2);
								return false;	
						}
						if (i == i && (inputs[i].length == 0 || inputs[i].length > 64)){
							$('div#contenido').find('div#msj').html(msjerror1+labels[i]+msjerror2);
								return false;
						}
		}
		return true;
	}
		/// validar carrera
function validarMateria(inputs, labels) {
	for (var i = 0; i < inputs.length; i++) {
						if (inputs[i].length == 0 || inputs[i].length > 128) {
								$('div#contenido').find('div#msj').html(msjerror1+labels[i]+msjerror2);
								return false;	
						}
					}
		return true;
	}
		/// Valida personal
	function validarPersonal(inputs, labels, modal) {
		var regex = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		var rfc = /^[A-Za-zÑñ]{4}[0-9]{6}[A-Za-z0-9]{3}$/;
		
		for (var i = 0; i < inputs.length; i++) {
			
			if ((inputs[i].length != 13 || !rfc.test(inputs[i])) && i == 0) {
				$('div#contenido').find('div#msj').html(msjerror1+labels[i]+msjerror2);
				return false;
				}

			if ((inputs[i].length == 0 || inputs[i].length > 64) && (i >= 1 && i <= 4)) {
					$('div#contenido').find('div#msj').html(msjerror1+labels[i]+msjerror2);
					return false;
				}
			if (i == 5 && !regex.test(inputs[i])){
				$('div#contenido').find('div#msj').html(msjerror1+labels[i]+msjerror2);
				return false;
			}
			if (i == 6 && inputs[i].length < 4){
				$('div#contenido').find('div#msj').html(msjerror1+labels[i]+' (demasiado corta)'+msjerror2);
				return false;
			}
		}
		return true;
		}
		
			/// validar grupo
function validarGrupo(inputs, labels) {
	for (var i = 0; i < inputs.length; i++) {
						if (inputs[i].length == 0 || inputs[i].length > 64) {
								$('div#contenido').find('div#msj').html(msjerror1+labels[i]+msjerror2);
								return false;	
						}
		}
		Cookies.set('opcion', 'grupos-guardar');
		return true;
	}
	
	/// Guarda informacion
function guardar(form, file) {
		var formulario = new FormData(form);
					$.ajax({
                data: formulario, 
                url: '../php/'+file+'.php',
                type: 'post',
                async: false,
		          cache: false,
		          contentType: false,
		          processData: false,
                beforeSend: function () {
                //¿que hace antes de enviar?
                },
                success: function (infoRegreso) {
                    switch(parseInt(infoRegreso))
                    {
               	case -1:
                       $('div#contenido').find('div#msj').html(msjerror3+'Ha ocurrido un error'+msjerror4);
                        break;
                  case -2:
                       $('div#contenido').find('div#msj').html(msjerror3+'Ya existe ese registro, verifica RFC nuevamente.'+msjerror4);
                        break;
                  default: 
                  	  console.log(infoRegreso);
                  	  alertify.log(infoRegreso);
                  	  $('div#contenido').html('<img class="animated fadeIn" src="../../img/logo.png" alt="">');
                  }
               	},
                  error: function () {
                     alertify.error("Ups... ha ocurrido un error, intenta nuevamente.");
                  }
            });
		}
// ---- Funcion para enviar uno o dos datos.
	function modificarDatos(dato1, dato2, file) {
		
		$.ajax({ 
				data: {'dato1': dato1, 'dato2': dato2},
                url: '../php/'+file,
                type: 'POST',
					 async: false,
                success: function (infoRegreso) {
                	if ($.isNumeric(infoRegreso)) {
							$('div#contenido').find('div#msj').html(msjerror3+'Ha ocurrido un error... intenta nuevamente.'+msjerror4);
                		}
                		else{
                			alertify.log(infoRegreso);
                  	  $('div#contenido').html('<img class="animated fadeIn" src="../../img/logo.png" alt="">');
                		}
                	}
            });
		}
/// ------ funcion para consultar info
function consultarInfo(dato1, dato2, file, donde) {
		$.ajax({ 
					 data: {'dato1': dato1, 'dato2': dato2},
                url: '../php/'+file,
                type: 'POST',
					 async: false,
                success: function (infoRegreso) {
                	switch (parseInt(infoRegreso)) {
                		case 0:
							$('div#contenido').find('div#msj').html(msjerror3+'Aún no existen materias registradas para esa carrera.'+msjerror4);
							break;
							case 1:
							$('div#contenido').find('div#msj').html(msjerror3+'Aún no existen profesores registrados para esa carrera.'+msjerror4);
							break;
							default: $('div#contenido').find(donde).html(infoRegreso);
                		}
                	}
            });
		}
});
