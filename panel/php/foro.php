<?php
session_start();
ob_start();

include('../../../php/conexion.php');

class Foro{
    private $conn;
    
    public function Temas(){
    $this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $grupo = explode('-', $_COOKIE['data']);
       $topico = '';  
 	   $enco = false;
 	     	 	
    		$sql = "SELECT * FROM foro WHERE foro.id_gru = ".$grupo[1].' ORDER BY foro.fecha DESC;';
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
                    $topico = '<div id="tema" class="tema"><div id="t-'.$row['id'].'" class="label error" style="float: right; cursor: pointer;">Eliminar</div><br>'.$row['contenido'].'</div>';
                    $topico .= $this->comentarios($row['id']);
                    setcookie('tema', $row['id'], 0, '/');
                    break;
			    }
			    $enco = true;
			 }
        

			 
		if($enco) {
            return $topico;
        }
        else return -1;	
    	
    	$this->conn->close();
    	
    }
    
     public function foroAlumno(){
    $this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $grupo = explode('-', $_COOKIE['data']);
       $topico = '';  
 	   $enco = false;
 	     	 	
    		$sql = "SELECT * FROM foro WHERE foro.id_gru = ".$grupo[1].' ORDER BY foro.fecha DESC;';
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
                    $topico = '<div id="tema" class="tema"><br>'.$row['contenido'].'</div>';
                    $topico .= $this->comentarios($row['id']);
                    setcookie('tema', $row['id'], 0, '/');
                    break;
			    }
			    $enco = true;
			 }
        

			 
		if($enco) {
            return $topico;
        }
        else return -1;	
    	
    	$this->conn->close();
    	
    }
    
    public function Tema(){
    $this->conn = new Conexion('../../../php/datosServer.php');
		$this->conn = $this->conn->conectar();
 	   $grupo = explode('-', $_COOKIE['data']);
       $topico = '';  
 	   $enco = false;
 	     	 	
    		$sql = "SELECT * FROM foro WHERE foro.id = ".$_COOKIE['tema'];
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
                    $topico = '<div id="tema" class="tema"><div id="t-'.$row['id'].'" class="label error" style="float: right; cursor: pointer;">Eliminar</div><br>'.$row['contenido'].'</div>';
                    $topico .= $this->comentarios($row['id']);
                    break;
			    }
			    $enco = true;
			 }
        

			 
		if($enco) {
            return $topico;
        }
        else return -1;	
    	$this->conn->close();
    	
    }
    
    public function comentarios($p){
        $topico = '<div class="row align-center"><div class="col col-10"><div id="cometarios">';  
 	   $enco = false;
 	     	 	
    		$sql = "SELECT foro.id, foro_msj.msj, foro_msj.fecha, alumnos.nombre, alumnos.foto FROM foro INNER JOIN foro_msj ON foro.id = foro_msj.id_foro LEFT JOIN alumnos ON foro_msj.user = alumnos.noc WHERE foro.id = ".$p;
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
                    if(!empty($row['nombre'])){
                        $topico .= '<div class="comentario"><span class="desc">'.$row['nombre'].'</span>: ';
                    }else{
                        $topico .= '<div class="comentario"><span class="desc">Profesor</span>: ';
                    }
                    $topico .= $row['msj'];
                    $topico .= '<br><div style="text-align: right;" class="desc">'.$row['fecha'].'</div></div>';
			    }
			    $enco = true;
			 }
        

			 
		if($enco) {
            return $topico.'</div></div></div>';
        }
        else return '';
    }
    
    public function Paginacion(){
        $this->conn = new Conexion('../../../php/datosServer.php');
        $this->conn = $this->conn->conectar();
 	   $grupo = explode('-', $_COOKIE['data']);
 	   $temas = '';
 	   $tema = 1;
        
        $sql = "SELECT foro.id FROM foro WHERE foro.id_gru = ".$grupo[1].' ORDER BY foro.fecha DESC;';
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			    	$temas .= '<li><a href="t-'.$row['id'].'">'.$tema.'</a></li>';
                    $tema++;
			    }
			    $enco = true;
			 }
        
        if($enco) echo $temas;
    	$this->conn->close();
    }
}