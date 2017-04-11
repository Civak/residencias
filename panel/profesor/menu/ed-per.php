<?php
include('../../php/prof-alumnos.php');
$obj = new Alumnos();
$info = explode('$', $obj->consultarProfesor());
?>
<!-- Modal -->
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-user fa-lg'></i> Editar / Actualizar Perfil</div>
<form id="edit-per">
<br>
			        				<div class="row align-center" style="margin-bottom: 2%;">
			        					<div class="col col-4">
			        					<label>Selecciona una imagen <span class="desc">Opcional</span></label>
			        					</div>
			        				</div>
			        				<div class="row align-center">
			        					<div class="col col-4 hoverBtn">
											<div class="divbutton">
								        		<label for="sel-img">
								        		<div class="button  small w100 animated zoomIn">Cargar imagen</div>
								        		</label>
								        		<input  type="file" id="sel-img" name="sel-img">
											</div>
											<?php echo '<img id="preview" src="./img/'.$info[0].'" style="height: 100%; width: 100%; object-fit: contain" class="animated" alt="Imagen de  Perfil" />'; ?>
			        					</div>
			        				</div>
			        				<br><hr>
			        				<div class="row gutters">
			        					<div class="col col-4">
											<div class="form-item">
											<label>Nombre</label>
										       <?php echo '<input type="text" name="nom" value="'.$info[1].'">'; ?>
										    </div>
			        					</div>
			        					<div class="col col-4">
											<div class="form-item">
											<label>Apellido Paterno</label>
										       <?php echo '<input type="text" name="apep" value="'.$info[2].'">'; ?>
										    </div>
			        					</div>
			        					<div class="col col-4">
											<div class="form-item">
											<label>Apellido Materno</label>
										       <?php echo '<input type="text" name="apem" value="'.$info[3].'">'; ?>
										    </div>
			        					</div>
			        				</div>
			        				<br><hr>
			        				<div class="row align-center gutters">
			        					<div class="col col-4">
											<div class="form-item">
											<label>Email</label>
										       <?php echo '<input type="text" name="ema" value="'.$info[4].'">'; ?>
										    </div>
			        					</div>
			        					<div class="col col-4">
											<div class="form-item">
											<label>Teléfono <span class="desc">Opcional</span></label>
										       <?php echo '<input type="text" name="tel" value="'.$info[5].'">'; ?>
										    </div>
			        					</div>
			        				</div>
			        				<br><hr>
			        				<div class="row align-center">
										<div class="col col-5">
										<b>Experiencia Laboral / Curriculum Vitae</b><span class="desc">Opcional</span>
										</div>			        				
			        				</div>
			        				<?php
			        					include('editor-contenido.php');
			        				?>
    <br>
    <div id="msj"></div>
</form>
	<br><br>
	<div class="row align-right">
				<div class="col col-2">
				    <div class="form-item">
				    <button class="button secondary small" id="cancel"><i class="fa fa-ban fa-lg"></i> Cancelar</button>
				    </div>
		    	</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function () {
	  $("#sel-img").change(function(){
		        readURL(this);
		    });
		    
 									 function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result).addClass('fadeIn');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
});
</script>