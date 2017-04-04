<!-- Modal -->
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-file-text-o fa-lg'></i> Crear Temario del Grupo: <span class="label focus">
	<?php $datos = explode('-', $_COOKIE['data']); echo $datos[0]; ?>
</span></div>
				<form class="form" id="editar-temario"><br>
							<div class="row align-right">
						    <div class="col col-4">					    
								<button class="button small" id="add-uni">Añadir Unidad</button>
								<button class="button secondary small" id="elim-uni">Eliminar Unidad</button>
							</div>
							</div><br>
						    <div class="row align-center">
						    <div class="col col-4 borde">					    
							<?php
								include('../../php/unidades-grupo.php');
								$obj = new Unidades();
								$obj->consultarUnidadesEdit();  
							?>

							</div>
							</div>
							<br>
							<div id="temario"></div>
							<br>
							<div id="msj"></div>						    
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