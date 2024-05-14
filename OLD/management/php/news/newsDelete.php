<?
include ("../../Classes/db.inc");
include("../../Classes/News_Class.php");
$news = new News();
    $news->newsId = $_GET['idNew'];
    $data = $news->newsDelete();

?>
