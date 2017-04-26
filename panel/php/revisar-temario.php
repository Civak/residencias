<?php
session_start();
ob_start();

include('../../../php/conexion.php');

class Temario{
	private $conn;
	
   	   /// ----------- Consulta termario del grupo o materia
    public function consultarTemario() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $grupo = explode('-', $_COOKIE['data']);
 	   $unidades = '<div class="temario"><div id="my-collapse" data-component="collapse">';
 	   $unidad = 1;
 	   $enco = false;
 	     	 	
    		$sql = "SELECT * FROM unidades WHERE unidades.id_grup = ".$grupo[1];
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			    	$unidades .= '<div class="header-topic"><a id=u-"'.$row['unidad'].'" href="#box-'.$unidad.'" class="collapse-toggle">Unidad: '.$unidad.'</a></div>';
			    	if(!empty($row["contenido"])) {
			    	$unidades .= '<div class="collapse-box hide" id="box-'.$unidad.'">'.$row['contenido'];
			    	$unidades .= $this->obtenerArchivos($row['docs']).'<br></div>';
			    	}else{
			    	$unidades .= '<div class="collapse-box hide" id="box-'.$unidad.'"><br><div class="message error" data-component="message">La unidad aún no tiene temario, añade contenido.<span class="close small"></span></div></div>';
			    	}
			    	
			    	$unidad++;
			    }
			    $enco = true;
			 }
			 
		if($enco) echo $unidades.'</div></div>';
			else echo '<div class="message error" data-component="message">La matería aún no tiene unidades, añade unidades...<span class="close small"></span></div>';	
    	
    	$this->conn->close();
    	}
    
public function ConsultarUnidades(){
		$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $grupo = explode('-', $_COOKIE['data']);
 	   $sql = "SELECT * FROM unidades WHERE unidades.id_grup = ".$grupo[1];
 	   $result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
				echo $this->panelTareas($result->num_rows, $grupo[1]);
				}else echo '<div class="message error" data-component="message">La matería aún no tiene unidades, añade unidades...<span class="close small"></span></div>';	
 	   $this->conn->close();
		}
		
			   /// ----------- Consulta termario con sus tareas correspondientes
    public function panelTareas($lim, $grupo) {
 	   $unidades = '<div class="temario"><div id="my-collapse" data-component="collapse">';
 	   
 	   for($unidad = 1; $unidad <= intval($lim);$unidad++) {
 	   	$this->conn->next_result();  	 	
    		$sql = "SELECT * FROM actividades WHERE actividades.id_grup = ".$grupo." AND actividades.unidad = ".$unidad.";";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
				$unidades .= '<div class="header-topic"><a id=u-"'.$unidad.'" href="#box-'.$unidad.'" class="collapse-toggle">Unidad: '.$unidad.'</a></div>';
			   $unidades .= '<div class="collapse-box hide" id="box-'.$unidad.'">'; 
			    while($row = $result->fetch_assoc()) {
			    	$unidades .= '<div class="row edit-tareas" id="t-'.$row['id'].'"><hr><div class="col col-9"><i class="fa fa-clipboard"></i> <a id="t-'.$row['id'].'" data-component="modal" data-target="#tareas-info">'.$row['titulo'].'</a><br>';
			    	$unidades .= '<span class="label tag success">Fecha Asignada: '.$row['fec_ini'].'</span>&nbsp;&nbsp;&nbsp;<span class="label tag error"> Fecha Límite: '.$row['fec_lim'].'</span></div>';
			    	$unidades .= '<div class="col col-2 offset-1"><i title="Editar" id="edit-'.$row['id'].'" class="fa fa-pencil success"></i> <i title="Eliminar" id="elim-'.$row['id'].'" class="fa fa-close error"></i></div></div>';
			    	
			    }
			   $unidades .= '</div>';  
			 }else{
			 		$unidades .= '<div class="header-topic"><a id=u-"'.$row['unidad'].'" href="#box-'.$unidad.'" class="collapse-toggle">Unidad: '.$unidad.'</a></div>';
			    	$unidades .= '<div class="collapse-box hide" id="box-'.$unidad.'"><br><div class="message error" data-component="message">La unidad aún no tiene tareas.<span class="close small"></span></div></div>';
			 }
		}
			 
		return $unidades.'</div>';
    	}
    
    	
    	public function obtenerArchivos($str) {
    		$docs = '<div class="docs"><b><i class="fa fa-file-archive-o fa-lg"></i> Documentos:</b><hr>';
    		$files = explode(';', $str);
    		for($i = 0; $i < count($files) - 1;$i++) {
    			$docs .= '<a href="http://proyecto.myftp.org/proyecto/residencias/panel/profesor/docs/'.$files[$i].'" download>'.$files[$i].'</a><br>';
    		}
    		
    		return $docs.'</div>';
    	}
    
    public function ConsultarTareas(){
		$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $grupo = explode('-', $_COOKIE['data']);
 	   $sql = "SELECT * FROM unidades WHERE unidades.id_grup = ".$grupo[1];
 	   $result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
				echo $this->Tareas($result->num_rows, $grupo[1]);
				}else echo '<div class="message error" data-component="message">La matería aún no tiene unidades, añade unidades...<span class="close small"></span></div>';	
 	   $this->conn->close();
		}
    
     public function ConsultarExamenes(){
		$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $grupo = explode('-', $_COOKIE['data']);
 	   $sql = "SELECT * FROM unidades WHERE unidades.id_grup = ".$grupo[1];
 	   $result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
				echo $this->Examenes($result->num_rows, $grupo[1]);
				}else echo '<div class="message error" data-component="message">La matería aún no tiene examenes para realizar<span class="close small"></span></div>';	
 	   $this->conn->close();
		}
    
    			   /// ----------- Consulta termario con sus tareas correspondientes
    public function Examenes($lim, $grupo) {
 	   $unidades = '<div class="temario"><div id="my-collapse" data-component="collapse">';
 	   
 	   for($unidad = 1; $unidad <= intval($lim);$unidad++) {
 	   	$this->conn->next_result();  	 	
    		$sql = "SELECT * FROM examenes WHERE examenes.id_mat = ".$grupo." AND examenes.unidad = ".$unidad." GROUP BY examenes.id;";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
				$unidades .= '<div class="header-topic"><a id=u-"'.$unidad.'" href="#box-'.$unidad.'" class="collapse-toggle">Unidad: '.$unidad.'</a></div>';
			   $unidades .= '<div class="collapse-box hide" id="box-'.$unidad.'"><span class="desc">Total de Tareas: '.$result->num_rows.'</span><hr>'; 
                
			    while($row = $result->fetch_assoc()) {
			    	$unidades .= '<div class="row edit-tareas" id="t-'.$row['id'].'"><hr><div class="col col-9"><i class="fa fa-clipboard"></i> <a id="t-'.$row['id'].'" data-component="modal" data-target="#tareas-info">Examen</a><br>';
			    	$unidades .= '<span class="label tag success">Fecha Inicio: '.$row['fec_ini'].'</span>&nbsp;&nbsp;&nbsp;<span class="label tag error"> Fecha Límite: '.$row['fec_lim'].'</span></div>';
                    
                    
                    if(strtotime($row['fec_ini']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($row['fec_lim']) >= strtotime(date('Y-m-d H:i:s'))){
			    	$unidades .= '<div class="col col-2 offset-1"><button id="env-'.$row['id'].'" class="button small">Comenzar</button></div></div><hr>';
                    }else{
                    $unidades .= '<div class="col col-2 offset-1"><button class="button disabled small">Comenzar</button></div></div><hr>';   
                    }
                    
			    	
			    }
			   $unidades .= '</div>';  
			 }else{
			 		$unidades .= '<div class="header-topic"><a id=u-"'.$row['unidad'].'" href="#box-'.$unidad.'" class="collapse-toggle">Unidad: '.$unidad.'</a></div>';
			    	$unidades .= '<div class="collapse-box hide" id="box-'.$unidad.'"><br><div class="message error" data-component="message">La unidad aún no tiene exámenes pendientes.<span class="close small"></span></div></div>';
			 }
		}
			 
		return $unidades.'</div>';
    	}
		
			   /// ----------- Consulta termario con sus tareas correspondientes
    public function Tareas($lim, $grupo) {
 	   $unidades = '<div class="temario"><div id="my-collapse" data-component="collapse">';
 	   
 	   for($unidad = 1; $unidad <= intval($lim);$unidad++) {
 	   	$this->conn->next_result();  	 	
    		$sql = "SELECT * FROM actividades WHERE actividades.id_grup = ".$grupo." AND actividades.unidad = ".$unidad.";";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
				$unidades .= '<div class="header-topic"><a id=u-"'.$unidad.'" href="#box-'.$unidad.'" class="collapse-toggle">Unidad: '.$unidad.'</a></div>';
			   $unidades .= '<div class="collapse-box hide" id="box-'.$unidad.'"><span class="desc">Total de Tareas: '.$result->num_rows.'</span><hr>'; 
                
			    while($row = $result->fetch_assoc()) {
			    	$unidades .= '<div class="row edit-tareas" id="t-'.$row['id'].'"><hr><div class="col col-9"><i class="fa fa-clipboard"></i> <a id="t-'.$row['id'].'" data-component="modal" data-target="#tareas-info">'.$row['titulo'].'</a><br>';
			    	$unidades .= '<span class="label tag success">Fecha Asignada: '.$row['fec_ini'].'</span>&nbsp;&nbsp;&nbsp;<span class="label tag error"> Fecha Límite: '.$row['fec_lim'].'</span></div>';
                    
                    
                    if(strtotime($row['fec_ini']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($row['fec_lim']) >= strtotime(date('Y-m-d H:i:s'))){
			    	$unidades .= '<div class="col col-2 offset-1"><button id="env-'.$row['id'].'" class="button small">Entregar</button></div></div><hr>';
                    }else{
                    $unidades .= '<div class="col col-2 offset-1"><button class="button disabled small">Entregar</button></div></div><hr>';   
                    }
                    
			    	
			    }
			   $unidades .= '</div>';  
			 }else{
			 		$unidades .= '<div class="header-topic"><a id=u-"'.$row['unidad'].'" href="#box-'.$unidad.'" class="collapse-toggle">Unidad: '.$unidad.'</a></div>';
			    	$unidades .= '<div class="collapse-box hide" id="box-'.$unidad.'"><br><div class="message error" data-component="message">La unidad aún no tiene tareas.<span class="close small"></span></div></div>';
			 }
		}
			 
		return $unidades.'</div>';
    	}
    
        public function tareasEntregadas(){
		$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $grupo = explode('-', $_COOKIE['data']);
 	   $sql = "SELECT * FROM unidades WHERE unidades.id_grup = ".$grupo[1];
 	   $result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
				echo $this->misTareas($result->num_rows, $grupo[1]);
				}else echo '<div class="message error" data-component="message">La matería aún no tiene unidades, añade unidades...<span class="close small"></span></div>';	
 	   $this->conn->close();
		}
		
			   /// ----------- Consulta termario con sus tareas correspondientes
    public function misTareas($lim, $grupo) {
 	   $unidades = '<div class="temario"><div id="my-collapse" data-component="collapse">';
 	   
 	   for($unidad = 1; $unidad <= intval($lim);$unidad++) {
 	   	$this->conn->next_result();  	 	
    		$sql = "SELECT * FROM tareas INNER JOIN actividades AS act ON tareas.id_act = act.id WHERE tareas.noc = ".$_SESSION['alumno']." AND act.unidad = ".$unidad.";";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
				$unidades .= '<div class="header-topic"><a id=u-"'.$unidad.'" href="#box-'.$unidad.'" class="collapse-toggle">Unidad: '.$unidad.'</a></div>';
			   $unidades .= '<div class="collapse-box hide" id="box-'.$unidad.'"><span class="desc">Total de Tareas: '.$result->num_rows.'</span><hr>'; 
                
			    while($row = $result->fetch_assoc()) {
                    if(!empty($row['calificacion'])){
                        $unidades .='<span class="label success">Calificación: '.$row['calificacion'].'</span><br>';
                    }else{
                        $unidades .='<span class="label warning">Sin calificación</span><br><br>';
                    }
			    	$unidades .= '<div class="row rev-tareas" id="t-'.$row['id_act'].'"><hr><div class="col col-8"><i class="fa fa-clipboard"></i> <a id="t-'.$row['id'].'" title="Ver Detalles" data-component="modal" data-target="#tareas-entre">'.$row['titulo'].'</a><br>';
                    
                    
			    	$unidades .= '<span style="font-size: 10px;" class="label tag success">Fecha Asignada: '.$row['fec_ini'].'</span>&nbsp;&nbsp;<span style="font-size: 10px;" class="label tag error"> Fecha Límite: '.$row['fec_lim'].'</span></div>';
                    
                    
                   
                    $unidades .= '<div class="col col-3 offset-1"><span style="font-size: 12px; text-align: center;" class="label focus">Enviada:<br> '.$row['fec_env'].'</span></div></div><hr>';   
                    
                    
			    	
			    }
			   $unidades .= '</div>';  
			 }else{
			 		$unidades .= '<div class="header-topic"><a id=u-"'.$row['unidad'].'" href="#box-'.$unidad.'" class="collapse-toggle">Unidad: '.$unidad.'</a></div>';
			    	$unidades .= '<div class="collapse-box hide" id="box-'.$unidad.'"><br><div class="message error" data-component="message">No has entregado ninguna tarea de la unidad.<span class="close small"></span></div></div>';
			 }
		}
			 
		return $unidades.'</div>';
    	}

}
?>