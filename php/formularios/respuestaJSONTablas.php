<?php
require_once "../../miAutoLoader.php";
GBD::abreConexion();
if(isset($_GET['tabla']) && isset($_GET['numero']) && isset($_GET['pagina']))
{
    $respuesta="";
    $tabla=$_GET['tabla'];
    $numeroPorTabla=intval($_GET['numero']);
    $pagina=intval($_GET['pagina']);
    if($tabla=="usuario")
    {
        $respuesta=GBD::leeListaUsuarios($numeroPorTabla,$pagina);
    }
    echo json_encode($respuesta);
}else{
    header("Location: loginForm.php");
}
