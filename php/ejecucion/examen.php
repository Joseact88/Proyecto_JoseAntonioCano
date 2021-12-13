<?php
require_once "../../miAutoLoader.php";
Sesion::iniciar();
GBD::abreConexion();
//Comprobamos que exista una sesión
if(!Sesion::existe('usuario'))
{
    header("Location: ../formularios/loginForm.php");
}
if(!isset($_GET['examen']))
{
    header("Location: ../tablas/examenes.php");
}
//Cogemos el id del Examen
$idExamen=$_GET['examen'];
//Vemos si hay un envío del formulario
if(isset($_POST['finalizar']))
{  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen</title>
    <script src="../../js/ejecucionExamen.js"></script>
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
</head>
<body>
    <?php 
        require "../../header.php";
    ?>
    <form action="" method="post" class="examenEjecucion" name='<?php echo $idExamen?>'>
        <section id="reloj">
            <p>
                <span id="minutos"></span> : <span id="segundos"></span>
            </p>
        </section> 
        <h1 id="pregunta"></h1>
        <main id=preguntas>

        </main>
        <main class="adicionales">
            <button id="anterior">Anterior</button>
            <button id="siguiente">Siguiente</button>
            <button id="repasar">Repasar</button>
        </main>   
        <main id="botones" class="paginator"></main>
        <input type="submit" value="Finalizar" name="finalizar" id="finalizar">
    </form>
    <?php 
        require "../../footer.php";
    ?>
</body>
</html>