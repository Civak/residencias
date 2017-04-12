<div class="animated fadeIn">
<?php
include('../../php/consultar-ediciones.php');
$datos = explode('-', $_COOKIE['tar']);

$obj = new Ediciones();
$info = $obj->tareaAlumno($datos[2],$datos[1]);

$fec = '<span class="label tag success">Fecha Asignada: '.$info[1].'</span>&nbsp;<span class="label tag error"> Fecha Límite: '.$info[2].'</span>';

echo '<b>'.$info[3]."</b><br>".$fec."<hr>";
echo $info[4]."<br><br>";
echo $info[0];
echo '<br><hr><span class="label focus">Fecha de Envio: '.$info[6].'</span><br>';
echo '<div class="temario">Contenido:<br>'.$info[5].'</div><br>';
echo $info[9].'<br>';

//setcookie('data', $datos[0].'-'.$datos[1], 0, "/");
?>
    <form id="cal-tar">
    <div class="row align-center">
        <div class="col col-10">
            <div class="form-item">Observaciones:
                <textarea id="obser" rows="6">
                    <?php echo $info[7]; ?>
                </textarea>
            </div>
            <div class="form-item">
                <label>Calificación</label>
                <?php echo '<input type="number" name="calif" class="w50" value="'.$info[8].'">'; ?>
            </div>
        </div>
    </div>
        <div class="row align-center">
            <div class="col col-6">
                <div id="msj"></div><br>
            <button class="button w100 animated fadeIn" id="guardar">Guardar</button>
            </div>
        </div>
    </form>
<br>
<a style="float: right;" class="label black upper" href="#" data-action="modal-close">Cerrar</a>
</div>