<?php include ($_SERVER['DOCUMENT_ROOT']."/includes/config.php");
include ($_SERVER['DOCUMENT_ROOT']."/includes/funciones.php");
$idcnx = conectar();
mysql_query("update news_votes set idnew=4 where ip='83.247.136.22' and datetime='2010-02-09'");
?>