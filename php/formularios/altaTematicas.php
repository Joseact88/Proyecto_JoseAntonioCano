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
    $validaciones=new Validacion();
    //Comprobamos que ningún campo esté vacío
    $validaciones->Requerido('descripcion');
    if(count($validaciones->errores)==0)
    {
        $descripcion=$_POST['descripcion'];
        //Creamos la temática
        $tematica=new Tematica($descripcion);
        //Grabamos la tematica
        GBD::grabaTematica($tematica);
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

    <form action="altaTematicas.php" method="post">
        <h1>Alta Temática</h1>
        <label>Descripcion:</label><input type="text" name="descripcion" id="descripcion" required maxlength="45">
        <p class="contenedorBoton"><input type="submit" name="aceptar" value="Aceptar" id="aceptar"></p>
    </form>
</body>
    <?php 
        require "../../footer.php";
    ?>
</html>