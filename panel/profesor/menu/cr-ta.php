<!-- Modal -->
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-list-alt fa-lg'></i> Crear Tarea del Grupo: <span class="label focus">
	<?php $datos = explode('-', $_COOKIE['data']); echo $datos[0]; ?>
</span></div>
				<form class="form" id="crear-tarea">
							
							<div class="row align-center">
								<div class="col col-5"><br>
								<div class="form-item">
							        <label><b>Título de la Tarea</b></label>
							        <input id="titulo" name="titulo" type="text">
							    </div>
								</div>							
							</div>
							<div class="row align-center gutters">
						      <div class="col col-3">
						      
									<div class="form-item">
							        <label>Fecha/Hora de Inicio</label>
							        <input id="fecha" name="fec-ini" type="text">
							    </div>
								</div>
								<div class="col col-3">
								
									<div class="form-item">
							        <label>Fecha/Hora Límite</label>
							        <input id="fecha" name="fec-lim" type="text">
							    </div>
								</div>
								<div class="col col-3">
								<script type="text/javascript">
									$(document).ready(function () {
										$('input#fecha').intimidatetime({
											previewFormat: 'yyyy-MM-dd HH:mm',									
										});
										$('input#archivo').ezdz();

									});
								</script>
						    					    
							<?php
								include('../../php/unidades-grupo.php');
								$obj = new Unidades();
								$obj->consultarUnidadesTareas(); 
							?>

							</div>
							</div>
							<div class="row align-center borde">
								<div class="col col-4">
								<div class="desc">Campo Opcional</div><br>
								<input id="archivo" name="archivo" type="file">
								</div>
								<div class="col col-4"><br><br>
								<span class="req" style="font-size: 14px;">Sólo se permite cargar un archivo por tarea, en caso de ser más archivos,
								 comprimirlos en formato ZIP o RAR.</span>
								</div>							
							</div>
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