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
$insertado="";
if(isset($_POST['aceptar']))
{
    //Comprobamos que ningún campo esté vacío
    $validaciones=new Validacion();
    //Comprobamos que los campos no estén vacíos
    $validaciones->requerido("descripcion");
    $validaciones->requerido("duracion");
    $validaciones->requerido("preguntasExamen");
    if(count($validaciones->errores)==0)
    {
        $descripcion=$_POST['descripcion'];
        $duracion=$_POST['duracion'];
        $numPreguntas=$_POST['numPreguntas'];
        $preguntasExamen=array();
        $preguntasExamen=explode(",",$_POST['preguntasExamen']);
        //Insertamos el examen
        $insertado=GBD::altaPreguntasExamen($descripcion, $duracion,$preguntasExamen, $numPreguntas);
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
    <script src="../../js/libreria.js"></script>
    <script src="../../js/altaExamenes.js"></script>
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
</head>
<body>
    <?php 
        require "../../header.php";
    ?>
    <form action="altaExamenes.php" method="post" class="examen">
        <h1>Alta Exámenes</h1>
        <label>Descripción: </label> <input type="text" id="descripcion" name="descripcion" maxlength="200">
        <label>Duración: </label><input type="text" id="duracion" name="duracion" maxlength="3" onkeypress="return soloNumeros(event)">
        <label>Número de Preguntas: </label><input type="text" id="numPreguntas" name="numPreguntas" maxlength="2" onkeypress="return soloNumeros(event)">
        <!--Filtros-->
        <label>Tematica: </label><select name="tematica" id="tematica">
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
        <input type="text" name="filtro" id="filtro"> <span class="fas fa-search filtro"></span>
        <table id="preguntas" class="tablaExamen">
            <thead>
                <th class="ordenable str">Enunciado</th>
                <th class="ordenable str">Temática</th>
            </thead>
            <tbody id="tbodyPreguntas">

            </tbody>
        </table>
        <table id="preguntasExamen" class="tablaExamen">
            <thead>
                <th class="ordenable str">Enunciado</th>
                <th class="ordenable str">Temática</th>
            </thead>
            <tbody id="tbodyPreguntasExamen">
        </table>
        <input type="text" readonly="true" id="contador" class="contador">
        <p class="contenedorBoton"><span id="error"></span><input type="submit" name="aceptar" value="Aceptar" id="aceptar"></p>
        
    </form>
    <?php 
        require "../../footer.php";
    ?>
</body>
</html>