<header>
<link href="../../scss/vendors/fontawesome-free-5.15.4-web/css/all.css" rel="stylesheet">
<a href="http://localhost/Proyecto_JoseAntonioCano/php/formularios/loginForm.php"><img src="../../img/logo.png" alt="Ha ocurrido algún error..."></a>
<?php
    $usuario=Sesion::leer('usuario');
    if($usuario->idRol==1)
    {
?>
<!--Menú para profesores-->
<nav class="navegacion">
    <ul class="menu">
        <li><a href="http://localhost/Proyecto_JoseAntonioCano/php/tablas/examenes.php">Examenes</a>
            <ul class="submenu">
                <li><a href="http://localhost/Proyecto_JoseAntonioCano/php/tablas/examenes.php">Histórico Examenes</a></li>
                <li><a href="http://localhost/Proyecto_JoseAntonioCano/php/formularios/altaExamenes.php">Alta Examen</a></li>
            </ul>
        </li>
        <li><a href="http://localhost/Proyecto_JoseAntonioCano/php/tablas/preguntas.php">Preguntas</a>
            <ul class="submenu">
                <li><a href="http://localhost/Proyecto_JoseAntonioCano/php/formularios/altaPreguntas.php">Alta Pregunta</a></li>
            </ul>
        </li>
        <li><a href="http://localhost/Proyecto_JoseAntonioCano/php/tablas/tematicas.php">Temáticas</a>
            <ul class="submenu">
                <li><a href="http://localhost/Proyecto_JoseAntonioCano/php/formularios/altaTematicas.php">Alta Temática</a></li>
                <li><a href="http://localhost/Proyecto_JoseAntonioCano/php/formularios/altaMasivaTematicas.php">Ata Masiva Temáticas</a></li>
            </ul>
        </li>
        <li><a href="http://localhost/Proyecto_JoseAntonioCano/php/tablas/usuarios.php">Usuarios</a>
            <ul class="submenu">
                <li><a href="http://localhost/Proyecto_JoseAntonioCano/php/formularios/altaUsuarios.php">Alta Usuario</a></li>
                <li><a href="http://localhost/Proyecto_JoseAntonioCano/php/formularios/altaMasivaUsuarios.php">Ata Masiva Usuarios</a></li>
            </ul>
        </li>
    </ul>
</nav>
<?php
    }else{
?>
<!--Menú para alumnos-->
<nav class="navegacion">
    <ul class="menu">
        <li><a href="http://localhost/Proyecto_JoseAntonioCano/php/tablas/examenes.php">Histórico Examenes</a></li>
        <li><a href="#">Examenes</a></li>
        <li><a href="#">Examen Aleatorio</a></li>
    </ul>
</nav>
<?php
    }
?>
<a href="../Login/logOff.php"><button class="fas fa-sign-out-alt cabecera" id="usuarioExit"></button></a>
<a href="http://localhost/Proyecto_JoseAntonioCano/php/formularios/altaUsuarios.php"><button class="far fa-user cabecera" id="usuarioModi"></button></a>
</header>