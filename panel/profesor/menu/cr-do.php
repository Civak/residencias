
<div class="animated fadeIn">

	<div class="modal-header gradient"><i class='fa fa-cloud-upload fa-lg'></i> Cargar Documentos al Grupo: <span class="label focus">
	<?php $datos = explode('-', $_COOKIE['data']); echo $datos[0]; ?>
</span></div><br><br>
		       		<div class="row align-center">
		       		<div class="col col-5 box-file">
		        	  <div class="row" id="contador">
							<div class="col col-5">Archivos: <span id="cuantos">1</span><br><span class="label tag error">Máximo 5 archivos</span></div>
							<div class="col col-5"></div>	
							<div class="col col-2"><button id="add-file" data-tipso="Añadir más archivos" type="button" class="button round"><i class="fa fa-plus fa-lg"></i></button></div>				        
			        </div><br>
			        
			        <form class="form" id="cargar-documentos">
			        <div class="form-item">
								            <?php
								            include('../../php/unidades-grupo.php');
												$obj = new Unidades();
												$obj->consultarUnidadesDocs(); 
												?>	
						</div>
						    <div class="form-item" id="botones">
						        <label id="arch1" class="archivo width-50"><i class="fa fa-upload fa-lg"></i> Cargar archivo</label>
						        <input  type="file" class="inputArchivo" id="arch1" name="arch1" class="width-100">
						        <div class="nomArch" id="arch1"></div>
						    </div>
						    <br>
								<div class="row align-center">
									<div class="col col-6">
									<button class="button w100 animated fadeIn" id="guardar">Guardar</button>
									</div>
								</div>
								<br>
								<div id="msj"></div>
								
						    <script type="text/javascript">
						    	$(document).ready(function () {
						    		$("button#add-file").tipso({
											  showArrow: true,
											  position: "right",
											  background: "rgba(0, 0, 0, 0.5)",
											  color: "#eee",
											  useTitle: false,
											  animationIn: "fadeIn",
											  animationOut: "fadeOut",
											  size: "small"
										});
										$('form#cargar-documentos').on("click", 'span#elimina' , function () {
											$(this).closest('div').remove();
											var cuantos = parseInt($('div#contador').find('span#cuantos').text()) - 1;
											$('div#contador').find('span#cuantos').text(cuantos);
									    });						    		
						    		
										$('form#cargar-documentos').on("click", 'label.archivo' , function () {
											var cual = $(this).attr('id');
									        $('form#cargar-documentos').find('input#'+cual).click();
									    });
									   
										$('button#add-file').on('click', function () {;
											var cuantos = parseInt($('div#contador').find('span#cuantos').text()) + 1;
											if (cuantos <= 5) {
												$('div#contador').find('span#cuantos').text(cuantos);
												var nvoarch = '<div class="form-item animated fadeIn"><span id="elimina" style="float: right; cursor: pointer;" class="label badge error">Eliminar</span><label id="arch'+cuantos+'" class="archivo width-50"><i class="fa fa-upload fa-lg"></i> Cargar archivo</label><input  type="file" class="inputArchivo" id="arch'+cuantos+'" name="arch'+cuantos+'"><div class="nomArch" id="arch'+cuantos+'"></div></div>';
												$('form#cargar-documentos').find('div#botones').after(nvoarch);
											}
											else {
												alertify.log('Máximo 5 archivos...');
											}
										});									   
									   
									   $('form#cargar-documentos').on('change', 'input', function () {
									   	var cual = $(this).attr('id');
									   	if(this.files[0].size > 6291456){
									   		$(this).val('');
												alertify.log('<i class="fa fa-warning"></i> El archivo sobrepasa los 6 Mb.');									   	
									   	}else{
												$('form#cargar-documentos').find('div#'+cual).text("Nombre: "+$(this).val().split('\\').pop());
												}
									   });
						    	});
						    </script>
						</form>
						</div>
						</div>
</div>