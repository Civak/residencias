<?php
session_start();
ob_start();
include('../../../php/conexion.php');

class Alumnos{
	private $conn;
	
    	
    		   /// ----------- Obtiene los grupos del profesor panel izquierdo
    public function consultarAlumno() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
		$datos = explode('-', $_COOKIE['data']); 

 	   $cat = ''; 	
 	   $encontrado = false; 	
    		$sql = "SELECT alu.noc, alu.nombre, gru.activo FROM alumnos AS alu INNER JOIN gru_alum AS gru ON alu.noc = gru.noc WHERE alu.noc = ".$_COOKIE['noc']." AND gru.id_grup =".$datos[1];
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat = $row['noc'].','.$row['nombre'].','.$row['activo'].',';
			    }
			   $encontrado = true;
			} 
			
			if($encontrado) return $cat;
			else return -1;
    	$this->conn->close();
    	}
    	
    	 public function consultarProfesor() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();

 	   $cat = ''; 		
    		$sql = "SELECT * FROM profesores WHERE profesores.rfc = '".$_SESSION['profesor']."'";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat = $row['foto'].'$'.$row['nombre'].'$'.$row['apepat'].'$'.$row['apemat'].'$'.$row['email'].'$'.
			        $row['telefono'].'$'.$row['cv'];
			    }
			   
			} 
			
			return $cat;

    	$this->conn->close();
    	}
    	
    	 public function misGrupos() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();

 	   $cat = '<option value="">-- Selecciona --</option>'; 		
    		$sql = "SELECT * FROM grupos WHERE grupos.rfc = '".$_SESSION['profesor']."'";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat .= "<option value='".$row['id']."'>".$row['grupo']."</option>";
			    }
			   
			} 
			
			echo $cat;

    	$this->conn->close();
    	}
    	
    		
}


?>