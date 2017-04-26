<!-- Modal -->
<div class="row align-center">
	<div class="col col-10">
		<div class="animated fadeIn">
		    <div class="modal" style="border: 1px solid #DDD;">
		        <div class="modal-header gradient"><span class="label focus"><i class='fa fa-list'></i> Catalogo Personal</span></div>
		        <div class="modal-body">
			        <form class="form" id="personal-editar">
			        		<div class="row align-center">
			        			<div class="col col-10">
			        			
					        		<div class="form-item">
								    <label>Carrera</label>
								        <select class="select" id="carrera-edit" name="carrera-edit">
								            <option value="">-- Selecciona --</option>
								            <?php
													include('../../php/generarCombos.php');
													$combo = new GenerarCombos();
													$combo->generarComboCarreras();
												?>	
								        </select>
								    </div>
								    									
									<br>
								    <div id="msj"></div>
								    <div id="cat-personal"></div>									    
								    <br>
								    <div class="row align-right">
										<div class="col">
										    <div class="form-item">
										    <button class="button secondary small" id="cancel"><i class="fa fa-ban fa-lg"></i> Cancelar</button>
										    </div>
								    	</div>

			        			</div>
						    </div>
						    <script type="text/javascript">
						    	$(document).ready(function () {
						    			$("i#editar-mat, i#eliminar-mat").tipso({
											  showArrow: true,
											  position: 'bottom',
											  background: 'rgba(0, 0, 0, 0.5)',
											  color: '#eee',
											  useTitle: false,
											  animationIn: 'fadeIn',
											  animationOut: 'fadeOut',
											  size: 'small'
										});
                                    
                                       $('form#personal-editar').on('click','i', function(){
                                          var tipo = $(this).attr('id');
                                          var quien = $(this).parent('div').attr('id');
                                           
                                          switch(tipo){
                                              case 'editar-per':
                                               Cookies.set('dato', quien);
                                               $('div#contenido').load('menu/personal-modificar.php');   
                                                  break;
                                              case 'eliminar-per':
                                                   alertify.confirm('Eliminarás el/la Profesor/a selecionado, ¿deseas continuar?',
                                                        function () {
                                                            Cookies.set('opcion', 'personal-eliminar');
                                                            eliminarDatos(quien, '', 'personal.php');
                                                        }, function() {

                                                        });
                                                  break;
                                                     }
                                       });
                                    
        function eliminarDatos(dato1, dato2, file) {
		
		$.ajax({ 
				data: {'dato1': dato1, 'dato2': dato2},
                url: '../php/'+file,
                type: 'POST',
					 async: false,
                success: function (infoRegreso) {
                   // console.log(infoRegreso+dato1);
                	switch (parseInt(infoRegreso)) {
                		case -1:
							alertify.error('Ha ocurrido un error... intenta nuevamente.');
						break;
						case 1:
                			alertify.log('Profesor eliminado correctamente.');
                            Cookies.set('opcion', 'personal-editar');
                            $('div#cat-personal').find('div#'+dato1).remove();
                  		break;
                		}
                	}
            });
		}
						    	});
						    </script>
						</form>
		        </div>
		    </div>
		</div>
</div>
</div>		
