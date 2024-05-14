<div class="row" id="content" style='padding:12px;'>
    <div  class="large-12 medium-12 columns">
        <div class="row">
            <h2 id='galleryTitle'> <?php echo $api;
//echo $photoset['title']; ?></h2>
            <div >
                <?php
                $p = explode("-", $photoset);
                $id = $p[0];

//echo "<pre>";print_r(get_defined_vars());echo "</pre>";
                function xmlParse($xml) {
                    $total = count($xml->photoset->photo);
                    
                    //echo "total:" . $total;
                    $c = 0;
                    for ($i = 0; $i < $total; $i++) {
                        $date_create = "";
                        $farm = "farm" . $xml->photoset->photo[$i]['farm'];
                        $id = $xml->photoset->photo[$i]['id'];
                        $secret = $xml->photoset->photo[$i]['secret'];
                        $server = $xml->photoset->photo[$i]['server'];
                        $title = $xml->photoset->photo[$i]['title'];
                        $img = "<img src=\"http://static.flickr.com/" . $server . "/" . $id . "_" . $secret . "_z.jpg\" alt='i'  width=280 height=187 >";
                        $bigImg = "http://farm3.static.flickr.com/" . $server . "/" . $id . "_" . $secret . "_o.jpg ";

                        echo "\n\t<!--Noticia-->
                    \n\t\t<div class=\"large-4 medium-4 columns\">
                        \n\t\t\t<div class=\"newsThumbnail\" >
                           \n\t\t\t<a href=\"" . base_url() . "multimedia/foto/" . $id . "-" . teamUrlFormat($title) . "\">
                               $img </a>
                        </div>
                       
                       

                </div>
                <!--/Noticia-->";
                    }
                    return $galleryTitle=$xml->photoset['title'];
                }

                if ($api == 1) {
                    $FLICKR_API_KEY = "0df858f7d07620ceb376242e418a08a9";
                    $FLICKR_ID = "42695980@N02";
                } else {
                    $FLICKR_API_KEY = "300670a36543af3e85a4244fc422050a";
                    $FLICKR_ID = "166169194@N05";
                }
                $rest = "http://flickr.com/services/rest/?method=flickr.photosets.getPhotos&user_id=" . $FLICKR_ID . "&api_key=" . $FLICKR_API_KEY . "&photoset_id=" . $id;
                //echo $rest;
                $xml = simplexml_load_file($rest);
                $galleryTitle=xmlParse($xml);
                ?>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>document.getElementById("galleryTitle").innerHTML="<?php echo $galleryTitle; ?>";</script>