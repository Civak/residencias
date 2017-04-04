<?php
include('../../php/prof-alumnos.php');
$obj = new Alumnos();
$info = $obj->consultarAlumno();
$in = '';

	if(intval($info) != -1) {
		$in = explode(',', $info);
	}else {
		$in = array('','','','<div class="message error" data-component="message">No existe ningún alumno con ese número de control.<span class="close small"></span></div>');
	}
	setcookie('noc', null, -1, '/');
?>
<br><br>
<hr>
<div class="animated fadeIn">
<form id="change-edit-alu">
	<div class="form-item">
	  <label>No. Control</label>
	  <?php echo '<input type="text" name="noc" value="'.$in[0].'"><input type="hidden" name="noc-h" value="'.$in[0].'">'; ?>
	 </div>
	 <div class="form-item">
	  <label>Nombre</label>
	  <?php echo '<input type="text" name="nom" value="'.$in[1].'">'; ?>
	 </div>
	 <div class="form-item form-checkboxes">
	 <?php 
	 	if(strcasecmp($in[2], 'S') == 0) {
	 		echo '<label><input type="radio" id="activo" name="activo" value="S" checked><span class="label  success"> Activo</span></label>
        <label><input type="radio" id="activo" name="activo" value="N"><span class="label  error"> Baja</span></label>'; 
	 		}
	 	if(strcasecmp($in[2], 'N') == 0){
				echo '<label><input type="radio" id="activo" name="activo" value="S"><span class="label  success"> Activo</span></label>
        <label><input type="radio" id="activo" name="activo" value="N" checked><span class="label  error"> Baja</span></label>';	 		
	 		}
	 ?>
        
    </div>
    <div class="row align-center">
		<div class="col col-5">
		<button class="button w100 animated fadeIn" id="guardar">Guardar</button>
		</div>
	</div>
	<br>
	<div id="msj">
	<?php echo $in[3]; ?>
	</div>
</form>
</div>

