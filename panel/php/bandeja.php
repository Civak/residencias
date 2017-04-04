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
    }
}
?>