<?php
include('../../php/consultar-ediciones.php');
$datos = explode('-', $_COOKIE['data']);
$id = $datos[2];

$obj = new Ediciones();
$info = $obj->contarPreguntas($datos[2]);

$date1 = explode(':', $info[0]);
$date2 = explode(':', $info[1]);
setcookie('data', $_COOKIE['data'].'-'.$info[3], 0, "/");
?>
<!-- Modal -->
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-calendar fa-lg'></i> Editar Examen para el Grupo: <span class="label focus">
	<?php $datos = explode('-', $_COOKIE['data']); echo $datos[0]; ?>
</span></div>
				<form class="form" id="editar-examen">
							
							<div class="row align-center gutters">
						      <div class="col col-3">
						      <br><br>
									<div class="form-item">
							        <label>Fecha/Hora de Inicio</label>
							        <?php echo '<input id="fecha" name="fec-ini" type="text" value="'.$date1[0].':'.$date1[1].'">'; ?>
							    </div>
								</div>
								<div class="col col-3">
								<br><br>
									<div class="form-item">
							        <label>Fecha/Hora Límite</label>
							        <?php echo '<input id="fecha" name="fec-lim" type="text" value="'.$date2[0].':'.$date2[1].'">'; ?>
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
								$obj->comboUnidad($info[2]); 
							?>

							</div>
							</div>
							<br>
                                
								<hr>
								<div id="preguntas" class="row gutters align-center">
                                <?php
                                 $obj->editarExamen($id);       
                                ?>
								</div>
								<hr>
                                <div class="row align-center">
                                    <div class="col col-3">
                                    <button class="button w100 animated fadeIn" id="guardar">Guardar</button>
                                    </div>
                                </div><br>
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