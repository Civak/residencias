<?php
session_start();
ob_start();
include('../../php/conexion.php');

class Consultas{
	private $conn;
	
    	
    	    	/// ------------------------ Inserta unidades 
     public function misMsj() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
	
    		$sql = "SELECT * FROM profe_msj WHERE profe_msj.rfc = '".$_SESSION['profesor']."' AND profe_msj.leido = 0";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
				echo $result->num_rows;
			} else{
				echo 0;	
			}
			
    		$this->conn->close();
    	}
    
     public function misMsjAlu() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
	
    		$sql = "SELECT * FROM alum_msj WHERE alum_msj.noc = ".$_SESSION['alumno']." AND alum_msj.leido = 0";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
				echo $result->num_rows;
			} else{
				echo 0;	
			}
			
    		$this->conn->close();
    	}
    
    public function verificarTarea() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
	    $tarea = explode('-',$_POST['dato1']);
    		$sql = "SELECT * FROM tareas WHERE tareas.noc = ".$_SESSION['alumno']." AND tareas.id_act = ".$tarea[1];
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
				echo 1;
			} else{
				echo 0;	
			}
			
    		$this->conn->close();
    	}

}
/// Se utiliza cookie para swicheo
 if(isset($_COOKIE["act"]))
{
	/// Se crea objeto de la clase 
    $datos = new Consultas();
    switch($_COOKIE["act"])
    {
        case 'mis-msj':
            $datos->misMsj();
        break;
        case 'mis-msj-alu':
            $datos->misMsjAlu();
        break;
        case 'env-tar':
            $datos->verificarTarea();
        break;
    }
    setcookie('act', null, -1, '/');
}

?>