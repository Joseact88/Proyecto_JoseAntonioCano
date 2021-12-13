<?php
require_once "../../miAutoLoader.php";
Sesion::iniciar();
GBD::abreConexion();
if(!Sesion::existe('usuario'))
{
    header("Location: loginForm.php");
}
$usuario=Sesion::leer('usuario');
$insertado="";
$readonly="";
$oculto="";
//Comprobamos si ha habido un envío del formulario
if(isset($_POST['aceptar']))
{
    if(isset($_GET['mod']))
    {
        $readonly="readonly";
        $oculto="display:none";
    }
    $validaciones=new Validacion();
    //Comprobamos que los campos no estén vacíos
    $validaciones->Requerido('nombre');
    $validaciones->Requerido('correo');
    $validaciones->Email('correo');
    $validaciones->Requerido('apellidos');
    $validaciones->Requerido('fechaNac');
    if(!isset($_GET['mod']))
    {
        $validaciones->Requerido('rol');
    }
    if(count($validaciones->errores)==0)
    {
        //Comprobamos los datos enviados
        $nombre=$_POST['nombre'];
        $correo=$_POST['correo'];
        $apellidos=$_POST['apellidos'];
        $fechaNac=$_POST['fechaNac'];
        if(!isset($_GET['mod']))
        {
            $rol=$_POST['rol'];
            //Creamos el usuario
            $Nusuario=new Usuario($nombre,$apellidos, libreria::generaContasenya(), $fechaNac, $rol, 1, $correo);
            //Grabamos el usuario
            GBD::grabaUsuario($Nusuario);
        }else{
            //Creamos el usuario
            $Musuario=new Usuario($nombre,$apellidos, $usuario->password, $fechaNac, $usuario->idRol, 1, $correo);
            $Musuario->idUsuario=$usuario->idUsuario;
            //Modificamos el usuario
            GBD::modificaUsuario($Musuario);
            header("Location: ../tablas/examenes.php");
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
    <title>Alta usuarios</title>
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
</head>
<body>
    <?php 
        require "../../header.php";
    ?>
    <form action="" method="post">
        <h1>Alta Usuario</h1>
        <label>Nombre de usuario:</label><input type="text" name="nombre" id="nombre" maxlength="45" required <?php $readonly ?>
        value='<?php echo isset($_GET['mod']) ? $usuario->nombre : ""?>'>
        <label>Correo:</label><input type="text" name="correo" id="correo" maxlength="45" required <?php $readonly ?>
        value='<?php echo isset($_GET['mod']) ? $usuario->correo : ""?>'>
        <label>Apellidos:</label><input type="text" name="apellidos" id="apellidos" maxlength="45" required
        value='<?php echo isset($_GET['mod']) ? $usuario->apellidos : ""?>'>
        <label>Fecha de nacimiento:</label><input type="date" name="fechaNac" id="fechaNac" required
        value='<?php echo isset($_GET['mod']) ? $usuario->fechaNac : ""?>'>
        <?php
            if(!isset($_GET['mod']))
            {
        ?>
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
            <?php 
            }
            ?>
        <p class="contenedorBoton"><input type="submit" name="aceptar" value="Aceptar" id="aceptar"></p>
    </form>
</body>
    <?php 
        require "../../footer.php";
    ?>
</html>