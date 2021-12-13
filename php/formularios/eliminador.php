<?php
require_once "../../miAutoLoader.php";
GBD::abreConexion();
if(isset($_GET['tabla']) && isset($_GET['id']))
{
    $id=$_GET['id'];
    //Comprobamos que tabla es
    if($_GET['tabla']=="usuario")
    {
        GBD::eliminaUsuario($id);
    }
    if($_GET['tabla']=="tematica")
    {
        GBD::eliminatematica($id);
    }
    if($_GET['tabla']=="pregunta")
    {
        GBD::eliminaPregunta($id);
    }
    if($_GET['tabla']=="examen")
    {
        GBD::eliminaExamen($id);
    }
}
else
{
    echo "Error, parámetros equivocados";
}