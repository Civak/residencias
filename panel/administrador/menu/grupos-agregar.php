<!-- Modal -->
<div class="row align-center">
	<div class="col col-10">
		<div class="animated fadeIn">
		    <div class="modal" style="border: 1px solid #DDD;">
		        <div class="modal-header gradient"><span class="label focus"><i class='fa fa-share'></i> Asignar grupo a profesor(a)</span></div>
		        <div class="modal-body">
			        <form class="form" id="grupos-agregar">
			        		<div class="row">
			        			<div class="col col-5">
			        			
					        		<div class="form-item">
								    <label>Carrera</label>
								        <select class="select" id="carrera-grup" name="carrera-grup">
								            <option value="">-- Selecciona --</option>
								            <?php
													include('../../php/generarCombos.php');
													$combo = new GenerarCombos();
													$combo->generarComboCarreras();
												?>	
								        </select>
								    </div>
								   </div>
								   <div class="col col-5 offset-2">
										<div class="form-item">
								    <label>Materia</label>
								        <select class="select" id="materia-grup" name="materia-grup">
								            <option value="">-- Selecciona --</option>	
								        </select>
								    </div>								   
								   </div> 
		
						    </div>	
						    
						    <div class="row">
			        			<div class="col col-5">
			        			
					        		<div class="form-item">
								    <label>Profesor</label>
								        <select class="select" id="profesor-grup" name="profesor-grup">
								            <option value="">-- Selecciona --</option>
								        </select>
								    </div>
								   </div>
								   <div class="col col-5 offset-2">
										<div class="form-item">
									        <label>Grupo</label>
									        <input   data-tipso="Nombre de referencia para el Grupo" type="text" id="grupo" name="grupo">
									    </div>								   
								   </div> 
		
						    </div>
						    								
									<br>
								    <div id="msj"></div>
								    <div id="update"></div>									    
								    <br>
								    <div class="row align-right">
								    	<div class="col col-3">
								    		<div class="form-item">
										    <button type="submit" class="button small" id="guardar"><i class="fa fa-check fa-lg"></i> Guardar</button>
										    </div>
								    	</div>
										<div class="col col-3">
										    <div class="form-item">
										    <button class="button secondary small" id="cancel"><i class="fa fa-ban fa-lg"></i> Cancelar</button>
										    </div>
								    	</div>
							</div>
						    <script type="text/javascript">
						    	$(document).ready(function () {
						    			$("input#grupo").tipso({
											  showArrow: true,
											  position: 'bottom',
											  background: 'rgba(0, 0, 0, 0.5)',
											  color: '#eee',
											  useTitle: false,
											  animationIn: 'fadeIn',
											  animationOut: 'fadeOut',
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
