
<?php
    class CargarImagenes
    {//----------------- inicia clase
        
		//Atributos privados accesibles para todas las funciones. 
		// la variable conn es global, es el objeto que conecta a la BD.
        private $conn;
        private $codebar;
        

        public function conectar()
        {
			// Se incluyen archivo con datos del servidor, bd, pass, user, server, etc.
            include('../../php/datos.php');
               $this -> conn = new mysqli($host, $user, $pw, $db);
               $this->conn->set_charset('utf8');
            if (mysqli_connect_error()) {
                die("Error en conexión, intenta de nuevo.");
            }
        
        }
        //-----Función que agrega artículo nuevo.
       function agregarImg()
        {   
		/*
		El primer paso es verificar si todas las imagenes cumplen menor del peso válido, que no sobre pasen los 3MB, 
		posteriormente se evaluan si realmente tiene un archivo el objeto HTML input. 
		Se recomienda que todos los imput file de imágenes sean nombrados: img1, img2, img3, etc.
		*/
		    $permitido = true;
			$limite = (1024 * 1024 * 3);
			$cantidadImg = 3; // Supongamos que hay 3 input para subir 3 imagenes. 
			
			for($i = 1; $i <= $cantidadImg; $i++){
				if($_FILES['img'.$i]["size"] > $limite || $_FILES['img'.$i]["size"] == 0){
					// Alguna imagen sobrepasa el peso permitido.
					$permitido = false;
					break;
				}
			}
			
			//Si se cumple lo anterior comieza a cargar las imagenes en la carpeta del servidor y crear los thumbs.
			if($permitido)
			{
				$this->conectar(); //Se llama funcion conectar.
            /*imagenes del formulario, la función cargarImagenes(par1, par2) tiene dos parametros, los cuales son: el  nombre de la imagen es decir
			del input, y el número de dicha imagen que servirá para renombrarla. 
			*/
			
			$this->generaCodigos(); // Se genera número aleatorio para las imagenes.
			for($i = 1; $i <= $cantidadImg; $i++){
				$this->cargarImagenes("img".$i, $i);
			}
            
			/*insertar campos en la BD, después de cargar las imagenes y no exista un error durante
			el proceso de carga de imagenes. 
			*/
            $this->insertarValor();
			//Se cierra conexión.
            $this->conn->close();
			}
			else 
			{	//En caso de no cumplir con el peso valido, se regresa un entero (ver archivo de JS).
				// La carga se hace mediante AJAX.
				echo -2;	
			}
            
        }
        
        function cargarImagenes($imagen, $numero)
        {
			// Donde se guardaran las imágenes en el server?
            $ruta = "../../../../secciones/imagenes/";
            
              $nombreAntiguo = $_FILES[$imagen]['name'];
              $nombre_tmp = $_FILES[$imagen]['tmp_name'];
              $tipo = $_FILES[$imagen]['type'];
            
			  // Proceso de regex que evalua si son extensiones validas.
              $ext_permitidas = array('jpg','jpeg','gif','png');
              $partes_nombre = explode('.', $nombreAntiguo);
              $extension = end( $partes_nombre );
              $extension = strtolower($extension);
              //El nombre final sería algo así: 123456789_1.jpg, 123456789_2.jpg, 123456789_3.jpg, etc.
              $nombre = $this->codebar . "_".$numero.".".$extension;
              $ext_correcta = in_array($extension, $ext_permitidas);
            
              $tipo_correcto = preg_match('/^image\/(pjpeg|jpeg|gif|png)$/', $tipo);
            
            
              if( $ext_correcta && $tipo_correcto){
                if( $_FILES[$imagen]['error'] > 0 ){
                  //echo 'Error: verifica el tamaño o formato correcto.';
                }else{
            
                  if( file_exists($ruta.$nombre) ){
                    //echo 'Ups... ocurrió un error, intenta de nuevo.';
                  }else{
                    move_uploaded_file($nombre_tmp, $ruta.$nombre);
                    chmod($ruta.$nombre, 0777);
                    
                    /* Estas funciones son opciones, se pueden comentar. 
                     * La primera es para poner marca de agua sobre la imagen, en caso de que se pida; tener en cuenta
                     * que debe existir una imagen con transparencia en el servidor (consultar funcion).
                     * crearThumbs es para crear un preview de la imagen grande, en caso de tener que crear todo
                     * una galeria de imagenes pequeñas y no poner las grandes. Aumenta rapidez de consulta en la pagina.
                     */
					$this->marcaAgua($ruta.$nombre, $ruta);
					$this->crearThumbs($ruta.$nombre);
                    
                     $sql = "INSERT INTO Imagenes VALUES ('".$nombre."');";
                     // el if de abajo es equivalente a $this->conn->query($sql); 
                     // Pero se puede poner if en caso de querer guardar un valor de error al insertar.
                        if ($this->conn->query($sql) === TRUE) {
                           // echo 1;
                          
                        } else {
                        //    echo -1;
                        }
                    //echo "mueve imagen";
                  }
                }
              }else{
                  die();
              }
        }
        
		//--------- Función para colocar marca de agua en la imagen subida.
		public function marcaAgua($imagen, $dir)
		{
			// Imagen en el server png con canal alpha.
			$marcadeagua = $dir.'estampa.png';
			$margen = 10;
			  //Averiguamos la extensión del archivo de imagen
				  $trozos_nombre_imagen=explode(".",$imagen);
				  $extension_imagen=$trozos_nombre_imagen[count($trozos_nombre_imagen)-1];
			  
				  //Creamos la imagen según la extensión leída en el nombre del archivo
				  if(preg_match('/jpg|jpeg|JPG|JPEG/',$extension_imagen))
					  $img=ImageCreateFromJPEG($imagen); 
					  if(preg_match('/png|PNG/',$extension_imagen)) 
						  $img=ImageCreateFromPNG($imagen); 
					  if(preg_match('/gif|GIF/',$extension_imagen)) 
						  $img=ImageCreateFromGIF($imagen); 
				  
				  //declaramos el fondo como transparente	
				  ImageAlphaBlending($img, true);
					  
				  //Ahora creamos la imagen de la marca de agua
				  $marcadeagua = ImageCreateFromPNG($marcadeagua);
				  
				  //Hallamos las dimensiones de ambas imágenes para alinearlas
				  $Xmarcadeagua = imagesx($marcadeagua);
				  $Ymarcadeagua = imagesy($marcadeagua);
				  $Ximagen = imagesx($img);
				  $Yimagen = imagesy($img);
				  
				  //Copiamos la marca de agua encima de la imagen (alineada abajo a la derecha)
				  imagecopy($img, $marcadeagua, $Ximagen-$Xmarcadeagua-$margen, $Yimagen-$Ymarcadeagua-$margen, 0, 0, $Xmarcadeagua, $Ymarcadeagua);
				  
				  //Guardamos la imagen sustituyendo a la original, en este caso con calidad 100
				  ImageJPEG($img,$imagen,100);
				  
				  //Eliminamos de memoria las imágenes que habíamos creado
				  imagedestroy($img);
				  imagedestroy($marcadeagua);
		}
		//------------------ Función para crear thumbs, despues de cargar las imagenes al servidor.
        function crearThumbs($img)
        {
            	$targ_w = 166;
				$targ_h = 194;
            	$jpeg_quality = 90;
            	// Dirección de la carpeta de thumbs de las imágenes originales.
            	$ruta = "../../../../secciones/imagenes/thumbs/";
            	$src = $img;
            	$partes_nombre = explode('/', $src);
               $nombre = end( $partes_nombre );
            	
            	
            	// Sacamos la extensión del archivo
            $ext = explode(".", $src);
            $ext = strtolower($ext[count($ext) - 1]);
            if ($ext == "jpeg") $ext = "jpg";
             
            // Dependiendo de la extensión llamamos a distintas funciones
            switch ($ext) {
                    case "jpg":
                            $img_r = imagecreatefromjpeg($src);
                    break;
                    case "png":
                            $img_r = imagecreatefrompng($src);
                    break;
                    case "gif":
                            $img_r = imagecreatefromgif($src);
                    break;
            }
            	
            	
            	$width = imagesx($img_r);
            	$height = imagesy($img_r);
            	$desired_width = 166;
            	$desired_height = floor($height * ($desired_width / $width));
            	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
            	imagecopyresampled($virtual_image, $img_r, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
            	
            switch ($ext) {
                    case "jpg":
                            imagejpeg( $virtual_image,$ruta.$nombre, $jpeg_quality);
                    break;
                    case "png":
            					$pngquality = floor(($jpeg_quality - 10) / 10);
            					 imagepng($virtual_image,$ruta.$nombre, $pngquality);
                    break;
                    case "gif":
                    			imagegif($virtual_image,$ruta.$nombre); 
                    break;
            }	
            	//Añadimos permisos de lectura y escritura.
            	 chmod($ruta.$nombre, 0777);
        }
        
		//------------ Función que sirve para obtener los detalles del artículo subido, es decir: 
		//Se obtien sección, categoria, etc. 
        function obtenerDetalles($sentencia, $campo){
            $info = "";
            $sql = $sentencia;
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $info = $row[$campo];
                }
            }
            
            return $info;
        }
        
		//Función que inserta los valores textuales del artículo, en cada proceso invoca obtenerDetalles.
		//Que tiene como parametro la sentencia SQL a utilizar.
        function insertarValor()
        {
            /*Se obtienen las variables de los campos a ingresar en la tabla del proyecto, articulo, objeto, etc.
             * Aquí se hace el proceso de insertar los datos de la imagen, por ejemplo la tabla que hace 
             * describe detalles del carro que hace referencia a las imagenes, esto depende del diseño.
             * */
       
			

            //Finalmente se inserta la información completa del artículo.
            $sql = "INSERT INTO Productos VALUES (parametros);";
            if ($this->conn->query($sql) === TRUE) {
                echo 1;
              
            } else {
                echo -1;
              
            }
			
			$sql = "INSERT INTO Vistas VALUES (".$Codigo.", 0);";
            if ($this->conn->query($sql) === TRUE) {
                //echo 1;
              
            } else {
                //echo -1;
              
            }
        }
        
        //------función que elimina articulo existente
        function eliminarImg()
        {
             $ruta = "../../../../secciones/imagenes/";
            $this->conectar(0);
            $sql = "DELETE FROM Productos WHERE codbar =".$_POST['cod'];
            if ($this->conn->query($sql) === TRUE) {
                
            $sql = "SELECT imagenes FROM Imagenes WHERE imagenes LIKE '%".$_POST['cod']."%'";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    if (file_exists($ruta.$row['imagenes'])) {
                    unlink($ruta.$row['imagenes']);
                    
                    if (file_exists($ruta."thumbs/".$row['imagenes'])) {
                    unlink($ruta."thumbs/".$row['imagenes']);
                    }
                  }
                }
            }
                
                $sql = "DELETE FROM Imagenes WHERE imagenes LIKE '%".$_POST['cod']."%'";
                if ($this->conn->query($sql) === TRUE) {
                echo 1;
                } else {
                    echo -1;
                }
            } else {
                echo -1;
              
            }
            $this->conn->close();
        }
        
        //---------------- generará numeros aleatorios de codigo de barras
        public function generaCodigos()
        {
            /*Elegi la funcion mt_rand por que genera numeros enteros mas grandes*/
            $code=rand(100, 999) . rand(100, 999) . rand(100, 999) . rand(100, 999);
            if($code<0) $code=($code1*-1);
			$this->codebar = $code;/*Si el numero es negativo lo vuelve positivo*/
            
            // Se hace una consulta a la BD para verificar que el numero al azar no exista, en caso de que si
            // Se genera uno nuevamente de forma recursiva. 
            $sql = "SELECT * FROM Productos WHERE codbar = '".$code."'";
            $existecodigo = $this->conn->query($sql);
            if ($existecodigo->num_rows > 0) { /*Si encontro el codigo se llama a si mismo para generar otro numero*/
                generaCodigos();
            }
        }
    }//----------- termina clase Articulo

	/* 
	 * Personalmente recomiendo invocar esta clase mediante cookies, para 
	 * poder utilizar ajax.
	 * 
	 * */
if(isset($_COOKIE["queHace"]))
{
	// Se crea objeto de la clase Login
    $imagenes = new CargarImagenes();
    switch($_COOKIE["queHace"])
    {
        case 'cargar':
            $imagenes->agregarImg();
        break;
        case 'eliminar':
            $imagenes->eliminarImg();
        break;
    }
}
?>
