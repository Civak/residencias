
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-send fa-lg'></i> Escribir Mensaje</div>
<form id="msj-pprof">
<div class="row align-center">
<div class="col col-4">
<br><br>
<hr>
	 <div class="form-item">
	  <label>El mensaje lo recibirá el profesor del grupo</label>
	  <select name="grupo" id="grupo">
		<?php
			include('../../php/prof-alumnos.php');
			$obj = new Alumnos();
			$obj->gruposAlumno();
		?>	  
	  </select>
	 </div>
	  <br><hr>
	  </div>
</div>
	  <?php
	  	include('editor.php');
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

});
</script>

