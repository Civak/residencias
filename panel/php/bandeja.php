<?php
session_start();
ob_start();

include('../../php/conexion.php');

class Mensajes{
	private $conn;
	  	   /// ----------- Guarda msj para grupo
    public function guardarMsjGrupo() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();  	 	
    		$sql = "CALL guardarMsjGrupo('".$_SESSION['profesor']."', ".$_POST['grupo'].",'".$_POST['msj']."');";
			if ($this->conn->query($sql) === TRUE) {
			    echo 'Mensaje enviado exitosamente...';
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
		
		  	   /// ----------- Guarda msj para alumno
    public function guardarMsjAlum() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();  	 	
    		$sql = "CALL guardarMsjAlum('".$_SESSION['profesor']."',".$_POST['alumno'].",'".$_POST['msj']."');";
			if ($this->conn->query($sql) === TRUE) {
			    echo 'Mensaje enviado exitosamente...';
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
			  	   /// ----------- Guarda msj para profesor
    public function guardarMsjProfe() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();  	 	
    		$sql = "CALL guardarMsjProfe(".$_SESSION['alumno'].",".$_POST['grupo'].",'".$_POST['msj']."');";
			if ($this->conn->query($sql) === TRUE) {
			    echo 'Mensaje enviado exitosamente...';
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
		
			  	   /// ----------- elimina msj de bandeja profe
    public function eliminarMsj() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();  
		$datos = explode('-', $_POST['dato1']);	
		 	
    		$sql = "DELETE FROM profe_msj WHERE profe_msj.idmsj = ".$datos[1].";";
			if ($this->conn->query($sql) === TRUE) {
			    echo 3;
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
					  	   /// ----------- elimina mensaje de bandeja alumno
    public function eliminarMsjProfe() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();  
		$datos = explode('-', $_POST['dato1']);	
		 	
    		$sql = "DELETE FROM alum_msj WHERE alum_msj.id = ".$datos[1].";";
			if ($this->conn->query($sql) === TRUE) {
			    echo 3;
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
    $datos = new Mensajes();
    $op = explode('$', $_COOKIE['opcion']);
    switch($op[1])
    {
    	  case 'msj-gru':
            $datos->guardarMsjGrupo();
        break;
		case 'msj-alu':
            $datos->guardarMsjAlum();
        break;
		case 'msj-elim':
            $datos->eliminarMsj();
        break;
		case 'msj-elim-profe':
            $datos->eliminarMsjProfe();
        break;
		case 'msj-pro':
            $datos->guardarMsjProfe();
        break;
    }
}
?>