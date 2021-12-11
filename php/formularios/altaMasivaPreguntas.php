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
    $validaciones->Requerido('textPreguntas');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Masiva Preguntas</title>
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
    <script src="../../js/altaMasiva.js"></script>
</head>
<body>
    <?php 
        require "../../header.php";
    ?>
    <form action="altaMasivaPreguntas.php" method="post" id="altaMasivaPreguntas">
        <h1>Alta Masiva de Preguntas</h1>
        <label>Alta Masiva Preguntas</label><textarea name="textPreguntas" id="textPreguntas" rows="25" cols="100" required></textarea>
        <input type="file" name="csv" id="csv">
        <p class="contenedorBoton"><input type="submit" name="aceptar" value="Aceptar" id="aceptar"></p>
    </form>
    <?php 
        require "../../footer.php";
    ?>
</body>
</html>