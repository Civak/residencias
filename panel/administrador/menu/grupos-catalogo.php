<!-- Modal -->
<div class="row align-center">
	<div class="col col-10">
		<div class="animated fadeIn">
		    <div class="modal" style="border: 1px solid #DDD;">
		        <div class="modal-header gradient"><span class="label focus"><i class='fa fa-list'></i> Catálogo de Grupos</span></div>
		        <div class="modal-body">
			        <form class="form" id="grupos-catalogo">
			        		<div class="row">
			        			<div class="col col-5">
			        			
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
								   </div>
								   <div class="col col-5 offset-2">
										<div class="form-item">
								    <label>Materia</label>
								        <select class="select" id="materia-cata" name="materia-cata">
								            <option value="">-- Selecciona --</option>	
								        </select>
								    </div>								   
								   </div> 
		
						    </div>	
						    								
									<br>
								    <div id="msj"></div>
								    <div id="catalogo"></div>									    
								    <br>
								    <div class="row align-right">
								    	<div class="col col-3">

								    	</div>
										<div class="col col-3">
										    <div class="form-item">
										    <button class="button secondary small" id="cancel"><i class="fa fa-ban fa-lg"></i> Cancelar</button>
										    </div>
								    	</div>
							</div>
						</form>
		        </div>
		    </div>
		</div>
</div>
</div>		
