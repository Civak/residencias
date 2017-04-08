<?php
//Se inicia sesión para validar que el usuario siga siendo el mismo y no entre otro más.
    session_start();
    if(!isset($_SESSION['alumno'])){ //En caso de que no variable de sesión, redireciona.
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
include('../php/alumno-info.php');
$obj = new Alumno();
?>
<nav id="menu-profe">
	<div class="row align-right menu-row">

	<div class="col col-2 offset-2">
            <ul id="direct">
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
    <ul>
    	  <li><a id="ed-per" href="#">Editar perfil</a></li>
        <li><a id="cam-pas" href="#">Cambiar contraseña</a></li>
        <li><a href="#">Cerrar sesión</a></li>
    </ul>
</div>

</div>

<section id="pizarra">
	<div class="row gutters">
    <div class="col col-2" id="info-grupos" >
    
		<div class="paneles shadow">
		<p> <img src="../../img/groups.jpg" alt="Mis Grupos"> Mis Cursos</p>
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
    <div class="col col-8 contenido shadow" id="contenido"  ><img src="../../img/logobg.png" alt=""></div>
    <div class="col col-2" >
        <div class="paneles shadow">
            <p> <img src="../../img/email.png" alt="Mis Mensajes"> Mis Mensajes</p>
            <div id="mensajes">
            <div id="bandeja" style="font-size:14px;">
                <ul id="bandeja">
                <li><a id="msj-piz" href="#">Pizarra</a></li>
                    <li><a id="msj-rec" href="#">Mensajes Recibidos <span style="font-size:10px;" class="label badge focus small">
                    <div id="mis-msj">
                    <?php
                    $obj->misMsj();
                    ?>
                    </div>
                    </span></a></li>
                      <li><a id="msj-env" href="#">Mensajes Enviados</a></li>
                    <li><a id="msj-pro" href="#">Enviar Mensaje</a></li>
                </ul>
            </div>
            </div>
        </div>
    </div>
	</div>
</section>
<a href="#" class="scrollToTop"><i class="fa fa-arrow-up fa-2x"></i></a>

<div id="tareas-info" class="modal-box hide"><div class="modal">
    <span class="close"></span>
    <div class="modal-header"><i class="fa fa-clipboard fa-lg"></i> Tarea</div>
    <div class="modal-body"></div>
</div></div>
<div id="tareas-entre" class="modal-box hide"><div class="modal">
    <span class="close"></span>
    <div class="modal-header"><i class="fa fa-clipboard fa-lg"></i> Detalles de Tarea</div>
    <div class="modal-body"></div>
</div></div>
<!-- librerias -->
<?php
include('../includes/footers.php');
?>
	<script src="../js/jquery.easyeditor.js"></script>
	<script src="../js/Intimidatetime.min.js"></script>
	<script src="../js/jquery.ezdz.js"></script>
	 <script src="../js/alumno.js"></script>
</body>
</html>