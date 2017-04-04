<!-- Modal -->
<div class="row align-center">
	<div class="col col-7">
		<div class="animated fadeIn">
		    <div class="modal" style="border: 1px solid #DDD;">
		        <div class="modal-header gradient"><span class="label focus"><i class='fa fa-plus'></i> Agregar Materia</span><br><span class="label tag error">Todos los campos son obligatorios</span></div>
		        <div class="modal-body">
			        <form class="form" id="materias-agregar">
			        		<div class="row align-center">
			        			<div class="col col-10">
			        			
					        		<div class="form-item">
								    <label>Carrera</label>
								        <select class="select" id="carrera" name="carrera">
								            <option value="">-- Selecciona --</option>
								            <?php
													include('../../php/generarCombos.php');
													$combo = new GenerarCombos();
													$combo->generarComboCarreras();
												?>	
								        </select>
								    </div>
								    

									<div class="form-item">
								        <label>Nombre de Materia</label>
								        <input  data-tipso="Máximo 128 caracteres" type="text" id="materia" name="materia">
								    </div>
								    
								    <div id="msj"></div>									    
								    <br>
								    <div class="row">
								    	<div class="col col-7">
								    		<div class="form-item">
										    <button type="submit" class="button small" id="guardar"><i class="fa fa-check fa-lg"></i> Guardar materia</button>
										    </div>
								    	</div>
										<div class="col">
										    <div class="form-item">
										    <button class="button secondary small" id="cancel"><i class="fa fa-ban fa-lg"></i> Cancelar</button>
										    </div>
								    	</div>
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
