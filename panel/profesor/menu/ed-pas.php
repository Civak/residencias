
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-user fa-lg'></i> Cambiar mi Contraseña</div>
<div class="row align-center">
<div class="col col-4">
<form id="change-pass">
<br><br>
<hr>
	 <div class="form-item">
	  <label>Nueva Contraseña</label>
	  <input type="password" name="pass" id="pass">
	 </div>
	  <div class="form-item checkboxes">
        <label><input type="checkbox" value="ABCD123" id="show-pass"> Mostrar contraseña</label>
    </div>
    <div class="row align-center">
		<div class="col col-5">
		<button class="button w100 animated fadeIn" id="guardar">Guardar</button>
		</div>
	</div>
	<br>
	<div id="msj"></div>
</form>
</div>
</div>
</div>
<br><br>
	<div class="row align-right">
				<div class="col col-2">
				    <div class="form-item">
				    <button class="button secondary small" id="cancel"><i class="fa fa-ban fa-lg"></i> Cancelar</button>
				    </div>
		    	</div>
	</div>
<script type="text/javascript">
$(document).ready(function () {

	 $('form#change-pass').on('change', 'input#show-pass',function() {
        if($(this).is(":checked")) {
           $('form#change-pass').find('input#pass').attr('type','text');
        }else {
        	  $('form#change-pass').find('input#pass').attr('type','password');
        }      
    });
});
</script>

