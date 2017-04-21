<?php
session_start();
ob_start();

include('../../php/conexion.php');

class Contenido{
	private $conn;
	
   	   /// ----------- Guarda contenido de unidad
    public function guardarContenido() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $op = explode('-', $_COOKIE['data']);  	 	
    		$sql = "CALL guardarTemario(".$op[1].", ".$_POST['unidad'].",'".$_POST['temario']."');";
			if ($this->conn->query($sql) === TRUE) {
			    echo 'Temario de la Unidad '.$_POST['unidad'].' guardado exitosamente...';
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
    
    public function guardarTema() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $op = explode('-', $_COOKIE['data']);  	 	
    		$sql = "INSERT INTO foro(id_gru, contenido, fecha) VALUES(".$op[1].", '".$_POST['tema']."',CURRENT_TIMESTAMP);";
			if ($this->conn->query($sql) === TRUE) {
			    echo 'Tema para Foro guardado exitosamente...';
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
    
    public function guardarComentario($cual) {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
  	 	
    		$sql = "INSERT INTO foro_msj(id_foro, user, msj, fecha) VALUES(".$_POST['id'].",'".$_SESSION['profesor']."', '".$_POST['com']."',CURRENT_TIMESTAMP);";
			if ($this->conn->query($sql) === TRUE) {
			    echo $cual;
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
    	
    	public function guardarTarea() {
    		$this->conn = new Conexion('../../php/datosServer.php');
			$this->conn = $this->conn->conectar();
			$sql = '';
			$grupo = explode('-', $_COOKIE['data']);
			
			if(!file_exists($_FILES['archivo']['tmp_name']) || !is_uploaded_file($_FILES['archivo']['tmp_name'])) {
				    $sql = "CALL guardarTarea(".$grupo[1].",'".$_POST['fec-ini']."','".$_POST['fec-lim']."','".$_POST['contenido']."',".$_POST['unidades-tareas'].",NULL,'".$_POST['titulo']."');";
					 $this->guardarTareaBD($sql);
				}else{
					$this->guardarFile('archivo', $grupo[1]);
				}
							
			$this->conn->close();
    	}
    	
    	public function guardarTareaBD($sql) {
    			if ($this->conn->query($sql) === TRUE) {
			    echo 1;
			} else {
			    echo -1;
			}
		}
		
		public function guardarFile($file, $grupo) {
			$ruta = "../profesor/docs/";
              $archivo = preg_replace('/\s+/', '', $_FILES[$file]['name']);
              $tmp = $_FILES[$file]['tmp_name'];
              /*$tipo = $_FILES[$file]['type'];
              
              $partes_nombre = explode('.', $nombreAntiguo);
              $extension = end( $partes_nombre );
              $extension = strtolower($extension);*/
              $nombre = rand(1,300). "_".$grupo."_".$archivo;
              
              if( $_FILES[$file]['error'] > 0 ){
                  echo -1;
                }else {
                move_uploaded_file($tmp, $ruta.$nombre);
              	 chmod($ruta.$nombre, 0777);
              	 $sql = "CALL guardarTarea(".$grupo.",'".$_POST['fec-ini']."','".$_POST['fec-lim']."','".$_POST['contenido']."',".$_POST['unidades-tareas'].",'".$nombre."','".$_POST['titulo']."');";
					 $this->guardarTareaBD($sql);
                }
                
			}
			
			public function cargarAlumnos($f) {
					$this->conn = new Conexion('../../php/datosServer.php');
					$this->conn = $this->conn->conectar();
			     $grupo = explode('-', $_COOKIE['data']);
              $tmp = $_FILES[$f]['tmp_name'];
              $sql = '';
					error_reporting(E_ERROR | E_WARNING | E_PARSE);
			 	   
			 	   
 				  $file = fopen($tmp,"r");
				  $i = 0;	
					while(!feof($file) && ($line = fgetcsv($file)) !== FALSE)
					  {
						  if($i > 0) {
						  	$pass = crypt($line[0]);
						  	$sql .= "CALL cargarAlumnos(".$line[0].", '".$line[1]."', 'user.png', '".$pass."', 'S',".$grupo[1].");";
						  }
						  $i++;
					  }
					  
					if ($this->conn->multi_query($sql) === TRUE) {
					    echo "Alumnos cargados correctamente al Grupo: ".$grupo[0];
					} else {
					    echo -1;
					}
					
					fclose($file);
               $this->conn->close(); 
			}
	/// Valida los archivos antes de subirlos a la unidad.		
	public function subirArchivo() {
	 $dir = "../profesor/docs/";
	 $grupo = explode('-', $_COOKIE['data']);
	 $correctos = false;
	 $files = '';
	     
    for($i = 1; $i <= 5; $i++) {
    		if(isset($_FILES["arch".$i])){
					      if ($_FILES["arch".$i]["error"] > 0){
					         $correctos = false;
					         break;
					      }
					      else
					      {
					        $name = preg_replace('/\s+/', '', basename($_FILES["arch".$i]["name"]));
					        $archivo = rand(1,300). "_".$grupo[1]."_".$_POST['unidades-docs']."_".$name;
					        $files .= $archivo.';';
					        move_uploaded_file($_FILES["arch".$i]["tmp_name"], $dir.$archivo);
					        chmod($dir.$archivo , 0777);
					        $correctos = true;
					      }
			    		}
			    			
					}
		
		if($correctos) {
				$this->guardarArchivoBD($grupo, $_POST['unidades-docs'], $files);	
			}else{ echo -1; }
		}
		/// Guarda archivo o archivos en la unidad correspondiente
		public function guardarArchivoBD($grupo, $unidad, $files) {
			$this->conn = new Conexion('../../php/datosServer.php');
			$this->conn = $this->conn->conectar();
			$sql = "CALL cargarArchivos(".$grupo[1].",".$unidad.",'".$files."');";
				if ($this->conn->query($sql) === TRUE) {
					    echo "Archivos cargados correctamente al ".$grupo[0].", Unidad: ".$unidad;
					} else {
					    echo -1;
					}
			$this->conn->close();
			}
    
    /// Valida los archivos antes de subirlos a la unidad.		
	public function subirTareaAlumno() {
	 $dir = "../profesor/tareas/";
	 $files = '';
	     
    for($i = 1; $i <= 5; $i++) {
    		if(isset($_FILES["arch".$i])){
					      if ($_FILES["arch".$i]["error"] > 0){
					         $correctos = false;
					         break;
					      }
					      else
					      {
					        $name = preg_replace('/\s+/', '', basename($_FILES["arch".$i]["name"]));
					        $archivo = rand(1,300). "_".$_POST['idtar']."_".$_SESSION['alumno']."_".$name;
					        $files .= $archivo.';';
					        move_uploaded_file($_FILES["arch".$i]["tmp_name"], $dir.$archivo);
					        chmod($dir.$archivo , 0777);
					      }
			    		}
			    			
					}
		
		
				$this->guardarArchivoBDAlum($_POST['idtar'], $_SESSION['alumno'], $files);	
			
		}
		/// Guarda archivo o archivos en la unidad correspondiente
		public function guardarArchivoBDAlum($tarea, $alum, $files) {
			$this->conn = new Conexion('../../php/datosServer.php');
			$this->conn = $this->conn->conectar();
            
			$sql = "CALL cargarTarea(".$alum.",".$tarea.",'".$files."','".$_POST['msj']."');";
				if ($this->conn->query($sql) === TRUE) {
					    echo "Tarea enviada correctamente.";
					} else {
					    echo -1;
					}
			$this->conn->close();
			}
    
    public function guardarExamen() {
			$this->conn = new Conexion('../../php/datosServer.php');
			$this->conn = $this->conn->conectar();
            $grupo = explode('-',$_COOKIE['data']);
            $des = $_POST['p-1'].'@'.$_POST['p-1-r'].'@'.$_POST['p-1-a'].'@'.$_POST['p-1-b'].'@'.$_POST['p-1-c'];
        
			$sql = "INSERT INTO examenes (pregunta, id_mat,unidad, fec_ini, fec_lim, descripcion, respuesta, tipo) VALUES (1,".$grupo[1].",".$_POST['unidades-tareas'].",'".$_POST['fec-ini']."', '".$_POST['fec-lim']."' ,'".$des."','".$_POST['p-1-r']."','O');";
            $this->conn->query($sql);
            $id = $this->conn->insert_id;
			
            $sql = '';
            for($i = 2; $i <= intval($_COOKIE['preguntas']);$i++){
                $des = $_POST['p-'.$i].'@'.$_POST['p-'.$i.'-r'].'@'.$_POST['p-'.$i.'-a'].'@'.$_POST['p-'.$i.'-b'].'@'.$_POST['p-'.$i.'-c'];
                
                $sql .= "CALL insertarPregunta(".$grupo[1].",".$_POST['unidades-tareas'].",'".$_POST['fec-ini']."', '".$_POST['fec-lim']."' ,'".$des."','".$_POST['p-'.$i.'-r']."',".$i.",".$id.");";
            }    
        
            if ($this->conn->multi_query($sql) === TRUE) {
					    echo "Examen guardado correctamente...";
					} else {
					    echo -1;
					}
            setcookie('preguntas', null, -1, '/');
			$this->conn->close();
			}
}

/// Se utiliza cookie para swicheo
 if(isset($_COOKIE["opcion"]))
{
	/// Se crea objeto de la clase 
    $datos = new Contenido();
    $op = explode('$', $_COOKIE['opcion']);
    switch($op[1])
    {
    	  case 'cr-te':
            $datos->guardarContenido();
        break;
        case 'cr-ta':
            $datos->guardarTarea();
        break;
        case 'cr-al':
            $datos->cargarAlumnos('archivo');
        break;
        case 'cr-do':
            $datos->subirArchivo();
        break;
        case 're-pe':
            $datos->subirTareaAlumno();
        break;
        case 'cr-ex':
            $datos->guardarExamen();
        break;
        case 'foro':
            $datos->guardarTema();
        break;
        case 'en-co':
            $datos->guardarComentario(1);
        break;
        case 'en-coo':
            $datos->guardarComentario(2);
        break;
    }
}
?>