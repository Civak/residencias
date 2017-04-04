<?php
//Se inicia sesión para validar que el usuario siga siendo el mismo y no entre otro más.
    session_start();
    if(!isset($_SESSION['profesor'])){ //En caso de que no variable de sesión, redireciona.
    header("location: ../../");
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="description" content="Educación Semipresencial">
<meta name="keywords" content="ITMorelia,Educación,Semipresencial,Blended Learning">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $_COOKIE['info']; ?></title>
<!-- CSS -->
<?php
include('../includes/headers.php');
?>
</head>
<body class="animated fadeIn">

<header class="header-line">
	<div class="row">
		<div class="col col-4">
			<img src="../../img/img-sep-000000.png" alt="SEP">
		</div>
		<div class="col col-4 header-txt">
		<div>Tecnológico Nacional de México</div><br>
		Instituto Tecnológico de Morelia
		</div>
		<div class="col col-4">
		<img src="../../img/img-tec-000000.png" alt="SEP">
		</div>	
	</div>
</header>
<?php
include('../php/profesor-info.php');
$obj = new Profesor();
?>
<nav id="menu-profe">
	<div class="row menu-row">
    <div class="col col-4">

    
        <ul>
            <li><a href="."><i id="tipso" data-tipso="Recargar página" class="fa fa-home fa-2x"></i></a></li>
        </ul>
	    
		</div>
	<div class="col col-4">

        <form class="form">
		    <div class="form-item">
		        <input type="text" class="search small">
		    </div>
		</form>
	</div>
	
	<div class="col col-2 offset-2">

        <ul id="direct">
            <!-- <li><a href=""><i id="tipso" data-tipso="Programar examen" class="fa fa-paste fa-2x"></i></a></li> -->
            <li><a href=""><i  data-component="dropdown" data-target="#bandeja" class="fa fa-envelope fa-2x"></i></a></li>
            <li><a id="foto"  data-component="dropdown" data-target="#perfil" href="">
					<?php
		            $obj->fotoPerfil();
		            ?>            
            </a></li>
        </ul>
	</div>
	
	</div>
</nav>
<div id="opciones">
<div class="dropdown hide" id="perfil">
    <ul id="perfil">
    	  <li><a id="ed-per" href="#">Editar perfil</a></li>
        <li><a id="ed-pas" href="#">Cambiar contraseña</a></li>
        <li><a href="#">Cerrar sesión</a></li>
    </ul>
</div>
</div>
<div id="mensajes">
<div class="dropdown hide" id="bandeja">
    <ul id="bandeja">
    	  <li><a id="msj-ban" href="#">Bandeja de Entrada</a></li>
        <li><a id="msj-alu" href="#">Enviar Mensaje Alumno</a></li>
        <li><a id="msj-gru" href="#">Enviar Mensaje Grupo</a></li>
    </ul>
</div>
</div>
<br>
<section id="pizarra">
	<div class="row gutters">
    <div class="col col-2" id="info-grupos" >
    
		<div class="paneles shadow">
		<p> <img src="../../img/groups.jpg" alt="Mis Grupos"> Mis Grupos</p>
		            <?php
		            $obj->misGrupos();
		            ?>

 		</div>
 		
 		<div class="paneles shadow">
		<p> <img src="../../img/task.png" alt="Tareas Pendientes"> Tareas Pendientes</p>
		<div class="tareas-p">
			 			<?php
		            $obj->tareasPendientes();
		            ?>
		</div>
 		</div>
    </div>
    <div class="col col-8 contenido shadow" id="contenido"  ><img src="../../img/logoc.png" alt=""><div class="titulo2">Cursos Académicos Semipresenciales de los Institutos Tecnológicos</div></div>
    <div class="col col-2 contenido shadow" >Mensajes, Bandeja, Usuarios</div>
	</div>
</section>
<a href="#" class="scrollToTop"><i class="fa fa-arrow-up fa-2x"></i></a>

<div id="tareas-info" class="modal-box hide"><div class="modal">
        <span class="close"></span>
        <div class="modal-header"><i class="fa fa-clipboard fa-lg"></i> Tarea</div>
        <div class="modal-body"></div>
    </div></div>

<!-- librerias -->
<?php
include('../includes/footers.php');
?>
	<script src="../js/jquery.easyeditor.js"></script>
	<script src="../js/Intimidatetime.min.js"></script>
	<script src="../js/jquery.ezdz.js"></script>
	 <script src="../js/profesor.js"></script>
</body>
</html>