<!-- Modal -->
<div class="animated fadeIn">
<div class="modal-header gradient"><i class='fa fa-list fa-lg'></i> Tareas Entregadas Grupo: <span class="label focus">
	<?php $datos = explode('-', $_COOKIE['data']); echo $datos[0]; ?>
</span></div><br>
    <div class="row">
        <div class="col col-1"></div>
        <div class="col col-2">
            <a href="#" id="back"><span class="label badge focus"><i class="fa fa-arrow-left fa-2x"></i></span></a>
        </div>
    </div><hr>
	<div class="row align-center">
		<div class="col col-8 temario">
				<?php 
					include('../../php/consultar-ediciones.php');
					$obj = new Ediciones();
					$obj->listaTareas();
				?>
		</div>
	</div>
</div>
<div id="calf-tarea" class="modal-box hide"><div class="modal">
    <span class="close"></span>
    <div class="modal-header"><i class="fa fa-clipboard fa-lg"></i> Detalles de Tarea</div>
    <div class="modal-body"></div>
</div></div>
<script>
$(document).ready(function(){
    $('a#back').on('click', function(e){
        e.preventDefault();
        $('div#contenido').load('menu/re-ta.php');
    });
    $('div#lis-tar').on('click','a', function(e){
        e.preventDefault();
        var quien = $(this).attr('href');
        Cookies.set('tar',quien);
        $('div#calf-tarea').find('div.modal-body').load('menu/ca-tar.php');
    });
});
</script>

