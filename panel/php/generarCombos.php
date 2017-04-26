<?php
include('../../../php/conexion.php');

class GenerarCombos
{
    /// Atributos globales. 
    private $conn;
    
    
    // --- Genera combo de (carreras)
    public function generarComboCarreras() {
        $this->conn = new Conexion('../../../php/datosServer.php');
		  $this->conn = $this->conn->conectar();
		  
        $combo = "";
        $sql = "SELECT * FROM carreras;";
        $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
						$combo .= '<option value="'.$row['id'].'">'.$row['carrera'].'</option>';
                }
            }
            echo $combo;
            $this->conn->close();
    	}
    	
    	    public function generarCheckBoxCarreras($tipo) {
        $this->conn = new Conexion('../../../php/datosServer.php');
		  $this->conn = $this->conn->conectar();
        $combo = "";
        $sql = "SELECT * FROM carreras;";
        $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
						$combo .= '<label><input type="checkbox" id="'.$tipo.'" name="'.$row['id'].'-'.$tipo.'" value="'.$row['id'].'">'.$row['carrera'].'</label>';
                }
            }
            echo $combo;
            $this->conn->close();
    	}
    	
    		/// Obtiene carreras
    public function obtenerCarreras($conn) {
        $carreras = array();
        $sql = "SELECT * FROM carreras;";
        $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
						array_push($carreras, $row['id']);
                }
            }
            return $carreras;
    	}
    	/// Obtiene la carrera del profesor a editar
    public function generarComboCarrerasEdit($carrera) {
        $this->conn = new Conexion('../../../php/datosServer.php');
        $this->conn = $this->conn->conectar();
        $combo = "";
        $sql = "SELECT * FROM carreras;";
        $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                if(strcmp($carrera, $row['id']) !== 0)
						$combo .= '<option value="'.$row['id'].'">'.$row['carrera'].'</option>';
					 else $combo .= '<option value="'.$row['id'].'" selected>'.$row['carrera'].'</option>';
                }
            }
            echo $combo;
            $this->conn->close();
    	}
    	
    /// Genera check boxes para editar o actualizar profesor
    public function generarCheckBoxCarrerasTutCor($tipo, $str) {
        $this->conn = new Conexion('../../../php/datosServer.php');
		  $this->conn = $this->conn->conectar();
        $combo = "";
        $sql = "SELECT * FROM carreras;";
        $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
						if (strpos($str, $row['id']) !== FALSE) $combo .= '<label><input type="checkbox" id="'.$tipo.'" name="'.$row['id'].'-'.$tipo.'" value="'.$row['id'].'" checked>'.$row['carrera'].'</label>';
						else $combo .= '<label><input type="checkbox" id="'.$tipo.'" name="'.$row['id'].'-'.$tipo.'" value="'.$row['id'].'">'.$row['carrera'].'</label>';                
                }
            }
            echo $combo;
            $this->conn->close();
    	}
}
?>