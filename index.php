<?php
session_start();
	if(isset($_SESSION['alumno'])){ //En caso de que no variable de sesión, redireciona.
    header("location: panel/alumno/");
    }
    
    if(isset($_SESSION['profesor'])){ 
    header("location: panel/profesor/");
    }
    
    if(isset($_SESSION['coordinador'])){ 
    header("location: panel/coordinador/");
    }
    
    if(isset($_SESSION['admin'])){ 
    header("location: panel/administrador/");
    } 
?> 
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="description" content="Educación Semipresencial">
<meta name="keywords" content="ITMorelia,Educación,Semipresencial,Blended Learning">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ITMorelia</title>
<!-- CSS -->
   <link rel="stylesheet" href="css/kube.css">
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/tipso.min.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/alertify.css">
</head>
<body class="animated fadeIn">

<header class="header-line">
	<div class="row">
		<div class="col col-4">
			<img src="img/img-sep-000000.png" alt="SEP">
		</div>
		<div class="col col-4 header-txt">
		<div>Tecnológico Nacional de México</div><br>
		Instituto Tecnológico de Morelia
		</div>
		<div class="col col-4">
		<img src="img/img-tec-000000.png" alt="SEP">
		</div>	
	</div>
</header>

<div class="row align-center">
	<div class="col col-4">
	<div class="titulo">Cursos Académicos Semipresenciales de los Institutos Tecnológicos</div>	
	</div>
</div>
<section class="btn-login" >
	<div class="row align-center">
    <div class="col col-2" >
    	<img src="img/logoc.png" alt="Cursos Académicos Semipresenciales de los Intitutos Tecnológicos">
    </div>
	</div>
</section>

<section class="btn-login">
	<div class="row align-center">
    <div class="col col-1" >
    	<button class="button big round inverted" data-component="modal" data-target="#student">Ingresar</button>
    </div>
	</div>
</section>

<footer class="footer">
	<div class="row">
		<div class="col col-4">Redes Sociales</div>	
		<div class="col col-4 offset-4">Contacto</div>
	</div>
</footer>

<div id="student" class="modal-box hide animated fadeIn">
    <div class="modal gradient">
        <span class="close"></span>
        <div class="modal-header"><i class="fa fa-id-card fa-lg"></i> Estudiante</div>
        <div class="modal-body">
        		<div class="row align-center">
        		<div class="col">
					<form id="student">
						<div class="form-item">
					        <label><i class="fa fa-user fa-lg"></i> No. Control</label>
					        <input type="text" name="user" >
					    </div>
					    <div class="form-item">
					        <label><i class="fa fa-lock fa-lg"></i> Contraseña</label>
					        <input type="password" name="pass" >
					    </div>
					    <div class="form-item">
					        <button id="login">Ingresar</button>
					        <button id="cancel" class="button secondary">Cancelar</button>
					    </div>			
					</form>
				</div>
				</div>
				<div id="msj"></div>        
        </div>
    </div>
</div>


<!-- librerias -->
    <script src="js/jquery.min.js"></script>
    <script src="js/kube.js"></script>
    <script src="js/tipso.min.js"></script>
    <script src="js/alertify.js"></script>
    <script src="js/js.cookie.js"></script> 
	 <script src="js/scripts.js"></script>
</body>
</html>