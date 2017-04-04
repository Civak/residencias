<?php
include('../../php/conexion.php');

class Unidades{
	private $conn;
	
    	
    	    	/// ------------------------ Inserta unidades 
    	public function insertarUnidades() {
				$this->conn = new Conexion('../../php/datosServer.php');
		      $this->conn = $this->conn->conectar();
				$id = explode('-', $_COOKIE['data']);
				$sql = '';
    		for($i = 1; $i <= intval($_POST['dato1']); $i++) {
    			$sql .= "INSERT INTO unidades VALUES(".$id[1].", ".$i.", NULL, NULL);";
    		}
    		if ($this->conn->multi_query($sql) === TRUE) {
				    echo 'Unidades guardadas exitosamente...';
				}else echo -1;
				
				$this->conn->close();
    	}
    	
    	    	/// ------------------------ nueva unidades 
    	public function insertarUnidad() {
				$this->conn = new Conexion('../../php/datosServer.php');
		      $this->conn = $this->conn->conectar();
				$id = explode('-', $_COOKIE['data']);
				$sql = '';
    			$sql .= "INSERT INTO unidades VALUES(".$id[1].", ".$_POST['dato1'].", NULL, NULL);";

    		if ($this->conn->query($sql) === TRUE) {
				    echo 1;
				}else echo -2;
				
				$this->conn->close();
    	}
    	
    	    	/// ------------------------ nueva unidades 
    	public function eliminarUnidad() {
				$this->conn = new Conexion('../../php/datosServer.php');
		      $this->conn = $this->conn->conectar();
				$id = explode('-', $_COOKIE['data']);
				$sql = '';
    			$sql .= "DELETE FROM unidades WHERE unidades.id_grup = ".$id[1]." AND unidades.unidad = ".$_POST['dato1'];
    			$this->conn->query($sql);

    		if ($this->conn->affected_rows > 0) {
				    echo 2;
				}else echo -3;
				
				$this->conn->close();
    	}
    	
}
/// Se utiliza cookie para swicheo
 if(isset($_COOKIE["opcion"]))
{
	/// Se crea objeto de la clase 
    $datos = new Unidades();
    switch($_COOKIE["opcion"])
    {
        case 'add-topic':
            $datos->insertarUnidades();
        break;
        case 'add-uni':
            $datos->insertarUnidad();
        break;
        case 'elim-uni':
            $datos->eliminarUnidad();
        break;
    }
}

?>