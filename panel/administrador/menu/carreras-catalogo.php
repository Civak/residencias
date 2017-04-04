<!-- Modal -->
<div class="row align-center">
	<div class="col col-12">
		<div  class="animated fadeIn">
		    <div class="modal" style="border: 1px solid #DDD;">
		        <div class="modal-header gradient"><span class="label focus"><i class='fa fa-list'></i> Catálogo de Carreras</span></div>
		        <div class="modal-body">
			        <form class="form" id="carreras-catalogo">
						    <div class="form-item">
								<div id="msj"></div>						    
							<?php
								include('../../php/catalogos.php');
								$obj = new Catalogos();
								$obj->catalogoCarrera(); 
							?>						    
						    <br><br><br>
						    <div class="row align-right">
										<div class="col col-2">
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