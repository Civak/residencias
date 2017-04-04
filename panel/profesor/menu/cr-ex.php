<!-- Modal -->
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-calendar fa-lg'></i> Programar examen para el Grupo: <span class="label focus">
	<?php $datos = explode('-', $_COOKIE['data']); echo $datos[0]; ?>
</span></div>
				<form class="form" id="crear-examen">
							
							<div class="row align-center gutters">
						      <div class="col col-3">
						      <br><br>
									<div class="form-item">
							        <label>Fecha/Hora de Inicio</label>
							        <input id="fecha" type="text">
							    </div>
								</div>
								<div class="col col-3">
								<br><br>
									<div class="form-item">
							        <label>Fecha/Hora Límite</label>
							        <input id="fecha" type="text">
							    </div>
								</div>
								<div class="col col-3">
								<script type="text/javascript">
									$(document).ready(function () {
										$('input#fecha').intimidatetime({
											previewFormat: 'yyyy-MM-dd HH:mm'										
										});
										$('input#archivo').ezdz();
									});
								</script>

						    	<br><br>					    
							<?php
								include('../../php/unidades-grupo.php');
								$obj = new Unidades();
								$obj->consultarUnidadesTareas(); 
							?>

							</div>
							</div>
							<br>
								<div class="row align-center">
									<div class="col col-2">
											<div class="form-item">
										    <button class="button small" id="op-mul"> Opción múltiple</button>
										    </div>
									</div>
									<div class="col col-2">
											<div class="form-item">
										    <button class="button small" id="c"> Pregunta abierta</button>
										    </div>
									</div>
									<div class="col col-2">
									<div class="form-item">
										    <button class="button small" id="c"> Archivo</button>
										    </div>
									</div>
									</div>								
								<hr>
								<div id="preguntas" class="row" style="margin: 2%;">							
								</div>
								
								<hr>
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