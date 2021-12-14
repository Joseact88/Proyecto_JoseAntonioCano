<?php
require_once "vendor/autoload.php";
use Dompdf\Dompdf;
$html='
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pedazo de PDF</title>
</head>
<body>

<h2>Vamos a probar a hacer un PDF</h2>
<p>Flipalo colega:</p>
<dl>
<dd>asfdaf</dd>
<dd>Consafasfatancia</dd>
<dd>Optimasdfadfaismo</dd>
<dd>fadsfasf</dd>
<dd>Jamón Pata Negra</dd>
</dl>
</body>
</html>';
$mipdf = new Dompdf();
# Definimos el tamaño y orientación del papel que queremos.
# O por defecto cogerá el que está en el fichero de configuración.
$mipdf ->set_paper("A4", "portrait");
# Cargamos el contenido HTML.
$mipdf ->load_html($html);

# Renderizamos el documento PDF.
$mipdf ->render();

# Creamos un fichero
$pdf = $mipdf->output();
$ruta="pdf/";
$filename = "PEDAZODEPDF2.pdf";
file_put_contents($ruta.$filename, $pdf);

# Enviamos el fichero PDF al navegador.
$mipdf->stream($filename);