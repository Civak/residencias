/// Variables globales 
	var msjerror1 = '<div class="message error animated fadeIn" data-component="message">El campo: <b>';
	var msjerror2 = '</b> está incorrecto.<span class="close small"></span></div>';
	var msjerror3 = '<div class="message error animated fadeIn" data-component="message"> ';
	var msjerror4 = ' </b><span class="close small"></span></div>';
	
$(document).ready(function () {
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
	   if (typeof file === 'undefined') location.replace('../php/logout.php');
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
	
		/// Click en boton guardar
	$('div#contenido').on('click', 'button#guardar', function (e) {
	e.preventDefault();
	var form = $(this).closest('form').attr('id');
	//console.log(form+' msj');
	if (evaluarModal(form)) {
		switch(form) {
			case 'msj-pprof':
				var formData = new FormData();
				formData.append("grupo", $('div#contenido').find("form#"+form+" select#grupo").val());
				formData.append("msj", $('div#contenido').find("form#"+form+" div#editor").html());
				guardar(formData);
			break;
            case 'env-tar':
                Cookies.set('opcion', 'crear-contenido$re-pe');
				var formData = new FormData($('div#contenido').find("form#"+form)[0]);
				formData.append("msj", $('div#contenido').find("form#"+form+" div#editor").html());
				guardar(formData);
			break;
            case 'change-pass':
                Cookies.set('opcion','editar-contenido$al-pass');
				guardarFormData($('div#contenido').find("form#"+form)[0]);
            break;
			default: guardarFormData($('div#contenido').find("form#"+form)[0]);
			}
		
		
	}
});

	 /// Click en cruz para eliminar mensaje
  	$('div#contenido').on('click', 'div#bandeja-env i', function (e) {
		e.preventDefault();
	   var tipo = $(this).attr('id');
	   alertify.confirm('Eliminarás el mensaje selecionado, ¿deseas continuar?',
			    function () {
					Cookies.set('opcion', 'bandeja$msj-elim-profe');
					eliminarDatos(tipo, '', 'bandeja.php');
			    }, function() {
			      
			    });
  });
     /// Click en boton de entregar tarea
  	$('div#contenido').on('click', 'div.temario button', function (e) {
		e.preventDefault();
	   var tipo = $(this).attr('id');
       if (typeof tipo !== 'undefined'){
           Cookies.set('act', 'env-tar');

           $.ajax({ 
				data: {'dato1': tipo},
                url: '../php/updates.php',
                type: 'POST',
					 async: false,
                success: function (infoRegreso) {
                	//console.log(infoRegreso);
                    if(parseInt(infoRegreso) == 1){
                        alertify.alert('La tarea ya fue enviada con anterioridad.');
                        }else{
                            Cookies.set('tarea', tipo);
                            $('div#contenido').load('menu/env-tar.php');
                        }
                	}
            });   
       }
  });
    /// Clicks en panel tareas pendientes
	$('div.tareas-p').on('click', 'div', function (e) {
		e.preventDefault();
		console.log('funciona');
	   var tipo = $(this).attr('id');
		var op = tipo.split('-');
		Cookies.set('data', tipo+'-'+op[1]);
		$('div#tareas-info').find('div.modal-body').load('menu/info-tarea.php');	   
  });
      /// Clicks en panel tareas pendientes
	$('div#contenido').on('click', 'div.rev-tareas a', function (e) {
		e.preventDefault();
		console.log('funciona');
	   var tipo = $(this).attr('id');
		Cookies.set('data', tipo);
		$('div#tareas-entre').find('div.modal-body').load('menu/det-tarea.php');	   
  });

    setInterval(function()
    {
        $('div#mis-msj').fadeOut(400, function(){
            Cookies.set('act','mis-msj-alu');
            obtenerAct('','','updates.php');
        });
    }, 30000);

  /********************************************************************
  *************** Sección de funciones
  *********************************************************************/
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
			case 'msj-pprof': 
				return validarMsj(inputs, labels, modal);
			break;
            case 'env-tar': 
                return validarTarea(inputs, labels, modal);
			break;
            case 'change-pass': 
                return validarNvoPassAlu(inputs, labels, modal);
			break;
			}	
	}
					/// validar envio de mensaje
function validarMsj(inputs, labels, modal) {
			var contenido = $('div#contenido').find("form#"+modal+" div#editor").html();
			for (var i = 0; i < inputs.length; i++){
				if (inputs[i].length == 0) {
				$('div#contenido').find('div#msj').html(msjerror3+'Selecciona un grupo'+msjerror4);
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
function validarTarea(inputs, labels, modal) {
			var contenido = $('div#contenido').find("div#editor").html();
                if (contenido.length == 0){
                    $('div#contenido').find('div#msj').html(msjerror3+'Debes crear contenido antes de guardar.'+msjerror4);
                        return false;
                }
		return true;
	}
    /// Valida nuevo pass
	function validarNvoPassAlu(inputs, labels, modal) {
		for (var i = 0; i < inputs.length; i++) {     
			if (inputs[i].length < 4) {
		    	$('div#contenido').find('div#msj').html(msjerror3+'Escribe una contraseña de al menos 4 caracteres.'+msjerror4);
		        return false;
		    }
		}
		return true;
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
               	case -1:
                       $('div#contenido').find('div#msj').html(msjerror3+'Ha ocurrido un error'+msjerror4);
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
						case 3:
								$('div#contenido').find('div#bandeja-env div#'+dato1).remove();
                  		break;
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
    function verificarTarea(dato1, dato2, file) {
		
		$.ajax({ 
				data: {'dato1': dato1, 'dato2': dato2},
                url: '../php/'+file,
                type: 'POST',
					 async: false,
                success: function (infoRegreso) {
                	//console.log(infoRegreso);
                    return infoRegreso;
                	}
            });
		}
});