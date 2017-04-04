
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-user fa-lg'></i> Escribir Mensaje en un Grupo</div>
<div class="row align-center">
<div class="col col-4">
<form id="msj-pgru">
<br><br>
<hr>
	 <div class="form-item">
	  <label>Mensaje para el Grupo</label>
	  <select>
		<?php
			include('../../php/prof-alumnos.php');
			$obj = new Alumnos();
			$obj->misGrupos();
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

