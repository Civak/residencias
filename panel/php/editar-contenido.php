<?php
session_start();
ob_start();
/// Se utiliza cookie para swicheo
 if(isset($_COOKIE["opcion"]))
{
	/// Se crea objeto de la clase 
    $op = explode('$', $_COOKIE['opcion']);
    switch($op[1])
    {
        case 'ed-do':
            include('../../../php/conexion.php');
        break;
        default: include('../../php/conexion.php');
    }
}


class Editar{
	private $conn;
	
   	   /// ----------- Guarda temario actualizado
    public function actTemario() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $op = explode('-', $_COOKIE['data']);  	 	
    		$sql = "CALL guardarTemario(".$op[1].", ".$_POST['unidad'].",'".$_POST['temario']."');";
			if ($this->conn->query($sql) === TRUE) {
			    echo 'Temario de la Unidad '.$_POST['unidad'].' actualizado exitosamente...';
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
    	
    	   /// ----------- Elimina tarea
    public function eliminarTarea() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	 	
    		$sql = "DELETE FROM actividades WHERE actividades.id = ".$_POST['dato1'];
			if ($this->conn->query($sql) === TRUE) {
			    echo 1;
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
    	
    		   /// ----------- Elimina tarea
    public function eliminarDocs() {
    	$ruta = "../profesor/docs/";
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	 	$op = explode('_', $_POST['dato1']);
    		$sql = "CALL eliminarDocs(".$op[1].",".$op[2].",'".$_POST['dato1'].";');";;
			if ($this->conn->query($sql) === TRUE) {
				unlink($ruta.$_POST['dato1']);
			    echo 2;
			} else {
			    echo -1;
			}
    	$this->conn->close();
    	}
    	
    		   /// ----------- Guarda tarea actualizado
    public function actTarea() {
    	$this->conn = new Conexion('../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
	 	
    		$sql = "";
    		
			if(!file_exists($_FILES['archivo']['tmp_name']) || !is_uploaded_file($_FILES['archivo']['tmp_name'])) {
				    $sql = "CALL actTareaSA(".$_POST['id-t'].",'".$_POST['fec-ini']."','".$_POST['fec-lim']."','".$_POST['titulo']."','".$_POST['contenido']."',".$_POST['unidades-tareas'].");";
					 $this->guardarTareaBD($sql);
				}else{
					$this->guardarFile('archivo');
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
		
		public function guardarFile($file) {
			$ruta = "../profesor/docs/";
              $archivo = $_FILES[$file]['name'];
              $tmp = $_FILES[$file]['tmp_name'];
              $grupo = explode('-', $_COOKIE['data']); 
              $nombre = rand(1,300). "_".$grupo[1]."_".$archivo;
              
              if( $_FILES[$file]['error'] > 0 ){
                  echo -1;
                }else {
                move_uploaded_file($tmp, $ruta.$nombre);
              	 chmod($ruta.$nombre, 0777);
              	 unlink($ruta.$_POST['archivo-h']);
              	 $sql = "CALL actTareaCA(".$_POST['id-t'].",'".$_POST['fec-ini']."','".$_POST['fec-lim']."','".$_POST['titulo']."','".$_POST['contenido']."',".$_POST['unidades-tareas'].",'".$nombre."');";
                $this->guardarTareaBD($sql);
                }
                
			}
			
		   	   /// ----------- Consulta termario del grupo o materia para eliminar archivos
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
			    	if(!empty($row["docs"])) {
			    	$unidades .= '<div class="collapse-box hide" id="box-'.$unidad.'">';
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
    	
    	public function obtenerArchivos($str) {
    		$docs = '<div class="docs"><b><i class="fa fa-file-archive-o fa-lg"></i> Documentos:</b><hr>';
    		$files = explode(';', $str);
    		for($i = 0; $i < count($files) - 1;$i++) {
    			$docs .= '<div id="'.substr($files[$i], 0, 8).'" class="row"><div class="col col-11"><a href="./docs/'.$files[$i].'" download>'.$files[$i].'</a></div>';
    			$docs .= '<div class="col col-1"><i title="Eliminar" id="'.$files[$i].'" class="fa fa-close error"></i></div></div>';
    		}
    		
    		return $docs.'</div>';
    	}
    	
    	public function actPassAlu() {
    		$this->conn = new Conexion('../../php/datosServer.php');
			$this->conn = $this->conn->conectar();
			error_reporting(E_ERROR | E_WARNING | E_PARSE);
	 	   $pass = crypt($_POST['pass']);
	 	   
			$grupo = explode('-', $_COOKIE['data']);
			$sql = "CALL actPassAlu(".$_POST['noc'].",'".$pass."',".$grupo[1].");";

			if ($this->conn->query($sql) === TRUE) {
			    echo "Cambio de contraseña correctamente.";
			} else {
			    echo -1;
			}
			$this->conn->close();
    	}
    
        public function passAlu() {
    		$this->conn = new Conexion('../../php/datosServer.php');
			$this->conn = $this->conn->conectar();
			error_reporting(E_ERROR | E_WARNING | E_PARSE);
	 	   $pass = crypt($_POST['pass']);
	 	   
			$sql = "UPDATE alumnos SET alumnos.pass = '".$pass."' WHERE alumnos.noc =".$_SESSION['alumno'];

			if ($this->conn->query($sql) === TRUE) {
			    echo "Cambio de contraseña correctamente.";
			} else {
			    echo -1;
			}
			$this->conn->close();
    	}
    
        public function passPro() {
    		$this->conn = new Conexion('../../php/datosServer.php');
			$this->conn = $this->conn->conectar();
			error_reporting(E_ERROR | E_WARNING | E_PARSE);
	 	   $pass = crypt($_POST['pass']);
	 	   
			$sql = "UPDATE profesores SET profesores.pass = '".$pass."' WHERE profesores.rfc ='".$_SESSION['profesor']."'";

			if ($this->conn->query($sql) === TRUE) {
			    echo "Cambio de contraseña correctamente.";
			} else {
			    echo -1;
			}
			$this->conn->close();
    	}
    	
    	public function actInfoAlu() {
    		$this->conn = new Conexion('../../php/datosServer.php');
			$this->conn = $this->conn->conectar();
	 	   
			$grupo = explode('-', $_COOKIE['data']);
			$sql = "CALL actInfoAlu(".$_POST['noc'].",'".$_POST['nom']."','".$_POST['activo']."',".$grupo[1].",".$_POST['noc-h'].");";

			if ($this->conn->query($sql) === TRUE) {
			    echo "Alumno actualizado correctamente.";
			} else {
			    echo -1;
			}
			$this->conn->close();
    	}
    	
    	public function eliminarAlu() {
    		$this->conn = new Conexion('../../php/datosServer.php');
			$this->conn = $this->conn->conectar();
	 	   
			$grupo = explode('-', $_COOKIE['data']);
			$sql = "DELETE FROM gru_alum WHERE gru_alum.noc = ".$_POST['noc']." AND gru_alum.id_grup = ".$grupo[1];
			$this->conn->query($sql);
			
			if ($this->conn->affected_rows > 0) {
			    echo "Alumno eliminado correctamente.";
			} else {
			    echo -1;
			}
			$this->conn->close();
    	}
    
    public function actPerAlu() {
    		$this->conn = new Conexion('../../php/datosServer.php');
			$this->conn = $this->conn->conectar();
			
			if($_FILES['sel-img']["size"] != 0){
                    $this->cargarImagenes('sel-img');
				}else{
                 $sql = "UPDATE alumnos SET alumnos.nombre = '".$_POST['nom']."' WHERE alumnos.noc = ".$_SESSION['alumno'];
                if ($this->conn->query($sql) === TRUE) {
                           echo 2;
                        } else {
                        echo -1;
                        }
            }
			$this->conn->close();
    	}
    
      public function actPerPro() {
    		$this->conn = new Conexion('../../php/datosServer.php');
			$this->conn = $this->conn->conectar();
			
			if($_FILES['sel-img']["size"] != 0){
                    $this->cargarImagenesPro('sel-img');
				}else{
                $tel = 0;
                if(strlen($_POST['tel']) != 0) $tel = $_POST['tel'];
                 $sql = "CALL actPerPro('".$_SESSION['profesor']."', '".$_POST['nom']."', '".$_POST['apep']."', '".$_POST['apem']."', '".$_POST['ema']."', '".$tel."','".$_POST['cv']."')";
                if ($this->conn->query($sql) === TRUE) {
                           echo 2;
                        } else {
                        echo -1;
                        }
            }
			$this->conn->close();
    	}
    
     public function calTarea() {
    		$this->conn = new Conexion('../../php/datosServer.php');
			$this->conn = $this->conn->conectar();
			$datos = explode('-',$_COOKIE['tar']);

                 $sql = "UPDATE tareas SET tareas.observaciones = '".$_POST['obs']."', tareas.calificacion =".$_POST['calif']." WHERE tareas.id_act = ".$datos[2]." AND tareas.noc =".$datos[1];
                if ($this->conn->query($sql) === TRUE) {
                           echo 3;
                        } else {
                        echo -1;
                        }
			$this->conn->close();
    	}
    
    function cargarImagenesPro($imagen)
        {
			// Donde se guardaran las imágenes en el server?
            $ruta = "../profesor/img/";
            
              $nombreAntiguo = $_FILES[$imagen]['name'];
              $nombre_tmp = $_FILES[$imagen]['tmp_name'];
              $tipo = $_FILES[$imagen]['type'];
            
			  // Proceso de regex que evalua si son extensiones validas.
              $ext_permitidas = array('jpg','jpeg','gif','png');
              $partes_nombre = explode('.', $nombreAntiguo);
              $extension = end( $partes_nombre );
              $extension = strtolower($extension);
              $nombre = $_SESSION['profesor'].".".$extension;
              $ext_correcta = in_array($extension, $ext_permitidas);
            
              $tipo_correcto = preg_match('/^image\/(pjpeg|jpeg|gif|png)$/', $tipo);
            
            
              if( $ext_correcta && $tipo_correcto){
                if( $_FILES[$imagen]['error'] > 0 ){
                  echo -1;
                }else{
            
                    move_uploaded_file($nombre_tmp, $ruta.$nombre);
                    chmod($ruta.$nombre, 0777);
                     $tel = 0;
                    if(strlen($_POST['tel']) != 0) $tel = $_POST['tel'];
                     $sql = "UPDATE profesores SET nombre = '".$_POST['nom']."', apepat = '".$_POST['apep']."', apemat = '".$_POST['apem']."', email = '".$_POST['ema']."', telefono = '".$tel."', cv = '".$_POST['cv']."', foto = '".$nombre."'  WHERE rfc = '".$_SESSION['profesor']."'";
                        if ($this->conn->query($sql) === TRUE) {
                           echo 2;
                        } else {
                        echo -1;
                        }
                  
                }
              }else{
                  die();
                  echo -1;
              }
        }
        function cargarImagenes($imagen)
        {
			// Donde se guardaran las imágenes en el server?
            $ruta = "../alumno/img/";
            
              $nombreAntiguo = $_FILES[$imagen]['name'];
              $nombre_tmp = $_FILES[$imagen]['tmp_name'];
              $tipo = $_FILES[$imagen]['type'];
            
			  // Proceso de regex que evalua si son extensiones validas.
              $ext_permitidas = array('jpg','jpeg','gif','png');
              $partes_nombre = explode('.', $nombreAntiguo);
              $extension = end( $partes_nombre );
              $extension = strtolower($extension);
              $nombre = 'i'.$_SESSION['alumno'].".".$extension;
              $ext_correcta = in_array($extension, $ext_permitidas);
            
              $tipo_correcto = preg_match('/^image\/(pjpeg|jpeg|gif|png)$/', $tipo);
            
            
              if( $ext_correcta && $tipo_correcto){
                if( $_FILES[$imagen]['error'] > 0 ){
                  echo -1;
                }else{
            
                    move_uploaded_file($nombre_tmp, $ruta.$nombre);
                    chmod($ruta.$nombre, 0777);

                     $sql = "UPDATE alumnos SET alumnos.nombre = '".$_POST['nom']."', alumnos.foto = '".$nombre."' WHERE alumnos.noc = ".$_SESSION['alumno'];
                        if ($this->conn->query($sql) === TRUE) {
                           echo 2;
                        } else {
                        echo -1;
                        }
                  
                }
              }else{
                  die();
                  echo -1;
              }
        }
}

/// Se utiliza cookie para swicheo
 if(isset($_COOKIE["opcion"]))
{
	/// Se crea objeto de la clase 
    $datos = new Editar();
    $op = explode('$', $_COOKIE['opcion']);
    switch($op[1])
    {
    	  case 'ed-te':
            $datos->actTemario();
        break;
        case 'ed-ta':
            $datos->eliminarTarea();
        break;
        case 'ed-ta-p':
            $datos->actTarea();
        break;
        case 'ed-to':
            $datos->consultarTemario();
        break;
        case 'el-do':
            $datos->eliminarDocs();
        break;
        case 'ed-al-pass':
            $datos->actPassAlu();
        break;
        case 'al-pass':
            $datos->passAlu();
        break;
        case 'pro-pass':
            $datos->passPro();
        break;
        case 'ed-al-info':
            $datos->actInfoAlu();
        break;
        case 'ed-al-elim':
            $datos->eliminarAlu();
        break;
        case 'ed-alum':
            $datos->actPerAlu();
        break;
        case 'ed-pro':
            $datos->actPerPro();
        break;
        case 'cal-tar':
            $datos->calTarea();
        break;
    }
}
?>