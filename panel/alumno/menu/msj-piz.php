
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-send fa-lg'></i> Pizarra</div>

<div class="row align-center">
<div id="bandeja-env" class="col col-9" style="overflow-y: auto; height:640px;">
<br><br>
<hr>

		<?php
			include('../../php/prof-alumnos.php');
			$obj = new Alumnos();
			$obj->pizarra();
		?>	  


	  <br><hr>
	  </div>
</div>
	<br>
	<div id="msj"></div>

<br><br>
	<div class="row align-right">
				<div class="col col-2">
				    <div class="form-item">
				    <button class="button secondary small" id="cancel">Inicio</button>
				    </div>
		    	</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function () {

});
</script>

