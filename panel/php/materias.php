<?php
session_start();
ob_start();

include('../../php/conexion.php');

class Materias{
	private $conn;
	
   	   /// ----------- Altas materia
    public function altasMateria() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	    	 	
    		$sql = "CALL guardarNvaMateria('".$_POST['carrera']."', '".trim($_POST['materia'])."');";
			if ($this->conn->query($sql) === TRUE) {
			    echo 'Materia agregada exitosamente...';
			} else {
			    echo -1;
			}
    	$this->conn->close();
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
  
    	   /// ----------- Actualizar materia
   public function actualizarMateria() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	    	 	
    		$sql = "UPDATE materias SET materias.materia = '".$_POST['dato2']."' WHERE materias.id = '".$_POST['dato1']."';";
			if ($this->conn->query($sql) === TRUE) {
			    echo 'Materia editada exitosamente...';
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
    	
    	/// ----------- eliminar materia
    public function eliminarMateria() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	    	 	
    		$sql = "DELETE FROM materias WHERE materias.id = '".$_POST['dato1']."'";
			if ($this->conn->query($sql) === TRUE) {
			    echo 'Materia eliminada exitosamente...';
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
    	
    	    		   /// ----------- Catalogo materias
    public function catalogoMateria() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $option = '<hr>'; 
 	   $encontrado = false;
 	   	 	
    		$sql = "SELECT * FROM materias WHERE materias.carrera = '".$_POST['dato1']."'";
    		$result = $this->conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $option .= "<i class='fa fa-tag label badge focus'></i> ".$row["materia"]. "<br>";
			    }
			    $encontrado = true;
			}
			
			if($encontrado) echo $option;
			else echo 0;
			
    	$this->conn->close();
    	}
}

/// Se utiliza cookie para swicheo
 if(isset($_COOKIE["opcion"]))
{
	/// Se crea objeto de la clase 
    $datos = new Materias();
    switch($_COOKIE["opcion"])
    {
    	  case 'materias-agregar':
            $datos->altasMateria();
        break;
        case 'materias-editar':
		  case 'personal-editar':
            $datos->consultarMateria();
        break;
        case 'materias-actualizar':
            $datos->actualizarMateria();
        break;
        case 'materias-eliminar':
            $datos->eliminarMateria();
        break;
        case 'materias-catalogo':
            $datos->catalogoMateria();
        break;
    }
}
?>