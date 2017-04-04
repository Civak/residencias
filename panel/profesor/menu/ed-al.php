<!-- Modal -->
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-user-times fa-lg'></i> Editar Alumno(a) del Grupo: <span class="label focus">
	<?php $datos = explode('-', $_COOKIE['data']); echo $datos[0]; ?>
</span></div>
	<div class="row align-center">
		<div class="col col-6 temario">
				&nbsp;&nbsp;&nbsp;&nbsp;<button id="pass" class="button">Contraseña</button>&nbsp;&nbsp;&nbsp;&nbsp;
				<button id="edit" class="button">Editar</button>&nbsp;&nbsp;&nbsp;&nbsp;
				<button id="eliminar" class="button">Eliminar</button>
		</div>
	</div>
	<div class="row align-center">
		<div class="col col-5">
				<div id="edicion"></div>
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
</div>
<script type="text/javascript">
$(document).ready(function () {
	$('button#pass').on('click', function () {
		$('div#edicion').load('menu/pass-alu.php');
	});
	$('button#edit').on('click', function (e) {	
		e.preventDefault();
	   	alertify.prompt("Ingresa el No. de Control...",
			    function (val, ev) {
			      ev.preventDefault();
					if (!$.isNumeric(val) || val.length != 8) alertify.alert('EL No. de Control no tiene el formato correcto.'); 
					else{
						Cookies.set('noc', val);
						$('div#edicion').load('menu/edit-alu.php');
					}
			    }, function(ev) {
			      ev.preventDefault();
			
			    });
		
	});
	$('button#eliminar').on('click', function (e) {	
			$('div#edicion').load('menu/elim-alu.php');
	});
	
	
	 $('div#edicion').on('change', 'input#show-pass',function() {
        if($(this).is(":checked")) {
           $('div#edicion').find('input#pass').attr('type','text');
        }else {
        	  $('div#edicion').find('input#pass').attr('type','password');
        }      
    });
});
</script>