<div class="newHeader">
    <h1 id="sectionTitle"><span style='color:#600;'>></span>
        <?
        $url = explode("-", $_GET['photo']);
        $id=$url[0];
        $rest = "http://flickr.com/services/rest/?method=flickr.photos.getInfo&api_key=9ad0d60ee22731d828426ae5d003452a&photo_id=" . $id;
        //echo $rest;
        $xml = simplexml_load_file($rest);
        echo $title= utf8_decode($xml->photo->title);
        
        ?>
    </h1>
</div>


<div class="newContainer" style="display:table;" >
    <div  class='imgtable_div yoxview ' style="margin:10px;">
        <?
        $large = "";
        $rest = "http://flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=9ad0d60ee22731d828426ae5d003452a&photo_id=" . $id;
        $xml = simplexml_load_file($rest);
        //echo $rest;

        $total = count($xml->sizes->size);

        for ($a = 0; $a < $total; $a++) {
            if ($xml->sizes->size[$a]['label'] == "Medium") {
                $medium = $xml->sizes->size[$a]['source'];
            }
            if ($xml->sizes->size[$a]['label'] == "Large") {
                $large = $xml->sizes->size[$a]['source'];
            }
            if ($xml->sizes->size[$a]['label'] == "Original") {
                $original = $xml->sizes->size[$a]['source'];
            }
        }
        if($large){
            $url="<a href='$large'>";
        }else{
             $url="<a href='$original'>";
        }

        $img = "<img src='$large' alt='$title' width=890>";
        echo $url . " " . $img . "</a>";
        ?></div>
    <div><?
        $rest = "http://flickr.com/services/rest/?method=flickr.photos.getContext&api_key=9ad0d60ee22731d828426ae5d003452a&photo_id=" . $id;
        $xml = simplexml_load_file($rest);
        $pre = $xml->prevphoto['id'];
        $preT = $xml->prevphoto['thumb'];
        $preN = utf8_decode($xml->prevphoto['title']);
        $post = $xml->nextphoto['id'];
        $postT = $xml->nextphoto['thumb'];
        $postN = utf8_decode($xml->nextphoto['title']);
        if (!empty($preT)) {
            echo "<div style='width:50px; float:left;'><a href='" . $serverUrl . "imatge/$pre-" . treuAccents($preN) . "'>
            <strong>Anterior</strong><br /><img style='border:1px solid #000;' src='$preT' width=40 /></a></div>";
        }
        if (!empty($postT)) {
            echo "<div style='width:50px; float:left;'><a href='" . $serverUrl . "imatge/$post-" . treuAccents($postN) . "' ><strong>Següent</strong><br /><img style='border:1px solid #000;' src='$postT' width=40 /></a></div>";
        } ?></div>

    <div style="clear:both; height:1px;">&nbsp;</div>  <div><strong>Etiquetes de la imatge: </strong><?
        $rest = "http://flickr.com/services/rest/?method=flickr.tags.getListPhoto&api_key=9ad0d60ee22731d828426ae5d003452a&photo_id=" . $id;
        $xml = simplexml_load_file($rest);

        $total = count($xml->photo->tags->tag);
        for ($i = 0; $i < $total; $i++) {
            if (!empty($xml->photo->tags->tag[$i])) {
                $title = utf8_decode($xml->photo->tags->tag[$i]);
                echo "<a href=" . $serverUrl . "imatges/etiqueta/" . treuAccents($title) . "><span >" . $title . "</span></a>, ";
            }
        }
        ?></div>
    <div>&nbsp;</div>

</div>
<div class="newsButtonLine" >
    <a href='<? echo $_SERVER['HTTP_REFERER']; ?>'>
        <img src="http://www.futsal.cat/webImages/back.png" alt="Enrere" title="Enrere"  />
    </a> |
    <a href='<? echo $serverUrl; ?>imatges'>
        <img src="http://www.futsal.cat/webImages/images.png" alt="Tornar a galeries" title="Tornar a galeries"  />
    </a> |
    <a href='<? echo $large; ?>'>
        <img src="http://www.futsal.cat/webImages/image.png" alt="Descarregar en alta resolució" title="Descarregar en alta resolució"  />
    </a>
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


<script type="text/javascript">
    $(document).ready(function(){
        $(".yoxview").yoxview();
    });
</script>