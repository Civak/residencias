<!-- Modal -->
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-list-alt fa-lg'></i> Crear Tema en Foro del Grupo: <span class="label focus">
	<?php $datos = explode('-', $_COOKIE['data']); echo $datos[0]; ?>
</span></div>
				<form class="form" id="foro">
							<br>
							<?php include('editor.php'); ?>
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