<?php
require_once "../../miAutoLoader.php";
GBD::abreConexion();
if(isset($_POST['aceptar']))
{
    //Comprobamos que ningún campo esté vacío
    $validaciones=new Validacion();
    //Comprobamos que ningún campo esté vacío
    $validaciones->Requerido('correo');
    $validaciones->Email('correo');
    if(count($validaciones->errores)==0)
    {
        $correo=$_POST['correo'];
        $usuario=GBD::existeCorreo($correo);
        $idAltaPorConfirmar=md5(libreria::generaContasenya());
        GBD::insertaAltaPorConfirmar($idAltaPorConfirmar,$usuario->idUsuario);
        $enlace="<a href='http://localhost/Proyecto_JoseAntonioCano/php/formularios/confimacionContrasenia.php?idAltaPorConfirmar=$idAltaPorConfirmar'>Restablecer Contraseña</a>";
        Libreria::enviaEmail('Escribe la contraseña',$correo,$usuario->nombre,"Porfavor cambie la contraseña en el siguiente enlace:<br>$enlace");
    }
}
/*if(isset($_GET['idAltaPorConfirmar']))
{
    $idAltaPorConfirmar=$_GET['idAltaPorConfirmar'];
    $idUsuario=GBD::leeAltaPorConfirmar($idAltaPorConfirmar);
    $nombreUsuario=GBD::leeNombreUsuario($idUsuario);
    if($idUsuario==null)
    {
        echo "Ese usuario no está por confirmar.";
    }else{
    //Vemos si hay un envío del formulario
        
    }
}else{
    header("Location:loginForm.php");
}*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación contraseña</title>
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
</head>
<body>
    <form action="" method="post" enctype='multipart/form-data' id="form1">
        <h1>¿Has olvidado tu contraseña?</h1>
        <label>Correo electrónico:</label><input type="text" name="correo">
        <p class="contenedorBoton"><input type="submit" name="aceptar" value="Aceptar" id="aceptar"></p>
    </form>
</body>
</html>