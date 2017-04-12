<?php
include('../../../php/conexion.php');

class Ediciones{

private $conn;

	public function consultarTemario() {
		$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
		$datos = explode('-', $_COOKIE['data']);
		$temario = '';
		$sql = "SELECT * FROM unidades WHERE unidades.id_grup = ".$datos[1]." AND unidades.unidad = ".$datos[2].";";
				
		$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $temario = $row['contenido'];
			    }
			}
			
		setcookie('data', $datos[0].'-'.$datos[1], 0, "/");
		return $temario;	
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
    
    public function ConsultarExamenes(){
		$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $grupo = explode('-', $_COOKIE['data']);
 	   $sql = "SELECT * FROM unidades WHERE unidades.id_grup = ".$grupo[1];
 	   $result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
				echo $this->panelExamenes($result->num_rows, $grupo[1]);
				}else echo '<div class="message error" data-component="message">La matería aún no tiene examenes programados.<span class="close small"></span></div>';	
 	   $this->conn->close();
		}
    
    			   /// ----------- Consulta termario con sus tareas correspondientes
    public function panelExamenes($lim, $grupo) {
 	   $unidades = '<div class="temario"><div id="my-collapse" data-component="collapse">';
 	   
 	   for($unidad = 1; $unidad <= intval($lim);$unidad++) {
 	   	$this->conn->next_result();  	 	
    		$sql = "SELECT * FROM examenes WHERE examenes.id_mat = ".$grupo." AND examenes.unidad = ".$unidad." GROUP BY examenes.id;";
			$result = $this->conn->query($sql);
            
			if ($result->num_rows > 0) {
                $ex = 1;
				$unidades .= '<div class="header-topic"><a id=u-"'.$unidad.'" href="#box-'.$unidad.'" class="collapse-toggle">Unidad: '.$unidad.'</a></div>';
			   $unidades .= '<div class="collapse-box hide" id="box-'.$unidad.'">'; 
			    while($row = $result->fetch_assoc()) {
			    	$unidades .= '<div class="row edit-examen" id="t-'.$row['id'].'"><hr><div class="col col-9"><i class="fa fa-clipboard"></i> <a id="t-'.$row['id'].'" data-component="modal" data-target="#tareas-info">Examen No. '.$ex.'</a><br>';
			    	$unidades .= '<span class="label tag success">Fecha Asignada: '.$row['fec_ini'].'</span>&nbsp;&nbsp;&nbsp;<span class="label tag error"> Fecha Límite: '.$row['fec_lim'].'</span></div>';
			    	$unidades .= '<div class="col col-2 offset-1"><i title="Editar" id="edit-'.$row['id'].'" class="fa fa-pencil success"></i> <i title="Eliminar" id="elim-'.$row['id'].'" class="fa fa-close error"></i></div></div>';
			    	$ex++;
			    }
			   $unidades .= '</div>';  
			 }else{
			 		$unidades .= '<div class="header-topic"><a id=u-"'.$row['unidad'].'" href="#box-'.$unidad.'" class="collapse-toggle">Unidad: '.$unidad.'</a></div>';
			    	$unidades .= '<div class="collapse-box hide" id="box-'.$unidad.'"><br><div class="message error" data-component="message">La unidad no tiene examenes programados.<span class="close small"></span></div></div>';
			 }
		}
			 
		return $unidades.'</div>';
    	}
    
    public function ConsultarUniTar(){
		$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $grupo = explode('-', $_COOKIE['data']);
 	   $sql = "SELECT * FROM unidades WHERE unidades.id_grup = ".$grupo[1];
 	   $result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
				echo $this->tareasEnt($result->num_rows, $grupo[1]);
				}else echo '<div class="message error" data-component="message">La matería aún no tiene unidades, añade unidades...<span class="close small"></span></div>';	
 	   $this->conn->close();
		}
    
    public function listaTareas(){
		$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $sql = "SELECT * FROM tareas INNER JOIN alumnos ON tareas.noc = alumnos.noc WHERE tareas.id_act = ".$_COOKIE['tar'];
 	   $result = $this->conn->query($sql);
       $alumnos = '<div id="lis-tar">';
        $enco = false;
        
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $alumnos .= '<i class="fa fa-user"></i> <a data-component="modal" data-target="#calf-tarea" href="a-'.$row['noc'].'-'.$_COOKIE['tar'].'">'.$row['noc'].' - '.$row['nombre'].'</a><br>';
			    }
                $enco = true;
			}
        if($enco) echo $alumnos.'</div>';
        else echo '<div class="message error" data-component="message">No hay tareas entregadas...<span class="close small"></span></div>';
        setcookie('tar', null, -1, '/');
 	   $this->conn->close();
		}
    
    		   /// ----------- Consulta termario con sus tareas correspondientes
    public function tareasEnt($lim, $grupo) {
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
			    	$unidades .= '<div id="rev-tar" class="col col-2 offset-1"><button title="Revisar Tarea" class="button small" id="tar-'.$row['id'].'">Revisar</button></div></div>';
			    	
			    }
			   $unidades .= '</div>';  
			 }else{
			 		$unidades .= '<div class="header-topic"><a id=u-"'.$row['unidad'].'" href="#box-'.$unidad.'" class="collapse-toggle">Unidad: '.$unidad.'</a></div>';
			    	$unidades .= '<div class="collapse-box hide" id="box-'.$unidad.'"><br><div class="message error" data-component="message">La unidad aún no tiene tareas.<span class="close small"></span></div></div>';
			 }
		}
			 
		return $unidades.'</div>';
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
		
		public function consultarTarea($dato) {
		$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
		
		$temario = '';
		$sql = "SELECT * FROM actividades WHERE actividades.id = ".$dato.";";
				
		$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $temario = array($this->obtenerArchivos($row['docs']), $row['fec_ini'], $row['fec_lim'],$row['titulo'], $row['instrucciones'], $this->consultarUnidadesTareas($row['unidad']), $row['docs']);
			    }
			}
			
		return $temario;	
		$this->conn->close();
		}
    
    public function contarPreguntas($dato){
        $this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
        $sql = "SELECT * FROM examenes WHERE examenes.id = ".$dato.";";
				
		$result = $this->conn->query($sql);
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                return array($row['fec_ini'], $row['fec_lim'],$row['unidad'],$result->num_rows);
                break;
            }
        } 

        $this->conn->close();
        return 0;
    }
    
    public function comboUnidad($unidad) {
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
                    if(strcmp($row['unidad'],$unidad) == 0) $cat .= '<option value="'.$row['unidad'].'" selected>Unidad '.$row['unidad'].'</opcion>';
			       else $cat .= '<option value="'.$row['unidad'].'">Unidad '.$row['unidad'].'</opcion>';
			    }
			   $encontrado = true;
			} 
			
			if($encontrado) echo $cat.'</select><br>';
			else echo '<div class="message error" data-component="message">La matería aún no tiene unidades, añade unidades...<span class="close small"></span></div>';
    	$this->conn->close();
    	}
    
    public function editarExamen($dato) {
		$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
		
		$sql = "SELECT * FROM examenes WHERE examenes.id = ".$dato.";";
				
		$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        echo $this->crearPregunta($row['descripcion'],$row['pregunta']);
			    }
			}
	
		$this->conn->close();
		}
    
    public function crearPregunta($des, $p){
        $lista = '';
        $op = explode('@',$des);
        
                $lista .= '<div class="col col-5">
                <br><input type="text" value="'.$op[0].'" name="p-'.$p.'"><br>
                <div class="row">
                    <div class="col col-1"><br>
                    <div class="form-item">';
                        switch(intval($op[1])){
                            case 1:
                                $lista .= '<label class="checkbox"><input type="radio" name="p-'.$p.'-r" value="1" checked></label><br>
                                    <label class="checkbox"><input type="radio" name="p-'.$p.'-r" value="2"></label><br>
                                    <label class="checkbox"><input type="radio" name="p-'.$p.'-r" value="3"></label>';
                                break;
                             case 2:
                                $lista .= '<label class="checkbox"><input type="radio" name="p-'.$p.'-r" value="1"></label><br>
                                    <label class="checkbox"><input type="radio" name="p-'.$p.'-r" value="2" checked></label><br>
                                    <label class="checkbox"><input type="radio" name="p-'.$p.'-r" value="3"></label>';
                                break;
                             case 3:
                                $lista .= '<label class="checkbox"><input type="radio" name="p-'.$p.'-r" value="1"></label><br>
                                    <label class="checkbox"><input type="radio" name="p-'.$p.'-r" value="2"></label><br>
                                    <label class="checkbox"><input type="radio" name="p-'.$p.'-r" value="3" checked></label>';
                                break;
                        }
                        
                            
                    $lista .= '</div></div>
                    <div class="col col-11">Respuestas:
                        <input type="text" value="'.$op[2].'" name="p-'.$p.'-a">
                        <input type="text" value="'.$op[3].'" name="p-'.$p.'-b">
                        <input type="text" value="'.$op[4].'" name="p-'.$p.'-c">
                    </div>
                </div>
            </div>';
        
        return $lista;
    }
    
    public function tareaAlumno($tarea,$alumno) {
		$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
		
		$temario = '';
		$sql = "CALL revisarTar(".$alumno.",".$tarea.");";
				
		$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
                    $temario = array($this->obtenerArchivos($row['docs']), $row['fec_ini'], $row['fec_lim'],$row['titulo'], $row['instrucciones'], $row['contenido'],$row['fec_env'],$row['observaciones'],$row['calificacion'], $this->obtenerArchivosAlum($row['doc']));
			    }
			}
			
		return $temario;	
		$this->conn->close();
		}
		
		public function obtenerArchivos($str) {
    		$docs = '<div class="docs"><b><i class="fa fa-file-archive-o fa-lg"></i> Documentos:</b><hr>';

    			$docs .= '<a href="./docs/'.$str.'" download>'.$str.'</a><br>';
    		
    		
    		return $docs.'</div>';
    	}

    	
    		public function consultarUnidadesTareas($uni) {
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
			    	if(strcmp($row['unidad'], $uni) == 0) {
			        $cat .= '<option value="'.$row['unidad'].'" selected>Unidad '.$row['unidad'].'</opcion>';
			     }else{
			     	  $cat .= '<option value="'.$row['unidad'].'">Unidad '.$row['unidad'].'</opcion>';
			     }
			    }
			   $encontrado = true;
			} 
			
			if($encontrado) return $cat.'</select><br>';
			else return '<div class="message error" data-component="message">La matería aún no tiene unidades, añade unidades...<span class="close small"></span></div>';
    	$this->conn->close();
    	}
    	
    	public function consultarUnidadesDocs() {
    	$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
		$datos = explode('-', $_COOKIE['data']); 

 	   $cat = '<label>Selecciona Unidad</label>
								<select id="docs-edit" name="docs-edit">'; 	
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
    
    public function consultarTareaAlum($tarea, $alumno) {
		$this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
		
		$temario = '';
		$sql = "SELECT act.fec_ini, act.fec_lim,act.titulo,act.instrucciones,act.unidad, tar.docs,tar.observaciones,tar.calificacion,tar.fec_env, tar.contenido FROM actividades AS act INNER JOIN tareas AS tar ON act.id = tar.id_act WHERE act.id = ".$tarea." AND tar.noc = ".$alumno;
				
		$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $temario = array($this->obtenerArchivosAlum($row['docs']), $row['fec_ini'], $row['fec_lim'],$row['titulo'], $row['instrucciones'], $row['fec_env'], $row['observaciones'],$row['calificacion'],$row['contenido']);
			    }
			}
			
		return $temario;	
		$this->conn->close();
		}
		
		public function obtenerArchivosAlum($str) {
            $arch = explode(";", $str);
    		$docs = '<div class="docs"><b><i class="fa fa-file-archive-o fa-lg"></i> Documentos Enviados:</b><hr>';
            for($i = 0; $i < count($arch) - 1;$i++){
    			$docs .= '<a href="http://proyecto.myft.org/proyecto/residencias/panel/profesor/tareas/'.$arch[$i].'" download>'.$arch[$i].'</a><br>';
            }
    		
    		
    		return $docs.'</div>';
    	}

}
?>
