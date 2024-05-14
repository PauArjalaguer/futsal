<?
include ("../../Classes/db.inc");
include("../../Classes/News_Class.php");
?>

<?

$news = new News;
$data = $news->newsGetImages();

foreach ($data as $cat) {
$img = "../../../newsImages/micro/" . $cat[0];
//echo $img;
    if (file_exists($img)) {
        // echo "\n\t<img src=\"http://www.futsal.cat/newsImages/" . $cat[0] . "\" width=50 height=50/>";
        echo "\n\t<img onClick='newsImageNewAssign(\"" . $cat[0] . "\")' src=\"http://www.futsal.cat/newsImages/micro/" . $cat[0] . "\" width=50 height=50/>";
    }
}
?>