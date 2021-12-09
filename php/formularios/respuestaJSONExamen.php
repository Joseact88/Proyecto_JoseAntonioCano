<?php
require_once "../../miAutoLoader.php";
GBD::abreConexion();
$idExamen=$_GET['examen'];
$examen = GBD::leeExamen($idExamen);
$examenPreguntasRespuestas=GBD::leePreguntasExamen($idExamen);
$examenCompleto[]=$examen;
$examenCompleto[]=$examenPreguntasRespuestas;
$respuesta=json_encode($examenCompleto);
echo $respuesta;