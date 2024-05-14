<?

$out = "";
if ($_GET['idVideo']) {
    include ("includes/db.inc");
    include "includes/funciones.php";
    include "classes/Videos_class.php";
    $serverUrl = "http://localhost:8081/viBalance/";
    //$serverUrl = "http://www.byomedicsystem.com/viBalance/";
}
?>

<?

$videos = new Videos;
$videos->tablename = "videos v";
$videos->order = " featured desc";
$videos->fields = "id,title,path,snap";

$videos->rows_per_page = 4;
$videos->where = "featured=1";
$data = $videos->getInitialVideos($where);
//print_r($data);
if ($_GET['idVideo']) {
    $a = 2;
} else {
    $a = 1;
}

$outPlayer = "";
$out = "";
foreach ($data as $video) {
    if ($a == 1 or $video[0] == $_GET['idVideo']) {
        if ($video[0] == $_GET['idVideo']) {
            $autoplay = "autoplay=1";
        } else {
            $autoplay = "autoplay=0";
        }



        $outPlayer .="<div ><iframe src=\"http://player.vimeo.com/video/" . $video[2] . "?title=0&amp;byline=0&amp;portrait=0&amp;$autoplay\" width=\"420\" height=\"233\" frameborder=\"0\">";
        $outPlayer .="</iframe></div>";
    }
    if ($a != 1 and $video[0] != $_GET['idVideo']) {
        $out .="\n\t<a class='videoInitThumbs' id=\"videoInitThumbs" . $video[0] . "\" title=\"$video[0]\">";
        $out .="\n\t\t<span>" . $video[1] . "</span>";
        $out .="\n\t\t<img src=\"" . $video[3] . "\" width=\"128\" height=72 />";
        $out .="\n\t</a>";
    }
    $a++;
}


echo $outPlayer . $out;
$out = "";
$outPlayer = "";
?>
