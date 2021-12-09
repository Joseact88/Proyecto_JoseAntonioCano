<header id="main">
<link href="../../scss/vendors/fontawesome-free-5.15.4-web/css/all.css" rel="stylesheet">
<?php
    $usuario=Sesion::leer('usuario');
    if($usuario->idRol==1)
    {
?>
<!--Menú para profesores-->
<nav>
    <ul>
        <li class="menu">
            <img  src="../../img/pandaCar.png" alt="No se ha podido encontrar la imgen..." width="30" height="30">
        </li>
        <li class="menu">
            <a href="#">Examenes</a>
            <ul class="submenu">
                <li><a href="#">Alta Examenes</a></li>
                <li><a href="#">Histórico</a></li>
            </ul>
        </li>
        <li class="menu">
            <a href="#">Preguntas</a>
            <ul class="submenu">
                <li><a href="#">Preguntas</a></li>
                <li><a href="#">Preguntas</a></li>
            </ul>
        </li>
        <li class="menu">
            <a href="#">Temáticas</a>
            <ul class="submenu">
                <li><a href="#">Alta Temáticas</a></li>
                <li><a href="#">Alta Masiva Temáticas</a></li>
            </ul>
        </li>
        <li class="menu">
            <a href="#">Usuarios</a>
            <ul class="submenu">
                <li><a href="#">Alta Usuarios</a></li>
                <li><a href="#">Alta Masiva Usuarios</a></li>
            </ul>
        </li>
    </ul>
</nav>
<?php
    }else{
?>
<!--Menú para alumnos-->
<nav>
    <ul>
        <li class="menu">
            <a href="#">Histórico de examenes</a>
        </li>
        <li class="menu">
            <a href="#">Examen Predefinido</a>
        </li>
        <li class="menu">
            <a href="#">Examen Aleatorio</a>
        </li>
    </ul>
</nav>
<?php
    }
?>
</header>