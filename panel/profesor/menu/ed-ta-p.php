<?php
include('../../php/consultar-ediciones.php');
$datos = explode('-', $_COOKIE['data']);
$id = $datos[2];
$obj = new Ediciones();
$info = $obj->consultarTarea($datos[2]);
$date1 = explode(':', $info[1]);
$date2 = explode(':', $info[2]);
setcookie('data', $datos[0].'-'.$datos[1], 0, "/");
?>
<!-- Modal -->
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-list-alt fa-lg'></i> Editar Tarea del Grupo: <span class="label focus">
	<?php $datos = explode('-', $_COOKIE['data']); echo $datos[0]; ?>
</span></div>
				<form class="form" id="editar-tarea">
							
							<div class="row align-center">
								<div class="col col-5"><br>
								<div class="form-item">
							        <label><b>Título de la Tarea</b></label>
							        <?php echo '<input id="titulo" name="titulo" type="text" value="'.$info[3].'">'; ?>
							    </div>
								</div>							
							</div>
							<div class="row align-center gutters">
						      <div class="col col-3">
						      
									<div class="form-item">
							        <label>Fecha/Hora de Inicio</label>
							        <?php echo '<input id="fecha" name="fec-ini" type="text" value="'.$date1[0].':'.$date1[1].'">'; ?>
							    </div>
								</div>
								<div class="col col-3">
								
									<div class="form-item">
							        <label>Fecha/Hora Límite</label>
							        <?php echo '<input id="fecha" name="fec-lim" type="text" value="'.$date2[0].':'.$date2[1].'">'; ?>
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
								echo $info[5]; 
							?>

							</div>
							</div>
							<div class="row align-center borde">
								<div class="col col-4">
								<div class="desc">Campo Opcional</div><br>
								<input id="archivo" name="archivo" type="file">
								</div>
								<div class="col col-4"><br>
								<span class="req" style="font-size: 14px;">Sólo se permite cargar un archivo por tarea, en caso de ser más archivos,
								 comprimirlos en formato ZIP o RAR.</span><br><br> 
								 <?php 
								 if(!empty($info[6])) {
								 	echo 'Archivo actual: <br> <span class="label  focus"> '.$info[6].'</span> <input name="archivo-h" type="hidden" value="'.$info[6].'" >';
									}
									echo '<input name="id-t" type="hidden" value="'.$id.'" >';
								  ?>
								</div>							
							</div>
							<br>
							<?php include('editor-contenido.php'); ?>
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