<?php

include("../../Classes/db.inc");
include("../../Classes/Files_Class.php");

$files = new Files();
$files->fileId = $_POST['idFile'];
$files->fileTitle = $_POST['fileTitle'];

$files->fileCategory = $_POST['fileCategory'];

$data = $files->fileSave();

echo $data;
?>
