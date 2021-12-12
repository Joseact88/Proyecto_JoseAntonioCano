<?php
require_once "../../miAutoLoader.php";
Sesion::iniciar();
GBD::abreConexion();
//Comprobamos que exista una sesión
if(!Sesion::existe('usuario'))
{
    header("Location: loginForm.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        require "../../header.php";
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnado</title>
    <script src="../../js/tablaExamenes.js"></script>
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
</head>
<body>
    <form class="tablas">
        <h1>Histórico de Examenes</h1>
        <select name="comboNumero" id="comboNumero" class="comboNumero">
            <option value="5" selected>5</option>
            <option value="10">10</option>
            <option value="15">15</option>
        </select>
        <table>
            <thead>
                <th>Descripción</th>
                <th>Nº Preguntas</th>
                <th>Duración</th>
                <th>Activado</th>
                <th>Acciones</th>
            </thead>
            <tbody id="tbodyExamenes">
            </tbody>
        </table>
        <main id="paginator" class="paginator">
            
        </main>
        <main class="modal" id="modal">
            <section class="mensaje">
                <label>¿Estás seguro de que quieres eliminar el registro?</label>
            </section>
            <section class="botones">
                <button id="confirmar">Si</button>
                <button id="denegar">No</button>
            </section>
        </main>
    </form>
    <?php 
        require "../../footer.php";
    ?>
</body>
</html>