<?php
include('../../php/conexion.php');

class Mensajes{
	private $conn;

    	
    	    	/// ------------------------ nueva unidades 
    	public function misAlumnos() {
				$this->conn = new Conexion('../../php/datosServer.php');
		      $this->conn = $this->conn->conectar();
		      $encontrado = false;
				$cat = '';
    			$sql = "SELECT gra.noc, alu.nombre FROM gru_alum AS gra INNER JOIN alumnos as alu ON gra.noc = alu.noc WHERE gra.id_grup = ".$_POST['dato1'];

				$result = $this->conn->query($sql);
				
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
				        $cat .= "<option value='".$row['noc']."'>" . $row["noc"]. " - " . $row["nombre"]. "</option>";
				    }
				    $encontrado = true;
				}
				
				if($encontrado) echo $cat;
				else echo -1;				
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
        case 'msj-alu':
            $datos->misAlumnos();
        break;
    }
}

?>