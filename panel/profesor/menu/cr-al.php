<!-- Modal -->
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-users fa-lg'></i> Cargar Alumnos al Grupo: <span class="label focus">
	<?php $datos = explode('-', $_COOKIE['data']); echo $datos[0]; ?>
</span></div>
				

							</div>
							<form class="form" id="cargar-alumnos">
							<div class="row align-center borde">
								<div class="col col-4"><br>
								<input id="archivo" type="file" name="archivo">
								</div>
								<div class="col col-4"><br>
								<span class="req" style="font-size: 14px;">Selecciona un archivo CSV con los alumnos para cargarlos al grupo.</span>
								</div>							
							</div>
							<script type="text/javascript">
									$(document).ready(function () {
										$('input#archivo').ezdz();
									});
								</script>
							<br><br>
							<div class="row align-center">
								<div class="col col-3">
								<button class="button w100 animated fadeIn" id="guardar">Guardar</button>
								</div>
							</div>
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