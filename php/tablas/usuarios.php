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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnado</title>
    <script src="../../js/tablaUsuarios.js"></script>
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
</head>
<body>
    <form class="tablas">
        <h1>Alumnos</h1>
        <select name="comboNumero" id="comboNumero" class="comboNumero">
            <option value="5" selected>5</option>
            <option value="10">10</option>
            <option value="15">15</option>
        </select>
        <table>
            <thead>
                <th>Alumno/a</th>
                <th>Correo Electrónico</th>
                <th>Exámenes realizados</th>
                <th>Acciones</th>
            </thead>
            <tbody id="tbodyUsuarios">
            </tbody>
        </table>
        <div id="paginator" class="paginator">
            
        </div>
    </form>
</body>
</html>