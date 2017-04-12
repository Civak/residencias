<!-- Modal -->
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-list fa-lg'></i> Edición de Exámenes del Grupo: <span class="label focus">
	<?php $datos = explode('-', $_COOKIE['data']); echo $datos[0]; ?>
</span></div>
	<div class="row align-center">
		<div class="col col-8">
				<?php 
					include('../../php/consultar-ediciones.php');
					$obj = new Ediciones();
					$obj->consultarExamenes();
				?>
		</div>
	</div>
</div>