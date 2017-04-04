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
        case 'ed-al-info':
            $datos->actInfoAlu();
        break;
        case 'ed-al-elim':
            $datos->eliminarAlu();
        break;
    }
}
?>