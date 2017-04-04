<!-- Modal -->
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-list fa-lg'></i> Panel de Unidades del Grupo: <span class="label focus">
	<?php $datos = explode('-', $_COOKIE['data']); echo $datos[2]; ?>
</span></div>
<div class="row align-center">
	<div class="col col-4"><br>
		<div class="form-item">
	    <label>Unidades</label>
	        <select class="select" id="carrera-grup" name="carrera-grup">
	            <option value="">-- Selecciona --</option>
	            <?php
						include('../../php/unidades-grupo.php');
						$combo = new Unidades();
						$combo->consultarUnidades();
					?>	
	        </select>
	    </div>
	    
	      <div class="row">
				    	<div class="col col-5">
				    		<div class="form-item">
						    <button type="submit" class="button small" id="guardar"> Añadir Contenido</button>
						    </div>
				    	</div>
						<div class="col col-5 offset-2">
						    <div class="form-item">
						    <button class="button secondary small" id="cancel">Editar Contenido</button>
						    </div>
				    	</div>
			</div>
	</div>
</div>
</div>