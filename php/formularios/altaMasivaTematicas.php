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
    $validaciones->Requerido('textTematicas');
    //Creamos el array de la cadena dividida
    $lineasCadena=[];
    $partesCadena=[];
    if(count($validaciones->errores)==0)
    {
        //Separamos el valor del textarea en lineas
        $lineasCadena=explode("\n",$_POST['textTematicas']);
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
                $tematica=new Tematica($partesCadena[$i][0]);
                GBD::grabaTematica($tematica);
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
    <title>Alta Masiva Tematicas</title>
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
    <script src="../../js/altaMasiva.js"></script>
</head>
<body>

    <form action="altaMasivaTematicas.php" method="post" id="altaMasivaTematicas">
        <h1>Alta Masiva de Temáticas</h1>
        <label>Alta Masiva Temáticas</label><textarea name="textTematicas" id="textTematicas" rows="25" cols="100" required></textarea>
        <input type="file" name="csv" id="csv">
        <p class="contenedorBoton"><input type="submit" name="aceptar" value="Aceptar" id="aceptar"></p>
    </form>
</body>
</html>