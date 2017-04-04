<!-- Modal -->
<div class="row align-center">
	<div class="col col-7">
		<div class="animated fadeIn">
		    <div class="modal" style="border: 1px solid #DDD;">
		        <div class="modal-header gradient"><i class='fa fa-list'></i> Catalogo de Materias</div>
		        <div class="modal-body">
			        <form class="form" id="materias-catalogo">
			        		<div class="row align-center">
			        			<div class="col col-10">
			        			
					        		<div class="form-item">
								    <label>Carrera</label>
								        <select class="select" id="carrera-cat" name="carrera-cat">
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
								    <br>
								    <div id="cat-materia"></div>									    
								    
			        			</div>
						    </div>
						</form>
		        </div>
		    </div>
		</div>
</div>
</div>		
