<?php
include('../../../php/conexion.php');

class Unidades{
	private $conn;
	
    	
    		   /// ----------- Obtiene los grupos del profesor panel izquierdo
    public function consultarUnidades() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
		$datos = explode('-', $_COOKIE['data']); 

 	   $cat = '<label>Unidades</label>
								<select id="unidades" name="unidades"><option value="">-- Selecciona --</option>'; 	
 	   $encontrado = false; 	
    		$sql = "SELECT * FROM unidades WHERE unidades.id_grup = ".$datos[1]."";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat .= '<option value="'.$row['unidad'].'">Unidad '.$row['unidad'].'</opcion>';
			    }
			   $encontrado = true;
			} 
			
			if($encontrado) echo $cat.'</select><br>';
			else echo '<div class="message error" data-component="message">La matería aún no tiene unidades, añade unidades...<span class="close small"></span></div>
			<button class="button w100" id="add-topic">Añadir Unidades</button>';
    	$this->conn->close();
    	}
    	
    	public function consultarUnidadesEdit() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
		$datos = explode('-', $_COOKIE['data']); 

 	   $cat = '<label>Unidades</label>
								<select id="unidades-edit" name="unidades-edit"><option value="">-- Selecciona --</option>'; 	
 	   $encontrado = false; 	
    		$sql = "SELECT * FROM unidades WHERE unidades.id_grup = ".$datos[1]."";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat .= '<option value="'.$row['unidad'].'">Unidad '.$row['unidad'].'</opcion>';
			    }
			   $encontrado = true;
			} 
			
			if($encontrado) echo $cat.'</select><br>';
			else echo '<div class="message error" data-component="message">La matería aún no tiene unidades, añade unidades...<span class="close small"></span></div>
			<button class="button w100" id="add-topic">Añadir Unidades</button>';
    	$this->conn->close();
    	}
    	
    	public function consultarUnidadesTareas() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
		$datos = explode('-', $_COOKIE['data']); 

 	   $cat = '<label>Unidad</label>
								<select id="unidades-tareas" name="unidades-tareas"><option value="">-- Selecciona --</option>'; 	
 	   $encontrado = false; 	
    		$sql = "SELECT * FROM unidades WHERE unidades.id_grup = ".$datos[1]."";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat .= '<option value="'.$row['unidad'].'">Unidad '.$row['unidad'].'</opcion>';
			    }
			   $encontrado = true;
			} 
			
			if($encontrado) echo $cat.'</select><br>';
			else echo '<div class="message error" data-component="message">La matería aún no tiene unidades, añade unidades...<span class="close small"></span></div>';
    	$this->conn->close();
    	}
    	
    	public function consultarUnidadesDocs() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
		$datos = explode('-', $_COOKIE['data']); 

 	   $cat = '<label>Selecciona Unidad</label>
								<select id="unidades-docs" name="unidades-docs">'; 	
 	   $encontrado = false; 	
    		$sql = "SELECT * FROM unidades WHERE unidades.id_grup = ".$datos[1]."";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat .= '<option value="'.$row['unidad'].'">Unidad '.$row['unidad'].'</opcion>';
			    }
			   $encontrado = true;
			} 
			
			if($encontrado) echo $cat.'</select><br>';
			else echo '<div class="message error" data-component="message">La matería aún no tiene unidades, añade unidades...<span class="close small"></span></div>';
    	$this->conn->close();
    	}
    		
}


?>