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
    	
    	public function obtenerArchivos($str) {
    		$docs = '<div class="docs"><b><i class="fa fa-file-archive-o fa-lg"></i> Documentos:</b><hr>';
    		$files = explode(';', $str);
    		for($i = 0; $i < count($files) - 1;$i++) {
    			$docs .= '<a href="./docs/'.$files[$i].'" download>'.$files[$i].'</a><br>';
    		}
    		
    		return $docs.'</div>';
    	}

}
?>