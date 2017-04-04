<?php
session_start();
ob_start();

include('../../php/conexion.php');

class Carreras{
	private $conn;
	
   	   /// ----------- Altas carrera
    public function altasCarrera() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	    	 	
    		$sql = "CALL guardarNvaCarrera('".strtoupper(trim($_POST['idCarrera']))."', '".$_POST['carrera']."');";
			if ($this->conn->query($sql) === TRUE) {
			    echo 'Carrera agregada exitosamente...';
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
    	
   /// ----------- Editar carrera
   public function editarCarrera() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	    	 	
    		$sql = "UPDATE carreras SET carreras.carrera = '".$_POST['dato2']."' WHERE carreras.id = '".$_POST['dato1']."';";
			if ($this->conn->query($sql) === TRUE) {
			    echo 'Carrera editada exitosamente...';
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
    	
    /// ----------- eliminar carrera
    public function eliminarCarrera() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	    	 	
    		$sql = "DELETE FROM carreras WHERE carreras.id = '".$_POST['dato1']."'";
			if ($this->conn->query($sql) === TRUE) {
			    echo 'Carrera eliminada exitosamente...';
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
    $datos = new Carreras();
    switch($_COOKIE["opcion"])
    {
    	  case 'carreras-agregar':
            $datos->altasCarrera();
        break;
        case 'carreras-editar':
            $datos->editarCarrera();
        break;
        case 'carreras-eliminar':
            $datos->eliminarCarrera();
        break;
    }
}
?>