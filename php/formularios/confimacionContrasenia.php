<?php
require_once "../../miAutoLoader.php";
Sesion::iniciar();
GBD::abreConexion();
if(isset($_GET['idAltaPorConfirmar']))
{
    $idAltaPorConfirmar=$_GET['idAltaPorConfirmar'];
    $idUsuario=GBD::leeAltaPorConfirmar($idAltaPorConfirmar);
    $nombreUsuario=GBD::leeNombreUsuario($idUsuario);
    if($idUsuario==null)
    {
        echo "Ese usuario no está por confirmar.";
    }else{
    //Vemos si hay un envío del formulario
        if(isset($_POST['aceptar']))
        {
            //Comprobamos que ningún campo esté vacío
            $validaciones=new Validacion();
            //Comprobamos que ningún campo esté vacío
            $validaciones->Requerido('contrasenia');
            $validaciones->Requerido('contraseniaConf');
            if(count($validaciones->errores)==0)
            {
                if($_POST['contrasenia']==$_POST['contraseniaConf'])
                {
                    $nombreUsuario=$_POST['usuario'];
                    $contrasenia=$_POST['contrasenia'];
                    $contraseniaConf=$_POST['contraseniaConf'];
                    GBD::cambiaContrasenia($contrasenia, $nombreUsuario, $idUsuario);
                    Sesion::iniciar();
                    Sesion::escribir('usuario', GBD::leeUsuario($nombreUsuario,md5($contrasenia)));
                    GBD::eliminaAltaConfirmar($idAltaPorConfirmar);
                    header('Location: ../tablas/examenes.php');
                }
            }
        }
    }
}else{
    header("Location:loginForm.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña</title>
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
</head>
<body>
    <form action="" method="post" enctype='multipart/form-data' id="form1">
        <h1>Restablecer contraseña</h1>
        <label>Nombre de usuario:</label><input type="text" name="usuario" value="<?php echo $nombreUsuario?>">
        <label>Contraseña:</label><input type="password" name="contrasenia">
        <label>Confirmar contraseña:</label><input type="password" name="contraseniaConf"> <br>
        <p class="contenedorBoton"><input type="submit" name="aceptar" value="Aceptar" id="aceptar"></p>
    </form>
</body>
</html>