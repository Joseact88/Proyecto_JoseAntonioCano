<?php
require_once "../../miAutoLoader.php";
Sesion::iniciar();
GBD::abreConexion();
if(!Sesion::existe('usuario'))
{
    header("Location: loginForm.php");
}
$usuario=Sesion::leer('usuario');
//Comprobamos si ha habido un envío del formulario
if(isset($_POST['aceptar']))
{
    $validaciones=new Validacion();
    //Comprobamos que los campos no estén vacíos
    $validaciones->Requerido('nombre');
    $validaciones->Requerido('correo');
    $validaciones->Email('correo');
    $validaciones->Requerido('apellidos');
    $validaciones->Requerido('fechaNac');
    $validaciones->Requerido('rol');
    if(count($validaciones->errores)==0)
    {
        //Comprobamos los datos enviados
        $nombre=$_POST['nombre'];
        $correo=$_POST['correo'];
        $apellidos=$_POST['apellidos'];
        $fechaNac=$_POST['fechaNac'];
        $rol=$_POST['rol'];
        //Creamos el usuario
        $usuario=new Usuario($nombre,$apellidos, libreria::generaContasenya(), $fechaNac, $rol, 1, $correo);
        //Grabamos el usuario
        GBD::grabaUsuario($usuario);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta usuarios</title>
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
</head>
<body>
    <?php 
        require "../../header.php";
    ?>
    <form action="altaUsuarios.php" method="post">
        <h1>Alta Usuario</h1>
        <label>Nombre de usuario:</label><input type="text" name="nombre" id="nombre" maxlength="45" required>
        <label>Correo:</label><input type="text" name="correo" id="correo" maxlength="45" required>
        <label>Apellidos:</label><input type="text" name="apellidos" id="apellidos" maxlength="45" required>
        <label>Fecha de nacimiento:</label><input type="date" name="fechaNac" id="fechaNac" required>
        <label>Rol:</label><select name="rol" id="rol">
                <option value='-1' selected>Sin Seleccionar</option>
            <?php 
                $roles=array();
                $roles=GBD::leeListaRoles();
                for ($i=0;$i<count($roles);$i++)
                {
                    echo "<option value='".$roles[$i]->idRol."'>".$roles[$i]->nombre."</option>";
                }
            ?>
        </select>
        <p class="contenedorBoton"><input type="submit" name="aceptar" value="Aceptar" id="aceptar"></p>
    </form>
</body>
    <?php 
        require "../../footer.php";
    ?>
</html>