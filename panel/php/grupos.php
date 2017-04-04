<?php
include('../../php/conexion.php');

class Grupos{
	private $conn;
	
	  	   		   /// ----------- Consultar profesores de materias y materias en gral.
    public function asignarGrupo() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $option = '<option value="">-- Selecciona --</option>'; 
 	   $encontrado = false;
 	   $sql = '';
 	   if(strcmp('profe', $_COOKIE['tipo']) == 0){
 	   	$carrera = explode('-', $_POST['dato1']);
 	   	 $sql = "CALL consultarProfes('".$carrera[0]."')";
 	   	 }
 	   else	{ $sql = "SELECT * FROM materias WHERE materias.carrera = '".$_POST['dato1']."'"; }
 	   
    		$result = $this->conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        if(strcmp('profe', $_COOKIE['tipo']) == 0) $option .= "<option value='" . $row["rfc"]. "'>" . $row["nom"]. "</option>";
			        else $option .= "<option value='".$_POST['dato1']."-" . $row["id"]. "'>" . $row["materia"]. "</option>";
			    }
			    $encontrado = true;
			}
			
			if($encontrado) echo $option;
			else echo 1;
		setcookie('tipo', null, -1, '/');	
    	$this->conn->close();
    	}
    	
    		   /// ----------- guardar Grupo
    public function guardarGrupo() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $materia = explode('-', $_POST['materia-grup']);
 	   	 	
    		//$sql = "CALL guardarNvoGrupo(".$materia[1].", '".trim($_POST['grupo'])."','".$_POST['profesor-grup']."');";
    		$sql = "INSERT INTO grupos (grupos.materia, grupos.grupo, grupos.fecha, grupos.rfc, grupos.activo) 
    		VALUES(".$materia[1].", '".trim($_POST['grupo'])."', CURRENT_TIMESTAMP, '".$_POST['profesor-grup']."', 'S')";
			if ($this->conn->query($sql) === TRUE) {
			    echo 'Grupo guardado y asignado exitosamente...';
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
    	
    	/// ------------------------ Inserta unidades 
    	public function insertarUnidades($id) {
				$this->conn->next_result();
				$sql = '';
    		for($i = 1; $i <= intval($_POST['unidad-grup']); $i++) {
    			$sql .= "INSERT INTO unidades VALUES(".$id.", ".$i.", NULL);";
    		}
    		if ($this->conn->multi_query($sql) === TRUE) {
				    echo 'Grupo guardado y asignado exitosamente...';
				}
    	}
    	 	   		   /// ----------- Consultar catalogo de materias
    public function catalogoMaterias() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $option = '<option value="">-- Selecciona --</option>'; 
 	   $encontrado = false;
 		$sql = "SELECT * FROM materias WHERE materias.carrera = '".$_POST['dato1']."'"; 
 	   
    		$result = $this->conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					$option .= "<option value='". $row["id"]. "'>" . $row["materia"]. "</option>";
			    }
			    $encontrado = true;
			}
			
			if($encontrado) echo $option;
			else echo 1;
    	$this->conn->close();
    	}
    	
    		    	   	    			   /// ----------- catalogo personal
    public function catalogoGrupos() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $cat = ''; 	
 	   $encontrado = false; 	
    		$sql = "CALL catalogoGrupos(".$_POST['dato1'].");";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			    		$activo = '';
			    		
			    		if(strcmp($row["activo"], 'S') == 0) $activo = '<span class="label  success">Activo</span>';
			    		else $activo = '<span class="label error">No Activo</span>';
			    		
			    	  $cat .= "<hr><span class='label focus'>Id Grupo: ".$row['id']."</span><br>";
			        $cat .= "<div class='row'>";
			        $cat .= "<div class='col-9'><div class=form-item'><b>Nombre de Ref:</b> ".$row['grupo']."<br>&middot; Profesor: ".$row['nom']."<br>".$activo." <span class='desc'> ".$row['fecha']."</span></div></div>";
			        $cat .= "<div class='col-1 offset-1' id='".$row['id']."'><i style='cursor: pointer;' class='fa fa-edit fa-lg edit' id='editar-gru'></i> <i style='cursor: pointer;' id='eliminar-gru' class='fa fa-remove fa-lg error'></i></div>";
			        $cat .= "</div>";
			    }
			   $encontrado = true;
			} 
			
			if($encontrado) echo $cat;
			else '<div class="message error animated fadeIn" data-component="message">No hay Personal registrado...</div>';
			setcookie('tipo', null, -1, '/');
    	$this->conn->close();
    	}
}

/// Se utiliza cookie para swicheo
 if(isset($_COOKIE["opcion"]))
{
	/// Se crea objeto de la clase 
    $datos = new Grupos();
    switch($_COOKIE["opcion"])
    {
        case 'grupos-agregar':
            $datos->asignarGrupo();
        break;
        case 'grupos-guardar':
            $datos->guardarGrupo();
        break;
        case 'grupos-catalogo':
        		if(isset($_COOKIE["tipo"]) && strcmp($_COOKIE["tipo"], 'catalogo') == 0) $datos->catalogoGrupos();
            else $datos->catalogoMaterias();
        break;
    }
}
?>