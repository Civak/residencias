	/// Variables globales 
	var msjerror1 = '<div class="message error animated fadeIn" data-component="message">El campo: <b>';
	var msjerror2 = '</b> está incorrecto.<span class="close small"></span></div>';
	var msjerror3 = '<div class="message error animated fadeIn" data-component="message"> ';
	var msjerror4 = ' </b><span class="close small"></span></div>';
	
	$(document).ready(function () {
	$("nav#menu-profe i#tipso").tipso({
		  showArrow: true,
		  position: "bottom",
		  background: "rgba(0, 0, 0, 0.5)",
		  color: "#eee",
		  useTitle: false,
		  animationIn: "fadeIn",
		  animationOut: "fadeOut",
		  size: "small"
	});
	
	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('.scrollToTop').fadeIn();
		} else {
			$('.scrollToTop').fadeOut();
		}
	});
	
	
	$('.scrollToTop').click(function(){
		$('html, body').animate({scrollTop : 0},800);
		return false;
	});
	
		/// Click en cualquier boton de cancelar
	$('div#contenido').on('click', 'button#cancel', function (e) {
	e.preventDefault();
	$('div#contenido').html('<img class="animated fadeIn" src="../../img/logobg.png" alt="">');
});

	/// Click en boton guardar
	$('div#contenido').on('click', 'button#guardar', function (e) {
	e.preventDefault();
	var form = $(this).closest('form').attr('id');
	//console.log(form+' msj');
	if (evaluarModal(form)) {
		switch(form) {
			case 'rellenar-unidad':
				var formData = new FormData();
				formData.append("unidad", $('div#contenido').find("form#"+form+" select#unidades").val());
				formData.append("temario", $('div#contenido').find("form#"+form+" div#editor").html());
				guardar(formData);
			break;
			case 'editar-temario': 
				var formData = new FormData();
				formData.append("unidad", $('div#contenido').find("form#"+form+" select#unidades-edit").val());
				formData.append("temario", $('div#contenido').find("form#"+form+" div#editor").html());
				guardar(formData);
			break;
			case 'crear-tarea':
				var formData = new FormData($('div#contenido').find("form#"+form)[0]);
				formData.append("contenido", $('div#contenido').find("form#"+form+" div#editor").html());
				guardar(formData);
			break;
			case 'editar-tarea':
				var formData = new FormData($('div#contenido').find("form#"+form)[0]);
				formData.append("contenido", $('div#contenido').find("form#"+form+" div#editor").html());
				guardar(formData);
			break;
			case 'change-pass-alu':
				Cookies.set('opcion','editar-contenido$ed-al-pass');
				guardarFormData($('div#contenido').find("form#"+form)[0]);
			break;
			case 'change-edit-alu':
				Cookies.set('opcion','editar-contenido$ed-al-info');
				guardarFormData($('div#contenido').find("form#"+form)[0]);
			break;
			case 'change-elim-alu':
				Cookies.set('opcion','editar-contenido$ed-al-elim');
				guardarFormData($('div#contenido').find("form#"+form)[0]);
			break;
			case 'msj-pgru':
				var formData = new FormData();
				formData.append("grupo", $('div#contenido').find("form#"+form+" select#grupo").val());
				formData.append("msj", $('div#contenido').find("form#"+form+" div#editor").html());
				guardar(formData);
			break;
			case 'msj-palum':
				var formData = new FormData();
				formData.append("grupo", $('div#contenido').find("form#"+form+" select#msj-gru").val());
				formData.append("alumno", $('div#contenido').find("form#"+form+" select#msj-alu").val());
				formData.append("msj", $('div#contenido').find("form#"+form+" div#editor").html());
				guardar(formData);
			break;
			default: guardarFormData($('div#contenido').find("form#"+form)[0]);
			}
		
		
	}
});
	
	/// Clicks en opciones del panel izquierdo
	$('div#acciones').on('click', 'li', function (e) {
		e.preventDefault();
	   var file = $(this).attr('id');
	   Cookies.set('opcion', $(this).parent().attr('id')+'$'+file);
		Cookies.set('data', $(this).closest('span').attr('id'));
		$('div#contenido').load('menu/'+file+'.php');
	});
	
	/// Clicks en opciones del panel izquierdo
	$('div#opciones').on('click', 'a', function (e) {
		e.preventDefault();
	   var file = $(this).attr('id');
	   if (typeof file === 'undefined') location.replace('../php/logoutpersonal.php');
	   else{
	   Cookies.set('opcion', $(this).closest('ul').attr('id')+'$'+file);
		$('div#contenido').load('menu/'+file+'.php');}
	});
	
	/// Clicks en opciones del panel izquierdo
	$('div#mensajes').on('click', 'a', function (e) {
		e.preventDefault();
	   var file = $(this).attr('id');
	   Cookies.set('opcion', $(this).closest('ul').attr('id')+'$'+file);
		$('div#contenido').load('menu/'+file+'.php');
	});
	
	/// Clicks en boton añadir unidades en caso de no tener el grupo unidades
	$('div#contenido').on('click', 'button#add-topic', function (e) {
		Cookies.set('opcion', $(this).attr('id'));
		e.preventDefault();
	   	alertify.prompt("Ingresa el número de unidades que tendrá la materia...",
			    function (val, ev) {
			      ev.preventDefault();
					if (!$.isNumeric(val)) alertify.alert('Debe ser un valor númerico.'); 
					else guardarDatos(val, '', 'unidades.php');
			    }, function(ev) {
			      ev.preventDefault();
			
			    });
  });
  
  /// Clicks en select para rellenar unidad en caso de que esté vacia
  $('div#contenido').on('change', 'form#rellenar-unidad select#unidades', function (e) {
		var unidad = $(this).val();
		if (unidad != '') { $('div#contenido div#temario').load('menu/editor.php'); }
		else{ $('div#contenido div#temario').html('');}
	});
	 /* Clicks en opciones del panel izquierdo
  $('div#contenido').on('change', 'form#crear-tarea select#unidades-tareas', function (e) {
		var unidad = $(this).val();
		if (unidad != '') { $('div#contenido div#tarea').load('menu/editor.php'); }
		else{ $('div#contenido div#temario').html('');}
	}); */
	
	/// Clicks en botones tipo pregunta examen
	$('div#contenido').on('click', 'button#op-mul', function (e) {
		e.preventDefault();
	   var tipo = $(this).attr('id');
	   switch(tipo) {
	   	case 'op-mul':
	   				$('div#contenido').find("form#crear-examen div#preguntas").append(opcionMultiple());
	   	break;
	   }
  });
  /// Click en boton añadir una unidad o eliminarla
  	$('div#contenido').on('click', 'button#add-uni, button#elim-uni', function (e) {
		e.preventDefault();
	   var tipo = $(this).attr('id');
	   switch(tipo) {
	   	case 'add-uni':
	   				preguntarUni('Ingresa el número de la nueva unidad...', tipo);
	   	break;
	   	case 'elim-uni':
	   				preguntarUni('Ingresa el número de la unidad a eliminar...', tipo);
	   	break;
	   }
  });
  
 
  /// Clicks en select unidades para editar para cargar editor
  $('div#contenido').on('change', 'form#editar-temario select#unidades-edit', function (e) {
		var unidad = $(this).val();
		if (unidad != '') { 
		Cookies.set('data', Cookies.get('data')+'-'+unidad);
		$('div#contenido div#temario').load('menu/editor-contenido.php'); 
		}
		else{ $('div#contenido div#temario').html('');}
	});
  /// Clicks en botones de edición o eliminar tarea
	$('div#contenido').on('click', 'div.edit-tareas i', function (e) {
		e.preventDefault();
	   var tipo = $(this).attr('id');
		var op = tipo.split('-');
	   switch(op[0]) {
	   	case 'edit':
	   		editarTarea(op[1]);	
	   	break;
	   	case 'elim':
	   		eliminarTarea(op[1]);
	   	break;
	   }
  });
  /// Clicks en botones de edición o eliminar tarea
	$('div#contenido').on('click', 'div.edit-tareas a', function (e) {
		e.preventDefault();
	   var tipo = $(this).attr('id');
		var op = tipo.split('-');
		Cookies.set('data', Cookies.get('data')+'-'+op[1]);
		$('div#tareas-info').find('div.modal-body').load('menu/info-tarea.php');	   
  });
  
  /// Clicks en panel tareas pendientes
	$('div.tareas-p').on('click', 'div', function (e) {
		e.preventDefault();
		//console.log('funciona');
	   var tipo = $(this).attr('id');
		var op = tipo.split('-');
		Cookies.set('data', Cookies.get('data')+'-'+op[1]);
		$('div#tareas-info').find('div.modal-body').load('menu/info-tarea.php');	   
  });
  
   /// Clicks en select unidades para editar para eliminar archivos de unidad
  $('div#contenido').on('change', 'form#editar-documentos select#docs-edit', function (e) {
		var unidad = $(this).val();
		if (unidad != '') { 
		Cookies.set('data', Cookies.get('data')+'-'+unidad);
		$('div#contenido div#documentos').load('menu/editar-contenido.php'); 
		}
		else{ $('div#contenido div#temario').html('');}
	});
	
	 /// Clicks en select unidades para editar para eliminar archivos de unidad
  $('div#contenido').on('click', 'div.docs i', function (e) {
		var doc = $(this).attr('id');
		if(typeof doc !== "undefined") eliminarDocs(doc);
	});
	
	 /// Clicks en select unidades para editar para eliminar archivos de unidad
  $('div#contenido').on('change', 'form#msj-palum select#msj-gru', function (e) {
		var grupo = $(this).val();
		if (grupo != '') { 
		obtenerDatos(grupo, 'form#msj-palum select#msj-alu', 'msj-profesor.php'); 
		}
		else{ $('div#contenido').find('form#msj-palum select#msj-alu').html('<option value="">-- Alumnos --</option>');}
	});
	 /// Click en boton añadir una unidad o eliminarla
  	$('div#contenido').on('click', 'div#bandeja-env i', function (e) {
		e.preventDefault();
	   var tipo = $(this).attr('id');
	   alertify.confirm('Eliminarás el mensaje selecionado, ¿deseas continuar?',
			    function () {
					Cookies.set('opcion', 'bandeja$msj-elim');
					eliminarDatos(tipo, '', 'bandeja.php');
			    }, function() {
			      
			    });
  });
        
    setInterval(function()
    {
        $('div#mis-msj').fadeOut(400, function(){
            Cookies.set('act','mis-msj');
            obtenerAct('','','updates.php');
        });
    }, 30000);

  /********************************************************************
  *************** Sección de funciones
  *********************************************************************/
    
   function preguntarUni(msj, tipo) {
  		alertify.prompt(msj,
			    function (val, ev) {
			      ev.preventDefault();
					if (!$.isNumeric(val)) alertify.alert('Debe ser un valor númerico.'); 
					else {
						Cookies.set('opcion', tipo);
						guardarDatos(val, '', 'unidades.php');
					}
			    }, function(ev) {
			      ev.preventDefault();
			    });
  	}
  	
  	/// obtiene los inputs de los modal box.
	function evaluarModal(modal) {
		var inputs = new Array();
		var labels = new Array;
		var names = new Array;  

		$('div#contenido').find("form#"+modal+" input, select").each(function() {
			inputs.push($(this).val());
			labels.push($(this).prev('label').text());
			names.push($(this).attr('name'));
		});
		
		switch(modal) {
			case 'rellenar-unidad': 
			case 'editar-temario':
				return validarContenidoUnidad(inputs, labels, modal);
			break;
			case 'crear-tarea':
			case 'editar-tarea': 
				return validarTarea(inputs, labels, modal, names);
			break;
			case 'cargar-alumnos': 
				return validarAlumnos(inputs, labels, modal);
			break;
			case 'cargar-documentos': 
				return validarArchivo(inputs, labels, modal);
			break;
			case 'change-pass-alu': 
				return validarNvoPassAlu(inputs, labels, modal);
			break;
			case 'change-edit-alu': 
				return validarNvaInfoAlu(inputs, labels, modal);
			break;
			case 'change-elim-alu': 
				return validarElimAlu(inputs, labels, modal);
			break;
			case 'msj-pgru':
			case 'msj-palum': 
				return validarMsj(inputs, labels, modal);
			break;
			}	
	}
	
		/// validar contenido unidad
function validarContenidoUnidad(inputs, labels, modal) {
			var contenido = $('div#contenido').find("form#"+modal+" div#editor").html();
						if (contenido.length == 0){
							$('div#contenido').find('div#msj').html(msjerror3+'Debes crear contenido antes de guardar.'+msjerror4);
								return false;
						}
		return true;
	}
			/// validar creación de tarea
function validarTarea(inputs, labels, modal, names) {
			var contenido = $('div#contenido').find("form#"+modal+" div#editor").html();
			for (var i = 0; i < inputs.length - 1; i++){
				if (inputs[i].length == 0 && names[i] != 'archivo') {
				$('div#contenido').find('div#msj').html(msjerror1+labels[i]+msjerror2);
				return false;
				}
			}
						if (contenido.length == 0){
							$('div#contenido').find('div#msj').html(msjerror3+'Debes crear contenido antes de guardar.'+msjerror4);
								return false;
						}
		return true;
	}
				/// validar creación de tarea
function validarMsj(inputs, labels, modal) {
			var contenido = $('div#contenido').find("form#"+modal+" div#editor").html();
			for (var i = 0; i < inputs.length; i++){
				if (inputs[i].length == 0) {
				$('div#contenido').find('div#msj').html(msjerror1+labels[i]+msjerror2);
				return false;
				}
			}
						if (contenido.length == 0){
							$('div#contenido').find('div#msj').html(msjerror3+'Debes crear contenido antes de guardar.'+msjerror4);
								return false;
						}
		return true;
	}
	/// Valida el archivo que contiene la lista de alumnos
function validarAlumnos(inputs, labels, modal) {
				var fileExtension = ['csv'];
				if ($.inArray(inputs[0].split('.').pop().toLowerCase(), fileExtension) == -1) {
               $('div#contenido').find('div#msj').html(msjerror3+'Debe se un archivo CSV, ingresa el tipo de archivo válido.'+msjerror4);
               return false; 
                   }
     return true;
}
		/// Valida carga de archivos	
	function validarArchivo(inputs, labels, modal) {
		for (var i = 0; i < inputs.length; i++) {     
		    if (inputs[i].length == 0) {
		    	$('div#contenido').find('div#msj').html(msjerror3+'Algún archivo está vacío, verifica nuevamente.'+msjerror4);
		        return false;
		    }
		}
		return true;
		}
		
	/// Valida carga de archivos	
	function validarNvoPassAlu(inputs, labels, modal) {
		for (var i = 0; i < inputs.length; i++) {     
		    if (inputs[0].length != 8 || !$.isNumeric(inputs[0])) {
		    	$('div#contenido').find('div#msj').html(msjerror3+'El No. de Control no cumple con el formato, verifica.'+msjerror4);
		        return false;
		    }
			if (inputs[1].length < 4) {
		    	$('div#contenido').find('div#msj').html(msjerror3+'Escribe una contraseña de al menos 4 caracteres.'+msjerror4);
		        return false;
		    }
		}
		return true;
		}
		/// Valida carga de archivos	
	function validarNvaInfoAlu(inputs, labels, modal) {
		for (var i = 0; i < inputs.length; i++) {     
		    if (inputs[0].length != 8 || !$.isNumeric(inputs[0])) {
		    	$('div#contenido').find('div#msj').html(msjerror3+'El No. de Control no cumple con el formato, verifica.'+msjerror4);
		        return false;
		    }
			if (inputs[1].length == 0 || inputs[1].length > 128) {
		    	$('div#contenido').find('div#msj').html(msjerror3+'Escribe un nombre con el formato correcto.'+msjerror4);
		        return false;
		    }
		}
		return true;
		}
	function validarElimAlu(inputs, labels, modal) {
		for (var i = 0; i < inputs.length; i++) {     
		    if (inputs[0].length != 8 || !$.isNumeric(inputs[0])) {
		    	$('div#contenido').find('div#msj').html(msjerror3+'El No. de Control no cumple con el formato, verifica.'+msjerror4);
		        return false;
		    }
		}
		return true;
		}
	/// Crea pregunta de opción múltiple
	function opcionMultiple() {
		var resp = prompt('Ingresa número de respuestas de la pregunta','');
		var pregunta = '';
		
			    
		if (parseInt(resp) != 0) {
		if (Cookies.get('preg') == null) {
			Cookies.set('preg', 1);
			}else {
				Cookies.set('preg', parseInt(Cookies.get('preg'))+parseInt(1));			
			}	
			pregunta += '<div id="preg-'+Cookies.get('preg')+'" class="col col-3"><div class="form-item form-checkboxes small">' + prompt('Escribe la pregunta...', '')+'<input placeholder="Valor" name="v-'+Cookies.get('preg')+'" type="text" class="small w25"><br>';
			
			for (var i = 1; i <= parseInt(resp); i++) {
					pregunta += '<label class="checkbox"><input type="radio" class="small" name=p-"'+Cookies.get('preg')+'"> '+prompt('Escribe la respuesta No. '+i,'')+'</label>';
			    }
			    return pregunta += '<br><i id="ep-'+Cookies.get('preg')+'" class="fa fa-close fa-lg elim-preg error"></i></div></div>';
			}
		return '';
		}
		
/// Elimina tarea en panel edición
function eliminarTarea(cual) {
	alertify.confirm("<i class='fa fa-warning'></i> Eliminarás la tarea seleccionada, ¿deseas continuar?", function () {
			 eliminarDatos(cual, '', 'editar-contenido.php'); 
		}, function() {
		    
		}); 
	}
/// Elimina tarea en panel edición
function eliminarDocs(cual) {
	alertify.confirm("<i class='fa fa-warning'></i> Eliminarás el documento seleccionado, ¿deseas continuar?", function () {
			 Cookies.set('opcion', 'editar-contenido$el-do');
			 eliminarDatos(cual, '', 'editar-contenido.php'); 
		}, function() {
		    
		}); 
	}
/// Editar tarea 
function editarTarea(op) {
	Cookies.set('opcion','editar-contenido$ed-ta-p');
	Cookies.set('data', Cookies.get('data')+'-'+op);
	$('div#contenido').load('menu/ed-ta-p.php');
	}
		/// Guarda informacion
function guardarFormData(form) {
	var doc = Cookies.get('opcion');
	var file = doc.split('$');
		var formulario = new FormData(form);
					$.ajax({
                data: formulario, 
                url: '../php/'+file[0]+'.php',
                type: 'post',
                async: false,
		          cache: false,
		          contentType: false,
		          processData: false,
                beforeSend: function () {
                //¿que hace antes de enviar?
                },
                success: function (infoRegreso) {
                	//console.log(infoRegreso);
                    switch(parseInt(infoRegreso))
                    {
               	case -1:
                       $('div#contenido').find('div#msj').html(msjerror3+'Ha ocurrido un error'+msjerror4);
                        break;
                  case -2:
                       $('div#contenido').find('div#msj').html(msjerror3+'Ya existe ese registro, verifica RFC nuevamente.'+msjerror4);
                        break;
                  default: 
                  	 
                  	  alertify.log(infoRegreso);
                  	  $('div#contenido').html('<img class="animated fadeIn" src="../../img/logobg.png" alt="">');
                  }
               	},
                  error: function () {
                     alertify.error("Ups... ha ocurrido un error, intenta nuevamente.");
                  }
            });
		}
				/// Guarda informacion
function guardar(form) {
	var doc = Cookies.get('opcion');
	var file = doc.split('$');
		
					$.ajax({
                data: form, 
                url: '../php/'+file[0]+'.php',
                type: 'post',
                async: false,
		          cache: false,
		          contentType: false,
		          processData: false,
                beforeSend: function () {
                //¿que hace antes de enviar?
                },
                success: function (infoRegreso) {
                	//console.log(infoRegreso);
                    switch(parseInt(infoRegreso))
                    {
                  case 1:
								alertify.confirm("Tarea guardada existosamente...", function () {
								    location.reload();
								}, function() {
								    location.reload();
								});                
					   break;
               	case -1:
                       $('div#contenido').find('div#msj').html(msjerror3+'Ha ocurrido un error'+msjerror4);
                        break;
                  case -2:
                       $('div#contenido').find('div#msj').html(msjerror3+'Ya existe ese registro, verifica RFC nuevamente.'+msjerror4);
                        break;
                  default: 
                  	  alertify.log(infoRegreso);
                  	  $('div#contenido').html('<img class="animated fadeIn" src="../../img/logobg.png" alt="">');
                  }
               	},
                  error: function () {
                     alertify.error("Ups... ha ocurrido un error, intenta nuevamente.");
                  }
            });
		}
  // ---- Funcion para enviar uno o dos datos.
	function guardarDatos(dato1, dato2, file) {
		
		$.ajax({ 
				data: {'dato1': dato1, 'dato2': dato2},
                url: '../php/'+file,
                type: 'POST',
					 async: false,
                success: function (infoRegreso) {
                	//console.log(infoRegreso);
                	switch (parseInt(infoRegreso)) {
							case -1: 
							$('div#contenido').find('div#msj').html(msjerror3+'Ha ocurrido un error... intenta nuevamente.'+msjerror4);
                		break;
                		case -2: 
							$('div#contenido').find('div#msj').html(msjerror3+'La unidad ya existe, verifica unidades anteriormente.'+msjerror4);
                		break;
                		case -3: 
							$('div#contenido').find('div#msj').html(msjerror3+'La unidad no existe, verifica unidades anteriormente.'+msjerror4);
                		break;
                		case 1:
                		alertify.log('Unidad añadida exitosamente...');
                		$('div#contenido').load('menu/cr-te.php');
                		break;
                		case 2:
                		alertify.log('Unidad eliminada exitosamente...');
                		$('div#contenido').load('menu/cr-te.php');
                		break;
                		default:
                			alertify.log(infoRegreso);
                  	  $('div#contenido').html('<img class="animated fadeIn" src="../../img/logobg.png" alt="">');
                		}
                		Cookies.set('opcion', 'crear-contenido$cr-te');
                	}
            });
		}
		
		 // ---- Funcion para enviar uno o dos datos.
	function eliminarDatos(dato1, dato2, file) {
		
		$.ajax({ 
				data: {'dato1': dato1, 'dato2': dato2},
                url: '../php/'+file,
                type: 'POST',
					 async: false,
                success: function (infoRegreso) {
                console.log(infoRegreso);
                	switch (parseInt(infoRegreso)) {
                		case -1:
							alertify.error('Ha ocurrido un error... intenta nuevamente.');
						break;
						case 1:
                			alertify.log('Tarea eliminada correctamente.');
                  	  		$('div#contenido').find('div#t-'+dato1).remove();
                  		break;
						case 2:
								var res = dato1.substring(0, 8);
								$('div#contenido').find('div#'+res).remove();
                			alertify.log('Documento eliminado correctamente.');
                  		break;
						case 3:
								$('div#contenido').find('div#bandeja-env div#'+dato1).remove();
                  		break;
                		}
                	}
            });
		}
		
				 // ---- Funcion para enviar uno o dos datos.
	function obtenerDatos(dato1, dato2, file) {
		
		$.ajax({ 
				data: {'dato1': dato1, 'dato2': dato2},
                url: '../php/'+file,
                type: 'POST',
					 async: false,
                success: function (infoRegreso) {
                	//console.log(infoRegreso);
                	switch (parseInt(infoRegreso)) {
                		case -1:
							alertify.error('El grupo aún no tiene alumnos.');
							break;
							default:  $('div#contenido').find(dato2).html(infoRegreso);
                		}
                	}
            });
		}
        
        				 // ---- Funcion para enviar uno o dos datos.
	function obtenerAct(dato1, dato2, file) {
		
		$.ajax({ 
				data: {'dato1': dato1, 'dato2': dato2},
                url: '../php/'+file,
                type: 'POST',
					 async: false,
                success: function (infoRegreso) {
                	//console.log(infoRegreso);
                    $('div#mis-msj').html(infoRegreso).fadeIn().delay(2000);
                	}
            });
		}
	
});