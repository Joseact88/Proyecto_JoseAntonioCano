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
    $validaciones->Requerido('tematica');
    $validaciones->Requerido('enunciado');
    $validaciones->Requerido('op1');
    $validaciones->Requerido('op2');
    $validaciones->Requerido('op3');
    $validaciones->Requerido('op4');
    $validaciones->Requerido('correcta');
    if(count($validaciones->errores)==0)
    {
        $tematica=$_POST['tematica'];
        $enunciado=$_POST['enunciado'];
        $op= array($_POST['op1'], $_POST['op2'], $_POST['op3'], $_POST['op4']);
        $correcta=$_POST['correcta'];
        $imagen=null;
        if(isset($_FILES['imagen']))
        {
            $imagen="img/Preguntas/".$_FILES['imagen']['name'];
            move_uploaded_file($_FILES['imagen']['tmp_name'],"../../".$imagen);
        }
        GBD::altaPreguntaRespuestas($enunciado, $tematica, $imagen, $op, $correcta, null);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta preguntas</title>
    <script src="../../js/altaPreguntas.js"></script>
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
</head>
<body>
    <?php 
        require "../../header.php";
    ?>
    <form action="altaPreguntas.php" method="post" enctype='multipart/form-data' id="form1">
        <h1>Alta Preguntas</h1>
        <label>Tematica:</label><select name="tematica" id="tematica">
            <option value='-1' selected>Sin Seleccionar</option>
            <?php 
                $tematicas=array();
                $tematicas=GBD::leeListaTematicas();
                for ($i=0;$i<count($tematicas);$i++)
                {
                    echo "<option value='".$tematicas[$i]->idTematica."'>".$tematicas[$i]->descripcion."</option>";
                }
            ?>
        </select>
        <label>Enunciado:</label><textarea name="enunciado" id="enunciado" rows="10" cols="50" required maxlength="200"></textarea><br>
        
        <label>Opción 1:</label><input type="text" name="op1" id="op1" maxlength="30" required>
        <input type="radio" id="op1Correcta" name="correcta" value="1" checked="checked"> Correcta
        
        <label>Opción 2:</label><input type="text" name="op2" id="op2" required>
        <input type="radio" id="op2Correcta" name="correcta" maxlength="30" value="2"> Correcta
        
        <label>Opción 3:</label><input type="text" name="op3" id="op3" required>
        <input type="radio" id="op3Correcta" name="correcta" maxlength="30" value="3"> Correcta
        
        <label>Opción 4:</label><input type="text" name="op4" id="op4" required>
        <input type="radio" id="op4Correcta" name="correcta" maxlength="30" value="4"> Correcta
        
        <label for="imagen">Seleccionar imagen</label><input type="file" name="imagen" id="imagen">

        <p class="contenedorBoton"><input type="submit" name="aceptar" value="Aceptar" id="aceptar"></p>
    </form>
    <?php 
        require "../../footer.php";
    ?>
</body>
</html>