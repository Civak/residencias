<?php
session_start();
ob_start();
include('../../../php/conexion.php');

class Alumnos{
	private $conn;
	
    	
    		   /// ----------- Obtiene los grupos del profesor panel izquierdo
    public function consultarAlumno() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
		$datos = explode('-', $_COOKIE['data']); 

 	   $cat = ''; 	
 	   $encontrado = false; 	
    		$sql = "SELECT alu.noc, alu.nombre, gru.activo FROM alumnos AS alu INNER JOIN gru_alum AS gru ON alu.noc = gru.noc WHERE alu.noc = ".$_COOKIE['noc']." AND gru.id_grup =".$datos[1];
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat = $row['noc'].','.$row['nombre'].','.$row['activo'].',';
			    }
			   $encontrado = true;
			} 
			
			if($encontrado) return $cat;
			else return -1;
    	$this->conn->close();
    	}
     		   /// ----------- Obtiene los grupos del profesor panel izquierdo
    public function consultarAlumnoEdit() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
		$datos = explode('-', $_COOKIE['data']); 

 	   $cat = ''; 		
    		$sql = "SELECT * FROM alumnos WHERE alumnos.noc = ".$_SESSION['alumno'];
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat = $row['nombre'].','.$row['foto'];
			    }
			} 
			
			return $cat;
    	$this->conn->close();
    	}
    	// ---------------------------------------------------
    	 public function consultarProfesor() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();

 	   $cat = ''; 		
    		$sql = "SELECT * FROM profesores WHERE profesores.rfc = '".$_SESSION['profesor']."'";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat = $row['foto'].'$'.$row['nombre'].'$'.$row['apepat'].'$'.$row['apemat'].'$'.$row['email'].'$'.
			        $row['telefono'].'$'.$row['cv'];
			    }
			   
			} 
			
			return $cat;

    	$this->conn->close();
    	}
    	// ---------------------------------------------------
    	 public function msjEnviados() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();

 	   $cat = ''; 		
    		$sql = "SELECT * FROM profe_msj WHERE profe_msj.rfc = '".$_SESSION['profesor']."' AND profe_msj.tipo = 'E' ORDER BY profe_msj.fecha DESC";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat .= "<div id='m-".$row['idmsj']."' class='msjEnv'>".$row['msj']."<hr><div id='msj-elim' class='desc'>Enviado: ".$row['fecha']."<i id='m-".$row['idmsj']."' style='float: right; cursor: pointer;' class='fa fa-close error'></i></div></div>";
			    }
			   
			} 
			
			echo $cat;

    	$this->conn->close();
    	}
		// ---------------------------------------------------
		    	 public function msjEnviadosProfe() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();

 	   $cat = ''; 		
    		$sql = "SELECT * FROM alum_msj WHERE alum_msj.noc = ".$_SESSION['alumno']." AND alum_msj.tipo = 'E' ORDER BY alum_msj.fecha DESC";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat .= "<div id='m-".$row['id']."' class='msjEnv'>".$row['msj']."<hr><div id='msj-elim' class='desc'>Enviado: ".$row['fecha']."<i id='m-".$row['id']."' style='float: right; cursor: pointer;' class='fa fa-close error'></i></div></div>";
			    }
			   
			} 
			
			echo $cat;

    	$this->conn->close();
    	}
		// ---------------------------------------------------
		    	 public function msjRecibidos() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();

 	   $cat = ''; 		
    		$sql = "CALL msjRecibidos('".$_SESSION['profesor']."');";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat .= "<div id='m-".$row['idmsj']."' class='msjEnv'>Enviado por: <b style='font-size: 12px; color: #1c86f2;'>".$row['nombre']." - ".$row['noc']."</b><br>".$row['msj']."<hr><div id='msj-elim' class='desc'>Recibido: ".$row['fecha']."<i id='m-".$row['idmsj']."' style='float: right; cursor: pointer;' class='fa fa-close error'></i></div></div>";
			    }
			   
			} 
			
			echo $cat;

    	$this->conn->close();
    	}
		// ---------------------------------------------------
		    	 public function msjRecibidosAlum() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();

 	   $cat = ''; 		
    		$sql = "CALL msjRecibidosAlum(".$_SESSION['alumno'].");";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat .= "<div id='m-".$row['id']."' class='msjEnv'>Enviado por: <b style='font-size: 12px; color: #1c86f2;'>".$row['nombre']."</b><br>".$row['msj']."<hr><div id='msj-elim' class='desc'>Recibido: ".$row['fecha']."<i id='m-".$row['id']."' style='float: right; cursor: pointer;' class='fa fa-close error'></i></div></div>";
			    }
			   
			} 
			
			echo $cat;

    	$this->conn->close();
    	}
		// ---------------------------------------------------
		    	 public function pizarra() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();

 	   $cat = ''; 		
    		$sql = "CALL pizarra('".$_SESSION['alumno']."');";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat .= "<div class='msjEnv'>Enviado al grupo: <b style='font-size: 12px; color: #1c86f2;'>".$row['grupo']."</b><br>".$row['msj']."<hr><div id='msj-elim' class='desc'>Recibido: ".$row['fecha']."</div></div>";
			    }
			   
			} 
			
			echo $cat;

    	$this->conn->close();
    	}
		// ---------------------------------------------------
		public function misGrupos() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();

 	   $cat = '<option value="">-- Selecciona --</option>'; 		
    		$sql = "SELECT * FROM grupos WHERE grupos.rfc = '".$_SESSION['profesor']."'";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat .= "<option value='".$row['id']."'>".$row['grupo']."</option>";
			    }
			   
			} 
			
			echo $cat;

    	$this->conn->close();
    	}
		// ---------------------------------------------------
		public function gruposAlumno() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();

 	   $cat = '<option value="">-- Selecciona --</option>'; 		
    		$sql = "SELECT * FROM gru_alum AS gru INNER JOIN grupos ON gru.id_grup = grupos.id WHERE gru.noc = ".$_SESSION['alumno']." AND gru.activo = 'S'";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat .= "<option value='".$row['id']."'>".$row['grupo']."</option>";
			    }
			   
			} 
			
			echo $cat;

    	$this->conn->close();
    	}
    	
    		
}


?>