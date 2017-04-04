<?php
//Se inicia sesión para validar que el usuario siga siendo el mismo y no entre otro más.
    session_start();
    if(!isset($_SESSION['admin'])){ //En caso de que no variable de sesión, redireciona.
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
<title>Administrador</title>
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


	<div class="row align-right" >
    <div class="col col-4">
    	<div id="navbar-demo" data-component="sticky">
    <nav id="menu">
        <ul>
            <li><a href=""  data-component="dropdown" data-target="#carreras">Carreras</a></li>
            <li>
               <a href=""  data-component="dropdown" data-target="#materias">Materias</a>
            </li>
            <li><a href=""  data-component="dropdown" data-target="#personal">Personal</a></li>
            <li><a href=""  data-component="dropdown" data-target="#grupos">Grupos</a></li>
            <li><a href=""  data-component="dropdown" data-target="#cuenta">Cuenta</a></li>
        </ul>
	    </nav>
	</div>

<div id="opciones">
<div class="dropdown hide" id="carreras">
    <ul>
        <li><a id="agregar" href="">Altas</a></li>
        <li><a id="catalogo" href="">Catálogo</a></li>
    </ul>
</div>

<div class="dropdown hide" id="materias">
    <ul>
        <li><a id="agregar" href="">Altas</a></li>
        <li><a id="editar" href="">Editar</a></li>
        <li><a id="catalogo" href="">Catálogo</a></li>
    </ul>
</div>

<div class="dropdown hide" id="personal">
    <ul>
        <li><a id="agregar" href="">Altas</a></li>
        <li><a id="editar" href="">Catalogo</a></li>
        <li><a href="">Cambiar contraseña</a></li>
    </ul>
</div>

<div class="dropdown hide" id="grupos">
    <ul>
        <li><a id="agregar" href="">Asignar</a></li>
        <li><a href="">Eliminar</a></li>
        <li><a id="catalogo" href="">Catálogo</a></li>
    </ul>
</div>


<div class="dropdown hide" id="cuenta">
    <ul>
        <li><a href="">Cambiar contraseña</a></li>
        <li><a href="@">Cerrar Sesión</a></li>
    </ul>
</div>

</div>
</div>

</div>

<section id="pizarra">
	<div class="row">
    <div class="col col-2"></div>
    <div class="col col-8" id="contenido"><img src="../../img/logobg.png" alt=""></div>
    <div class="col col-2"></div>
	</div>
</section>

<!-- librerias -->
<?php
include('../includes/footers.php');
?>
	 <script src="../js/administrador.js"></script>
</body>
</html>