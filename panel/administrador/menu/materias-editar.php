<!-- Modal -->
<div class="row align-center">
	<div class="col col-7">
		<div class="animated fadeIn">
		    <div class="modal" style="border: 1px solid #DDD;">
		        <div class="modal-header gradient"><span class="label focus"><i class='fa fa-pencil'></i> Editar/Eliminar Materia</span></div>
		        <div class="modal-body">
			        <form class="form" id="materias-editar">
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
								    

									<div class="form-item">
								    <label>Materia</label>
								        <select class="select" id="materia-edit" name="materia-edit">
								            <option value="">-- Selecciona --</option>	
								        </select>
								    </div>									
									<br>
								    <div id="msj"></div>
								    <div id="update"></div>									    
								    <br>
								    <div class="row">
								    	<div class="col col-8">
								    		<i style='cursor: pointer; padding: 3%;' data-tipso="Editar materia" class='fa fa-edit fa-lg label focus  badge outline' id='editar-mat'></i>&nbsp; &nbsp;<i data-tipso="Eliminar materia" style="cursor: pointer; padding: 3%;" id="eliminar-mat" class="fa fa-remove fa-lg label error badge outline"></i>
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
						    	});
						    </script>
						</form>
		        </div>
		    </div>
		</div>
</div>
</div>		
