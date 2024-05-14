<?php
$subject = "Factura CAT - $billNumber";
$out .="<div class=\"section\" style='font-weight:bold;'>Facturació</div>";
$out .="<div class=\"content\">Adjuntem en aquest mail la vostra factura.</div>";

$out .="<div class=\"content\">Per a descarregar-la, fes click <a href='http://www.futsal.cat/factures/$path.pdf'>aquí</a>.</div>";

include ("../mailSender.php");
?>
