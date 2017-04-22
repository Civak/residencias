<!-- Modal -->
<div id="foro">
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-list-alt fa-lg'></i> Foro del Grupo: <span class="label focus">
	<?php $datos = explode('-', $_COOKIE['data']); echo $datos[0]; ?>
</span></div><br><hr>
    <div class="row align-center">
        <div class="col col-11">
        <?php
            include('../../php/foro.php');
            $obj = new Foro();
            $cont = $obj->foroAlumno(); 
            if(intval($cont) != -1){
                echo $cont;
            }else{
                echo '<div class="message error" data-component="message">Aún no hay temas en el Foro<span class="close small"></span></div>';
            }
         ?>
        </div>
    </div>

    <?php
        if(intval($cont) != -1) include('editor-com.php');
        //setcookie('tema', null, -1, '/');
    ?>

<br><hr>
    <div class="row align-center">
        <div class="col col-6" style="text-align: center;" id="publicaciones">
            <label>Publicaciones</label>
        <nav class="pagination" >
            <ul>
                <li>
                    <ul>
                    <?php
                        $obj->Paginacion(); 
                     ?>
                    </ul>
                </li>
            </ul>
        </nav>
        </div>
    </div>

</div>
<script>
    $(document).ready(function(){
        
         $('div#publicaciones').on('click', 'a', function (e) {
	       e.preventDefault();
            var id = $(this).attr('href').split('-');
             Cookies.set('tema',id[1]);
             $('div#contenido').find('div#foro').remove();
             $('div#contenido').load('menu/nu-te.php');
        });
        /*
        $('div#contenido').on('click', 'button#gua-com', function (e) {
            
	       e.preventDefault();
            var cont = $('div#contenido').find("div#editor").html();
            if(cont != ''){
                Cookies.set('opcion','crear-contenido$en-coo');
                var formData = new FormData();
				formData.append("com", cont);
                formData.append("id", Cookies.get('tema'));
				guardar(formData, cont);
            }
        });
        
        function guardar(form, cont) {
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
                    console.log(infoRegreso);
                    switch(parseInt(infoRegreso))
                    {
                   case 2:
                    $('div#contenido').find('div#foro').remove();
                    $('div#contenido').load('menu/nu-te.php');
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
		}*/
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
                			alertify.log('Publicación eliminada correctamente.');
                  	  		$('div#contenido').find('div#foro').remove();
                            $('div#contenido').load('menu/ve-fo.php');
                  		break;
                		}
                	}
            });
		}
    });
</script>
</div>