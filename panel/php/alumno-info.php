<?php
include('../../php/conexion.php');

class Alumno{
	private $conn;
	
    	
    		   /// ----------- Obtiene los grupos del profesor panel izquierdo
    public function misGrupos() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $cat = ''; 	
 	   $encontrado = false; 	
    		$sql = "SELECT *, DATE_FORMAT(grupos.fecha, 'Registrado: %e %b %Y') as fec FROM grupos WHERE grupos.rfc = '".$_SESSION['profesor']."'";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat .= '<div title="'.$row['fec'].'"><ul>
								    <li data-component="collapse">
								        <a href="#groups-'.$row['id'].'" style="font-size: 14px;" class="collapse-toggle">
								           '.$row['grupo'].'
								            <span class="caret down"></span>
								        </a>    </li>
								   
								        <ul id="groups-'.$row['id'].'" class="hide groups">
											<li id="" data-component="dropdown" data-target="#co-'.$row['id'].'">
											<i class="fa fa-briefcase"></i> Crear Contenido</li>
											<li data-component="dropdown" data-target="#re-'.$row['id'].'">
											<i class="fa fa-check-square"></i> Revisar Curso</li>
											<li data-component="dropdown" data-target="#ed-'.$row['id'].'">
											<i class="fa fa-edit"></i> Editar Contenido</li>
											<li id="fo"><i class="fa fa-comments-o"></i> Foro</li>
								        </ul>
								        </ul>
								        <div id="acciones">
								        <span id="'.$row['grupo'].'-'.$row['id'].'">
											<div class="dropdown hide" id="co-'.$row['id'].'">
											    <a href="" class="close show-sm"></a>
											    <ul id="crear-contenido">
											        <li id="cr-te"><a href=""><i class="fa fa-file-text-o"></i> Crear Temario</a></li>
											        <li id="cr-ta"><a href=""><i class="fa fa-list-alt"></i> Crear Tarea</a></li>
													  <li id="cr-ex"><a href=""><i class="fa fa-calendar"></i> Programar Examen</a></li>
													  <li id="cr-do"><a href=""><i class="fa fa-cloud-upload"></i> Subir Documentos</a></li>
													  <li id="cr-al"><a href=""><i class="fa fa-users"></i> Cargar Alumnos</a></li>
											    </ul>
											</div>
											<div class="dropdown hide" id="re-'.$row['id'].'">
											    <a href="" class="close show-sm"></a>
											    <ul>
											        <li id="re-ex"><a href=""><i class="fa fa-check"></i> Exámenes</a></li>
											        <li id="re-cal"><a href=""><i class="fa fa-bar-chart"></i> Calificaciones</a></li>
													  <li id="re-ta"><a href=""><i class="fa fa-archive"></i> Tareas</a></li>
													  <li id="re-te"><a href=""><i class="fa fa-file-text-o"></i> Temario</a></li>
											    </ul>
											</div>
											<div class="dropdown hide" id="ed-'.$row['id'].'">
											    <a href="" class="close show-sm"></a>
											    <ul>
											        <li id="ed-te"><a href=""><i class="fa fa-file-text-o"></i> Editar Temario</a></li>
											        <li id="ed-ta"><a href=""><i class="fa fa-list-alt"></i> Editar Tarea</a></li>
													  <li id="ed-ex"><a href=""><i class="fa fa-pencil"></i> Editar Examen</a></li>
													  <li id="ed-do"><a href=""><i class="fa fa-reply"></i> Editar Documentos</a></li>
													  <li id="ed-al"><a href=""><i class="fa fa-user-times"></i> Editar Alumnos</a></li>
													  <li id="ed-gr"><a href=""><i class="fa fa-warning"></i> Dejar Grupo</a></li>
											    </ul>
											</div>
											</span></div></div>';
			    }
			   $encontrado = true;
			} 
			
			if($encontrado) echo $cat;
			else echo '<div class="message error animated fadeIn" data-component="message">No tienes grupos asignados.</div>';
    	$this->conn->close();
    	}
    	
    	public function fotoPerfil() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $cat = ''; 	
 	   $encontrado = false; 	
    		$sql = "SELECT alumnos.nombre, alumnos.foto FROM alumnos WHERE alumnos.noc = ".$_SESSION['alumno']."";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $cat = "<img src='img/".$row['foto']."' alt='Foto de ".$row['nombre']."'><span title='".$row['nombre']."'>".substr($row['nombre'], 0, 16)."...</span>";
			    }
			   $encontrado = true;
			} 
			
			if($encontrado) echo $cat;
    	$this->conn->close();
    	}
    	
    	public function tareasPendientes(){
			$this->conn = new Conexion('../../php/datosServer.php');
			$this->conn = $this->conn->conectar();
	 	   $cat = ''; 
	 	   $encontrado = false; 	
    		$sql = "CALL tareasPendientes('".$_SESSION['profesor']."')";
			$result = $this->conn->query($sql);
			if ($result->num_rows > 0) {
			   while($row = $result->fetch_assoc()) {
			        $cat .= "<div id='act-".$row['id']."' class='tareas box-tareas' title='Unidad: ".$row['unidad']."'><i class='fa fa-clipboard'></i> ".substr($row['grupo'], 0, 20)."...<br>";
			        $cat .= "<span class='desc'>Fec. Ini: ".$row['fec_ini']."<br> Fec. Lim: ".$row['fec_lim']."</span>";
			        $cat .= "</div>";
			    }
			   $encontrado = true;
			}
	 	   if($encontrado) echo $cat;
	 	   else echo "No hay tareas pendientes.";
	    	$this->conn->close();   	
    	}
		
		 public function misMsj() {
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
    	
}

?>