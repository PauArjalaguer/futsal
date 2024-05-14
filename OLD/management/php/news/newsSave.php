<?php

include("../../Classes/db.inc");
include("../../Classes/News_Class.php");
include("../../Classes/Competition_Class.php");
$news = new News();
$news->newsId = $_POST['idNew'];
$news->newsTitle = utf8_decode(addslashes($_POST['newsTitle']));
$news->newsText = utf8_decode(addslashes($_POST['newsText']));
$news->newsCategory = $_POST['newsCategory'];
$news->newsImage = $_POST['newsImage'];
$news->newsMatch = $_POST['newsMatch'];
$news->newsExpirationDate = $_POST['newsExpirationDate'];
//SI NO HI HA ID, ES NOTICIA NOVA
if ($_POST['idNew'] == 0) {
     $data=$news->newsSaveInsert();
} else {
   $data= $news->newsSaveUpdate();
   
}
echo $data;
?>
