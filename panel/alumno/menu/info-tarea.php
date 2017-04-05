<div class="animated fadeIn">
<?php
include('../../php/consultar-ediciones.php');
$datos = explode('-', $_COOKIE['data']);

$obj = new Ediciones();
$info = $obj->consultarTarea($datos[1]);

$fec = '<span class="label tag success">Fecha Asignada: '.$info[1].'</span>&nbsp;<span class="label tag error"> Fecha Límite: '.$info[2].'</span>';

echo '<b>'.$info[3]."</b><br>".$fec."<hr>";
echo $info[4]."<br><br>";
echo $info[0];


setcookie('data', $datos[0].'-'.$datos[1], 0, "/");
?>
<br>
<a style="float: right;" class="label focus upper" href="#" data-action="modal-close">Cerrar</a>
</div>