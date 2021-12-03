<?php
require_once "../../miAutoLoader.php";
Sesion::iniciar();
if(!Sesion::existe('usuario'))
{
    header("Location: ../../loginInfo.php");
}
if(isset($_POST['destruir']))
{
    Sesion::eliminar('usuario');
    Sesion::destruir();
    header("Location: ../formularios/loginForm.php");
}
