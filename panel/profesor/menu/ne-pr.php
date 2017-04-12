<?php
    for($i = 1; $i <= intval($_COOKIE['preguntas']);$i++){
        echo '<div class="col col-5">
    <br><input type="text" placeholder="Pregunta '.$i.'" name="p-'.$i.'"><input type="text" class="w25" placeholder="Valor" name="v-'.$i.'"><br>
    <div class="row">
        <div class="col col-1"><br>
        <div class="form-item">
            <label class="checkbox"><input type="radio" name="p-'.$i.'-r" value="1" checked></label><br>
            <label class="checkbox"><input type="radio" name="p-'.$i.'-r" value="2"></label><br>
            <label class="checkbox"><input type="radio" name="p-'.$i.'-r" value="3"></label>
        </div>
        </div>
        <div class="col col-11">Respuestas:
            <input type="text"  name="p-'.$i.'-a">
            <input type="text"  name="p-'.$i.'-b">
            <input type="text"  name="p-'.$i.'-c">
        </div>
    </div>
</div>';
    }

if(intval($_COOKIE['preguntas']) % 2 == 0){
    echo '<div class="col col-5">
<button class="button secondary small  animated fadeIn" id="elim-examen">Eliminar Examen</button>
<button class="button  animated small fadeIn" id="guardar">Guardar Examen</button>
</div>';
}
else{
    echo '<br><div class="col col-5"></div><div class="col col-5">
<button class="button secondary small  animated fadeIn" id="elim-examen">Eliminar Examen</button>
<button class="button  animated small fadeIn" id="guardar">Guardar Examen</button>
</div>';
}
?>


