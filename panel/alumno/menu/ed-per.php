<?php
include('../../php/prof-alumnos.php');
$obj = new Alumnos();
$info = explode(',', $obj->consultarAlumnoEdit());
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
                                            <?php
                                            echo '<img id="preview" src="./img/'.$info[1].'" style="height: 100%; width: 100%; object-fit: contain" class="animated" alt="Imagen de  Perfil" />';
                                            ?>
											
			        					</div>
			        				</div>
			        				<br><hr>
			        				<div class="row align-center">
			        					<div class="col col-4">
											<div class="form-item">
											<label>Nombre</label>
										       <?php echo '<input type="text" name="nom" value="'.$info[0].'">'; ?>
										    </div>
			        					</div>
			        				</div>
    <br>
    <div id="msj"></div>
			        				<br><hr>
    <div class="row align-center">
        <div class="col col-3">
        <button class="button w100 animated fadeIn" id="guardar">Guardar</button>
        </div>
    </div>
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