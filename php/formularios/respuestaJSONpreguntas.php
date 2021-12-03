<?php
require_once "../../miAutoLoader.php";
GBD::abreConexion();
$array = GBD::leeListaPreguntas();
$listaTematicas= GBD::leeListaTematicas();
$respuesta=json_encode($array);
echo $respuesta;