<?php
require_once "../../miAutoLoader.php";
GBD::abreConexion();
$validaciones = new Validacion();
Sesion::iniciar();
$nombreUsuarioCookie="";
$password="";
$checked="";
if(isset($_COOKIE['recuerdame']))
{
    $cookieRecuerdame=json_decode($_COOKIE['recuerdame']);
    $nombreUsuarioCookie=$cookieRecuerdame[0];
    $password=$cookieRecuerdame[1];
    $checked="checked";
}
if(isset($_POST['login']))
{
    //Comprobamos si el nombre o la contraseña están vacíos
    $validaciones->Requerido('usuario');
    $validaciones->Requerido('password');
    if(count($validaciones->errores)==0)
    {
        $usuarioNombre = $_POST['usuario'];
        //Comprobamos si existe el check recordar
        if(isset($_POST['recordar']))
        {
            $recordar=true;
        }
        else
        {
            $recordar=false;
        }
        if(!isset($_COOKIE['recuerdame']))
        {
            $password=md5($_POST['password']);
        }
        Login::identificaUsuario($usuarioNombre,$password,$recordar);
        // Si el usuario es identificado se crea la variable de sesion login
        if(Login::estaLogueado())
        {
            $usuario=GBD::leeUsuario($usuarioNombre,$password);
            // Creamos la variable de sesion usuario de tipo User
            // Redirigimos a la lista de sus datos
            Sesion::escribir('usuario', $usuario);
            header("Location: prueba.php");                    
        }
        else
        {
            echo "El usuario o la contraseña no son correctos.";
        }
    }
} 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../css/main.css">
</head>
<body>
    <form action="loginForm.php" method="POST" class="login">
        <h1>Autoescuela Jositos</h1>
        <div class="inset">
            <label class="formulario">Usuario</label><input type="text" name="usuario" maxlength="45" value="<?php echo $nombreUsuarioCookie?>" class="formulario">
            <label class="formulario">Contraseña</label><input type="password" name="password" maxlength="45" value="<?php echo $password?>" class="formulario">
            <p>
                <input type="checkbox" name="recordar" id="recordar" checked="<?php $checked?>">
                <label for="recordar" class="formulario recordar">Recuérdame 30 días</label>
            </p>
        </div>
        <p class="contenedorBoton login">
            <a>¿Has olvidado la contraseña?</a>
            <input type="submit" name="login" value="Aceptar">
        </p>
    </form>
</body>
</html>