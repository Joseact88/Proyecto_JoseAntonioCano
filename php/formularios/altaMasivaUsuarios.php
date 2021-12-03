<?php
require_once "../../miAutoLoader.php";
Sesion::iniciar();
GBD::abreConexion();
//Comprobamos que exista una sesión
if(!Sesion::existe('usuario'))
{
    header("Location: loginForm.php");
}
//Vemos si hay un envío del formulario
if(isset($_POST['aceptar']))
{
    //Comprobamos que ningún campo esté vacío
    $validaciones=new Validacion();
    //Comprobamos que ningún campo esté vacío
    $validaciones->Requerido('textUsuarios');
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Masiva Usuarios</title>
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
</head>
<body>

    <form action="altaMasivaUsuarios.php" method="post" id="altaMasivaUsuarios">
        <h1>Alta Masiva de Usuarios</h1>
        <textarea name="textUsuarios" id="textUsuarios" rows="25" cols="100" required></textarea>
        <p class="contenedorBoton"><input type="submit" name="aceptar" value="Aceptar"></p>
    </form>
</body>
</html>