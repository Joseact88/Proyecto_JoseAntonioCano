<?php
require_once "../../miAutoLoader.php";
Sesion::iniciar();
if(!Sesion::existe('usuario'))
{
    header("Location: ../../loginInfo.php");
}
Sesion::eliminar('usuario');
Sesion::destruir();
header("Location: ../formularios/loginForm.php");
