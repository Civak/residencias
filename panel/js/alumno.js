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
    /// Clicks en panel tareas pendientes
	$('div.tareas-p').on('click', 'div', function (e) {
		e.preventDefault();
		console.log('funciona');
	   var tipo = $(this).attr('id');
		var op = tipo.split('-');
		Cookies.set('data', tipo+'-'+op[1]);
		$('div#tareas-info').find('div.modal-body').load('menu/info-tarea.php');	   
  });

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
});