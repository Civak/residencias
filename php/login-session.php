<?php
session_start();
ob_start();

include('conexion.php');

class Login
{
    private $conn;
    
 /// --------------- Verificar y crear sesión de Personal
    public function crearSesionPersonal($usuario, $pass, $rol)
    {
    	  $this->conn = new Conexion('datosServer.php');
		  $this->conn = $this->conn->conectar();
		  
        $encontrado = false;
		  $tipo = 0;
        $sql = "CALL loginPersonal('".$usuario."', '".$rol."')";
        
        $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    if (hash_equals($row["pass"], crypt($pass, $row["pass"])) && strcmp($row["rfc"], $usuario) == 0)
                    {
								setcookie('info', $row['nombre'], 0, "/");
                    		switch($row["rol"]){
                    			case 'A':
                    			$_SESSION['admin'] = $row["rfc"];
                    			$tipo = 1;
                    			break;
                    			case 'C':
                    			$_SESSION['coordinador'] = $row["rfc"];
                    			$tipo = 2;
                    			break;
                    			case 'P':
                    			$_SESSION['profesor'] = $row["rfc"];
                    			$tipo = 3;
                    			break;
                    		}
                        $encontrado = true;
                        break;
                    }
                }
            }
            
            $this->conn->close();
            if($encontrado)
            {
                echo $tipo;
            }else echo -1;
    }

     /// --------------- Verificar y crear sesión de Alumnos
    public function crearSesionAlumno($usuario, $pass)
    {
    	  $this->conn = new Conexion('datosServer.php');
		  $this->conn = $this->conn->conectar();
		  
        $encontrado = false;
        $activo = 0;
        $sql = "CALL loginAlumno(".$usuario.")";
        
        $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    if (hash_equals($row["pass"], crypt($pass, $row["pass"])) && strcmp($row["noc"], $usuario) == 0)
                    {
                    		setcookie('info', $row['nombre'], 0, "/");
                        $_SESSION['alumno'] = $row["noc"];
                        $encontrado = true;
                        $activo = $row['activo'];
                        break;
                    }
                }
            } else {
                echo -1;
            }
            
            $this->conn->close();
            if($encontrado)
            {
            	//Es -2 en caso de existir en la BD, pero no esté activo.
            	if(strcmp($activo, 'N') == 0){
	            	if(isset($_SESSION['alumno'])){
					            session_unset(); 
					            session_destroy();
					        }
					        echo -2;
            	}
                else echo 1;
            }else echo -1;
    
    }
 }

/* ---------------------------------------
------- Aquí se crea switcheo para tipo de logeo mediante cookie.
------- El nombre de la cookie: info / se crea en js/scripts.js
------------------------------------------ */ 
 if(isset($_COOKIE["info"]))
{
	// Se crea objeto de la clase Login
    $usuario = new Login();
    switch($_COOKIE["info"])
    {
        case 'student':
            $usuario->crearSesionAlumno($_POST["user"], $_POST["pass"]);
        break;
        case 'personal':
            $usuario->crearSesionPersonal($_POST["user"], $_POST["pass"], $_POST['rol']);
        break;
    }
}
 ?>