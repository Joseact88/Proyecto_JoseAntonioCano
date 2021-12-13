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
    //Creamos el array de la cadena dividida
    $lineasCadena=[];
    $partesCadena=[];
    if(count($validaciones->errores)==0)
    {
        //Separamos el valor del textarea en lineas
        $lineasCadena=explode("\n",$_POST['textUsuarios']);
        //Recorremos las líneas en busca de sus valores
        for($i=0;$i<count($lineasCadena);$i++)
        {
            if($lineasCadena[$i]=="")
            {
                //No hacemos nada si está vacío
                continue;
            }else
            {
                //Añadimos el valor al array
                array_push($partesCadena,explode(";",$lineasCadena[$i]));
                GBD::grabaUsuarioMasiva($partesCadena[$i][0],$partesCadena[$i][1]);
            }
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
    <title>Alta Masiva Usuarios</title>
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
    <script src="../../js/altaMasiva.js"></script>
</head>
<body>
    <?php 
        require "../../header.php";
    ?>
    <form action="altaMasivaUsuarios.php" method="post" id="altaMasivaUsuarios">
        <h1>Alta Masiva de Usuarios</h1>
        <label>Alta Masiva Usuarios</label><textarea name="textUsuarios" id="textUsuarios" rows="15" cols="100" required></textarea>
        <?php if(isset($validaciones->errores['textUsuarios'])) echo $validaciones->errores['textUsuarios'] ?>
        <input type="file" name="csv" id="csv" accept=".csv">
        <p class="contenedorBoton"><input type="submit" name="aceptar" value="Aceptar" id="aceptar"></p>
    </form>
    <?php 
        require "../../footer.php";
    ?>
</body>
</html>