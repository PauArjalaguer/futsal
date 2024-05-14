<?
if (!isset($_GET['f'])) {
    //header ("Location: index.php?f=video&id=".$_GET['id']);
}
?>
<?
$url = explode("-", $_GET['id']);
$id = $url[0];
mysql_query("update videos set visits=visits+1 where id=" . $id);
include("Classes/Videos_class.php");
$videos = new Video;
$videos->tablename = "videos";
$videos->order = "id desc";
$videos->fields = "Id,Title,Code,Image,Website,Description, Keywords";
$videos->pageno = $_GET['p'];
$videos->rows_per_page = 3;
$data = $videos->getVideoById(" id=" . $id);
//echo "\n\t<h2 id='title' class=\"newDetailTitle\">".$data[1]."</h2>";
?>
<div class="newHeader"><div id='sectionTitle'><span style='color:#600;'>></span> <? echo $data[1]; ?></div>
</div>
<div  class="newContainer">
    <script type="text/javascript">
        function futsalTv(width,height,movie,ruta,title){
            document.write("<div align=center><object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0\" width=\""+width+"\" height=\""+height+"\"><param name=\"wmode\" value=\"transparent\"><param name=\"movie\" value=\""+movie+"?ruta="+ruta+"&title="+title+"\/><param name=\"quality\" value=\"high\" /> <embed wmode=\"transparent\" src=\""+movie+"\?ruta="+ruta+"&title="+title+"\" quality=\"high\" pluginspage=\"http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\"  width=\""+width+"\" height=\""+height+"\"></embed></object></div>");
        }
        function videoSport(movie){
            document.write("<div align=right><object id=\"player\" name=\"player\" width=\"512\" height=\"355\" classid=\"CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6\" viewastext><param name=\"URL\" value=\""+movie+"\"><param name=\"autoStart\" value=\"1\"><param name=\"volume\" value=\"50\"><param name=\"windowlessVideo\" value=\"0\"><embed type=\"application/x-mplayer2\" id=\"player_embed\" name=\"player_embed\" pluginspage=\"http://www.microsoft.com/isapi/redir.dll?prd=windows&sbp=mediaplayer&ar=Media&sba=Plugin&\" width=512 height=355 showcontrols=1 showstatusbar=1 showtracker=1 autostart=1 src=\""+movie+"\" windowlessvideo=0 ></embed></object></div>");}

        function vimeo(movie){
            document.write("<div align=center><object width=\"940\" height=\"588\"><param name=\"allowfullscreen\" value=\"true\" /><param name=\"allowscriptaccess\" value=\"always\" /><param name=\"movie\" value=\"http://vimeo.com/moogaloop.swf?clip_id="+movie+"&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=1&amp;color=cf000a&amp;fullscreen=1\" /><embed src=\"http://vimeo.com/moogaloop.swf?clip_id="+movie+"&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=1&amp;color=cf000a&amp;fullscreen=1\" type=\"application/x-shockwave-flash\" allowfullscreen=\"true\" allowscriptaccess=\"always\" width=\"940\" height=\"588\"></embed></object></div>");}

        function blipTv(movie){
            var m="<div align=center><embed src=\"http://blip.tv/play/"+movie+"\" type=\"application/x-shockwave-flash\" width=\"940\" height=\"588\" allowscriptaccess=\"always\" allowfullscreen=\"true\"></embed></div>";
            document.write(m);}

        function livestream(movie){
            var m="<iframe width=\"586\" height=\"360\" src=\"http://cdn.livestream.com/embed/timeovertv?layout=4&amp;clip="+movie+"&amp;height=588&amp;width=940&amp;autoPlay=true&amp;mute=false\" style=\"border:0;outline:0\" frameborder=\"0\" scrolling=\"no\"></iframe>";
            document.write(m);
        }
        function youtube(movie){
            var m="<iframe width=\"940\" height=\"588\" src=\"http://www.youtube.com/embed/"+movie+"\" frameborder=\"0\" allowfullscreen></iframe>";
            document.write(m);
    }
<?
if (empty($data[4])) {
    echo "futsalTv(586,400,'" . $serverUrl . "futsalTv/player.swf','" . $data[2] . "','" . $data[1] . "');";
}
if ($data[4] == "videosport") {
    echo "videoSport('$data[2]');";
}
if ($data[4] == "vimeo") {
    echo "vimeo('$data[2]');";
}
if ($data[4] == "blipTv") {
    echo "blipTv('$data[2]');";
}
if ($data[4] == "livestream") {
    echo "livestream('$data[2]');";
}
if ($data[4] == "youtube") {
    echo "youtube('$data[2]');";
}
?>
    </script>
    <p>
        <? echo nl2br($data[5]); ?>
    </p>
</div>
<div>&nbsp;</div><div></div><div></div><div></div>
<div class="newsButtonLine" >
    <div id="newsShare">
        <h2 class="newsOptions">Comparteix aquest video</h2>
        <?
        echo "<ul>";
        echo "<li><a href='http://www.facebook.com/share.php?u=http://www.futsal.cat/video.php?id=" . $data[0] . "&amp;title=Video " . urlencode($data[1]) . "' ><img width=\"24\" alt='Facebook' src='webImages/socialNetwork/facebook.png'  />  </a></li>";
        echo "<li><a href='http://twitter.com/home/?status=Nou Video " . urlencode($data[1]) . " http://www.futsal.cat/video.php?id=" . $data[0] . "'><img width=\"24\" alt='Twitter' src='webImages/socialNetwork/twitter.png'  /></a></li>";
        echo "<li> <a  href='http://digg.com/submit?phase=2&amp;url=http://www.futsal.cat/?f=video&id=" . $data[0] . "&amp;title=Video " . urlencode($data[1]) . "' ><img width=\"24\" alt='Digg'  src='webImages/socialNetwork/digg.png'  /></a></li>";
        echo "<li><a  href='http://www.technorati.com/faves?add=http://www.futsal.cat/?f=video&id=" . $data[0] . "&amp;title=Video " . urlencode($data[1]) . "' ><img width=\"24\" alt='Technorati' src='webImages/socialNetwork/technorati.png'  /></a></li>";
        echo "<li><a  href='http://del.icio.us/post?url=http://www.futsal.cat/?f=video&id=" . $data[0] . "&amp;title=Video " . urlencode($data[1]) . "'><img alt='Del.icio.us' width=\"24\" src='webImages/socialNetwork/delicious.png'  /></a></li>";
        echo "<li><a href='http://www.myspace.com/Modules/PostTo/Pages/?l=3&u=http://www.futsal.cat/?f=video&id= " . $data[0] . "&amp;t=" . urlencode($data[1]) . "'><img alt='My Space' width=\"24\" src='webImages/socialNetwork/myspace.png'  /></a></li>";
        echo "</ul>";
        ?>
    </div>
</div>

<?
        $web = "http://www.futsal.cat" . $_SERVER['REQUEST_URI'];
        echo "<div style='padding:5px; margin:5px;'><a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-count=\"horizontal\" data-via=\"futsalcat\" data-lang=\"es\">Tweet</a><script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script></div>";
?>
<div style="padding:5px; margin:5px;">
    <div id="fb-root" ></div>
    <script src="http://connect.facebook.net/ca_ES/all.js#appId=167759963251783&amp;xfbml=1"></script>
    <fb:comments numposts="10" width="580" publish_feed="true"></fb:comments>
</div>
