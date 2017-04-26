<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
ob_start();
include('../../php/conexion.php');
include ('generarCombos.php');

class Personal{
	private $conn;
	
	   	/// ------ Altas profesor
		public function altasProfesor() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
		
    	$rfc = strtoupper($_POST['rfc']);
    	if($this->verificarProfe($rfc)) {
    		echo -2;
    	}
    	else{
			$this->conn->next_result();
    		$carre = array();
 	   	$carreras = new GenerarCombos('../../php/datosServer.php');
 	   	$carre = $carreras->obtenerCarreras($this->conn);
 	   	
    	/// Esta linea oculta el warning de cifrado, no es relevante.
    	error_reporting(E_ERROR | E_WARNING | E_PARSE);
 	   $pass = crypt($_POST['pass']);
	   
			$this->conn->next_result();
    		$sql = "CALL guardarNvoProfe('".$rfc."', '".strtoupper($_POST['nombre'])."', '".strtoupper($_POST['apep'])."', '".strtoupper($_POST['apem'])."',
    		'".$_POST['carrera']."', '".$_POST['ema']."','".$pass."');";
			if ($this->conn->query($sql) === TRUE) {
			    $this->altasProCor($carre, $rfc, 'P','-pro-car');
			    $this->altasProCor($carre, $rfc, 'C','-cor-car');
			    		echo 'Registro guardado exitosamente...';
			} else {
			    echo -1;
			}
		}
    	$this->conn->close();
    	}
    	/// Verifica si existe el profe antes de registrarlo
    	public function verificarProfe($rfc) {
					$result = $this->conn->query("SELECT * FROM profesores WHERE profesores.rfc = '".$rfc."';");
            	$result->num_rows > 0 ? true : false;
				}
	  /// Ingresa roles 
	  public function altasProCor($carre, $rfc, $asig, $tipo){
    			$this->conn->next_result();
    			$sql = "";
    			foreach($carre as $c) {
    				if(isset($_POST[$c.$tipo])) {
         		$sql .= "INSERT INTO roles VALUES('".$rfc."','".$c."','".$asig."');";
         		} 
         	}
         	
			   if ($this->conn->multi_query($sql) === TRUE) {
				    return true;
				}else {
					return false; 
					}
			}
			    		   /// ----------- Consultar materia
    public function consultarMateria() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $option = '<option value="">-- Selecciona --</option>'; 
 	   $encontrado = false;
 	   	 	
    		$sql = "SELECT * FROM materias WHERE materias.carrera = '".$_POST['dato1']."'";
    		$result = $this->conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $option .= "<option value='" . $row["id"]. "'>" . $row["materia"]. "</option>";
			    }
			    $encontrado = true;
			}
			
			if($encontrado) echo $option;
			else echo 0;
			
    	$this->conn->close();
    	}
    	
    	    	   	    			   /// ----------- catalogo personal
    public function catalogoPersonal() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $cat = ''; 	
 	   $encontrado = false; 	
    		$sql = "CALL catalogoPersonal('".$_POST['dato1']."');";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			    		$tipo = '';
			    		$activo = '';
			    		switch($row['rol']) {
			    			case "A":
			    			$tipo = 'Administrador';
			    			break;
			    			case "C":
			    			$tipo = 'Coordinador';
			    			break;
			    			case "P":
			    			$tipo = 'Profesor';
			    			break;
			    		}
			    		
			    		if(strcmp($row["activo"], 'S') == 0) $activo = '<span class="label  success">Activo</span>';
			    		else $activo = '<span class="label error">No Activo</span>';
			    		
			    	 $cat .= "<div id='".$row['rfc']."'><br><hr><span class='label focus'>RFC: ".$row['rfc']."</span><br>";
			        $cat .= "<div class='row'>";
			        $cat .= "<div class='col-9'><div class=form-item'><b>Nombre:</b> ".$row['nombre']." ".$row['apepat']." ".$row['apemat']."<br>&middot; ".$tipo."<br>".$activo."</div></div>";
			        $cat .= "<div class='col-1 offset-1' id='".$row['rfc']."'><i style='cursor: pointer;' class='fa fa-edit label badge focus outline' id='editar-per'></i> <i style='cursor: pointer;' id='eliminar-per' class='fa fa-remove label badge error outline'></i></div>";
			        $cat .= "</div></div>";
			    }
			   $encontrado = true;
			} 
			
			if($encontrado) echo $cat;
			else '<div class="message error animated fadeIn" data-component="message">No hay Personal registrado...</div>';
    	$this->conn->close();
    	}
    
    /// ---------------- Elimina profesor o personal
    public function eliminarPersonal() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	 	
    		$sql = "DELETE FROM profesores WHERE profesores.rfc = '".$_POST['dato1']."';";
			if ($this->conn->query($sql) === TRUE) {
			    echo 1;
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
}

/// Se utiliza cookie para swicheo
 if(isset($_COOKIE["opcion"]))
{
	/// Se crea objeto de la clase 
    $datos = new Personal();
    switch($_COOKIE["opcion"])
    {
    	  case 'personal-agregar':
            $datos->altasProfesor();
        break;
        case 'personal-editar':
            $datos->catalogoPersonal();
        break;
         case 'personal-eliminar':
            $datos->eliminarPersonal();
        break;
    }
}
?>