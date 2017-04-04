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
    }
}
?>