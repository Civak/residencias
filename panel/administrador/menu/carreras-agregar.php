<!-- Modal -->
<div class="row align-center">
	<div class="col col-6">
		<div  class="animated fadeIn">
		    <div class="modal" style="border: 1px solid #DDD;">
		        <div class="modal-header gradient"><span class="label focus"><i class='fa fa-plus'></i> Agregar nueva carrera</span><br><span class="label tag error">Todos los campos son obligatorios</span></div>
		        <div class="modal-body">
			        <form class="form" id="carreras-agregar">
						    <div class="form-item">
						        <label>id Carrera</label>
						        <input  data-tipso="3 o 4 letras mayúsculas: ABCD" type="text" id="idCarrera" name="idCarrera" class="width-100" required>
						    </div>
						
						    <div class="form-item">
						        <label>Carrera</label>
						        <input   data-tipso="Nombre de la carrera" type="text" id="carrera" name="carrera" class="width-100" required>
						    </div>

								<div id="msj"></div>						    
						    
						    <div class="row">
								    	<div class="col col-6">
								    		<div class="form-item">
										    <button type="submit" class="button small" id="guardar"><i class="fa fa-check fa-lg"></i> Guardar carrera</button>
										    </div>
								    	</div>
										<div class="col col-5 offset-1">
										    <div class="form-item">
										    <button class="button secondary small" id="cancel"><i class="fa fa-ban fa-lg"></i> Cancelar</button>
										    </div>
								    	</div>
							</div>
						    <script type="text/javascript">
						    	$(document).ready(function () {
						    			$("input#idCarrera, input#carrera").tipso({
											  showArrow: true,
											  position: 'top',
											  background: 'rgba(0, 0, 0, 0.5)',
											  color: '#eee',
											  useTitle: false,
											  animationIn: 'bounceIn',
											  animationOut: 'bounceOut',
											  size: 'small'
										});
						    	});
						    </script>
						</form>
		        </div>
		    </div>
		</div>
</div>
</div>