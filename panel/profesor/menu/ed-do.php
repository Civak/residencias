
<div class="animated fadeIn">

	<div class="modal-header gradient"><i class='fa fa-close fa-lg'></i> Eliminar Documentos del Grupo: <span class="label focus">
	<?php $datos = explode('-', $_COOKIE['data']); echo $datos[0]; ?>
</span></div><br><br>
		       		<div class="row align-center">
		       		<div class="col col-8">
				            <?php
				            include('../../php/editar-contenido.php');
								$obj = new Editar();
								$obj->consultarTemario(); 
								?>	
						</div>
						</div>
</div>