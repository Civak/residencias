<?php
include('../../../php/conexion.php');

class Catalogos{
	private $conn;
	
    	
    		   /// ----------- catalogo carrera
    public function catalogoCarrera() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $cat = ''; 	
 	   $encontrado = false; 	
    		$sql = "SELECT * FROM carreras";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat .= "<div class='row'>";
			        $cat .= "<div class='col-1'><div class=form-item'><input type='text' disabled value='".$row['id']."'></div></div>";
			        $cat .= "<div class='col-9'><div class=form-item'><input type='text' name='carrera' id='car-".$row['id']."' disabled value='".$row['carrera']."'></div></div>";
			        $cat .= "<div class='col-1 offset-1' id='".$row['id']."'><i title='Editar carrera' style='cursor: pointer;' class='fa fa-edit label badge focus outline' id='editar'></i> <i title='Eliminar carrera' style='cursor: pointer;' id='eliminar' class='fa fa-remove label badge error outline'></i></div>";
			        $cat .= "</div>";
			    }
			   $encontrado = true;
			} 
			
			if($encontrado) echo $cat;
			else '<div class="message error animated fadeIn" data-component="message">No hay carreras registradas...</div>';
    	$this->conn->close();
    	}
    	
}

?>