<?php
require_once "../../miAutoLoader.php";
Sesion::iniciar();
GBD::abreConexion();
if(!Sesion::existe('usuario'))
{
    header("Location: loginForm.php");
}
$usuario=Sesion::leer('usuario');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
</head>
<body>
    <?php 
        require "../../header.php";
    ?>
    <h1>FELICIDADES</h1>
    <form action="../Login/logOff.php" method="POST">
        <input type="submit" value="Cerrar Sesion" name="destruir">
    </form>
    <a href="altaUsuarios.php"></a>
</body>
    <?php 
        require "../../footer.php";
    ?>
</html>