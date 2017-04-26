<!-- Modal -->
<div class="row align-center">
	<div class="col col-8">
		<div  class="animated fadeIn">
		    <div class="modal" style="border: 1px solid #DDD;">
		        <div class="modal-header gradient"><span class="label focus"><i class='fa fa-graduation-cap'></i> Cambiar contraseña de profesor</span><br><span class="label tag error">Todos los campos son obligatorios</span></div>
		        <div class="modal-body">
			        <form class="form" id="personal-pass">
			        		<div class="row align-center">
			        			
			        			<div class="col col-5">
    <div class="form-item">
	  <label>RFC</label>
	  <input type="text" name="rfc" id="rfc">
	 </div>
	 <div class="form-item">
	  <label>Nueva Contraseña</label>
	  <input type="password" name="pass" placeholder="4 a 64 caracteres" id="pass">
	 </div>
	  <div class="form-item checkboxes">
        <label><input type="checkbox" value="ABCD123" id="show-pass"> Mostrar contraseña</label>
    </div>
			        			</div>
						    </div>
						<hr>
			        		<div id="msj"></div>									    
								    <br>
								    <div class="row align-right">
								    	<div class="col col-3">
								    		<div class="form-item">
										    <button type="submit" class="button small" id="guardar"><i class="fa fa-check fa-lg"></i> Guardar </button>
										    </div>
								    	</div>
										<div class="col">
										    <div class="form-item">
										    <button class="button secondary small" id="cancel"><i class="fa fa-ban fa-lg"></i> Cancelar</button>
										    </div>
								    	</div>
									</div>
			        	</form>
			        	</div>
			        	
		        </div>
		    </div>
		</div>
</div>
		
<script type="text/javascript">
$(document).ready(function () {

	 $('form#personal-pass').on('change', 'input#show-pass',function() {
        if($(this).is(":checked")) {
           $('form#personal-pass').find('input#pass').attr('type','text');
        }else {
        	  $('form#personal-pass').find('input#pass').attr('type','password');
        }      
    });
});
</script>

