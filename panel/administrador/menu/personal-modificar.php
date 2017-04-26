<!-- Modal -->
<?php
include('../../php/generarCombos.php');
$conn = new Conexion('../../../php/datosServer.php');
$conn = $conn->conectar();
// ---------------------------------- obtiene datos del profesor que llenan inputs.
$sql = "SELECT * FROM profesores WHERE profesores.rfc = '".$_COOKIE['dato']."'";
$result = $conn->query($sql);
$info = "";
		
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        $info = $row['rfc'].','.$row['nombre'].','.$row['apepat'].','.$row['apemat'].','.$row['carrera'].','.$row['email'].','.$row['activo'].','.$row['telefono'];
	    }
	}
$infoProf = explode(",", $info);
$conn->next_result();

// ------------------------- consulta para checkboxes de tutores
$sql = "SELECT roles.carrera FROM roles WHERE roles.rfc = '".$_COOKIE['dato']."' AND roles.rol = 'P';";
$result = $conn->query($sql);
$tuto = "";
		
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        $tuto .= $row['carrera'].',';
	    }
	}
$conn->next_result();
// ---------------------- consulta para checkboxes de coordinadores
$sql = "SELECT roles.carrera FROM roles WHERE roles.rfc = '".$_COOKIE['dato']."' AND roles.rol = 'C';";
$result = $conn->query($sql);
$coor = "";
		
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        $coor .= $row['carrera'].',';
	    }
	}

// ----------------------------------------------------------------------
	 unset($_COOKIE['dato']);
    setcookie('dato', null, -1, '/');
$conn->close();
?>
<div class="row align-center">
	<div class="col col-10">
		<div  class="animated fadeIn">
		    <div class="modal" style="border: 1px solid #DDD;">
		        <div class="modal-header gradient"><span class="label focus"><i class='fa fa-graduation-cap'></i> Registrar profesor</span><br><span class="label tag error">Todos los campos son obligatorios</span></div>
		        <div class="modal-body">
			        <form class="form" id="personal-mod">
			        		<div class="row">
			        			<div class="col col-5">
								    <div class="form-item">
								        <label>RFC</label>
								        <?php
								        echo '<input value="'.$infoProf[0].'" data-tipso="El RFC tiene 13 caracteres."  type="text" id="rfc" name="rfc" class="width-100">';
								        ?>
								    </div>
								    
								    <div class="form-item">
								        <label>Nombre</label>
								        <?php
								        echo '<input value="'.$infoProf[1].'" type="text" id="nombre" name="nombre" class="width-100">';
								        ?>
								    </div>

								    <div class="form-item">
								        <label>Apellido paterno</label>
								        <?php 
								        echo '<input value="'.$infoProf[2].'" type="text" id="apep" name="apep" class="width-100">';
								        ?>
								    </div>
								    
								    <div class="form-item">
								        <label>Apellido materno</label>
								        <?php
								        echo '<input value="'.$infoProf[3].'" type="text" id="apem" name="apem" class="width-100">';
								        ?>
								    </div>
								    				    
			        			</div>
			        			
			        			<div class="col col-5 offset-2">
			        				<div class="form-item">
								    <label>Carrera del profesor</label>
								        <select class="select" id="carrera" name="carrera">
								            <option value="">-- Selecciona --</option>
								            <?php
													$combo = new GenerarCombos();
													$combo->generarComboCarrerasEdit($infoProf[4]);
												?>	
								        </select>
								    </div>
								    
								    <div class="form-item">
								        <label>Correo</label>
								        <?php 
								        echo '<input value="'.$infoProf[5].'" type="text" id="ema" name="ema" class="width-100">';
								        ?>
								    </div>
								    
								    <br>
								    <div class="form-item checkboxes-inline">
								    <?php 
								    	if(strcmp($infoProf[6],'S') === 0) {
								    		echo '<label><input type="radio" id="activo" name="activo" value="S" checked><span class="label  success"> Activo</span></label>
								        <label><input type="radio" id="activo" name="activo" value="N"><span class="label  error"> No Activo</span></label>';
								    		}
								    		else {
								    		echo '<label><input type="radio" id="activo" name="activo" value="S"><span class="label  success"> Activo</span></label>
								        <label><input type="radio" id="activo" name="activo" value="N" checked><span class="label  error"> No Activo</span></label>';
								    			}
								    ?>
								    </div>
								    <br>
								    
			        			</div>
						    </div>
						    <script type="text/javascript">
						    	$(document).ready(function () {
						    			$("input#rfc, input#pass").tipso({
											  showArrow: true,
											  position: "top",
											  background: "rgba(0, 0, 0, 0.5)",
											  color: "#eee",
											  useTitle: false,
											  animationIn: "bounceIn",
											  animationOut: "bounceOut",
											  size: "small"
										});
						    	});
						    </script>
						<hr>

			        		<div class="row">
			        			<div class="col col-5 ">
									<div class="form-item checkboxes">
								    <label><i class="fa fa-user fa-lg"></i> <b>Profesor de Carrera(s):</b></label>
								            <?php
													$combo->generarCheckBoxCarrerasTutCor("pro-car", $tuto);
												?>	
								    </div>
			        			</div>
			        			<div class="col col-5 offset-2">
									<div class="form-item checkboxes">
								    <label><i class="fa fa-graduation-cap fa-lg"></i> <b>Coordinador de Carrera(s):</b></label>
								            <?php
													$combo->generarCheckBoxCarrerasTutCor("cor-car", $coor);
												?>	
								    </div>
								    <hr>
			        			</div>
			        		</div>
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
		
