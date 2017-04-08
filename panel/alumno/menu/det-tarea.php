<div class="animated fadeIn">
<?php
session_start();
include('../../php/consultar-ediciones.php');
$datos = explode('-', $_COOKIE['data']);

$obj = new Ediciones();
$info = $obj->consultarTareaAlum($datos[1],$_SESSION['alumno']);

$fec = '<span class="label tag success">Fecha Asignada: '.$info[1].'</span>&nbsp;<span class="label tag error"> Fecha Límite: '.$info[2].'</span>';

echo '<b>'.$info[3]."</b><br>".$fec."<hr>";
echo $info[4]."<br><br>";
echo $info[0];

echo '<hr><span class="label focus">Fecha de Envio: '.$info[5].'</span><br>';
echo '<div class="info"><i class="fa fa-file"></i> <b>Contenido:</b><br> '.$info[8].'</div><br>';
    
    if(empty($info[6])) echo '<div class="info">Sin observaciones...</div>';
    else echo '<div class="info"><b>Observaciones:</b><br>'.$info[6].'</div>';
    
    if(empty($info[7])) echo '<div class="label warning">Sin calificación</div>';
    else echo '<div class="label success">Calificación: '.$info[7].'</div>';

setcookie('data', $datos[0].'-'.$datos[1], 0, "/");
?>
<br>
<a style="float: right;" class="label focus upper" href="#" data-action="modal-close">Cerrar</a>
</div>