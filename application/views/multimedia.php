<div class="row" id="content" style='padding:12px;'>
    <div  class="large-12 medium-12 columns">
        <div class="row">
            <h2>Videos</h2>
            <?php
            foreach ($get_videos as $row):
                echo "\n\t<!--Video-->
                    \n\t\t<div class=\"large-4 medium-4 columns\">
                        \n\t\t\t<div class=\"newsThumbnail\" >
                           \n\t\t\t<a href=\"" . base_url() . "multimedia/video/" . $row->id . "-" . teamUrlFormat($row->title) . "\">
                               <img src='" . $row->image . "'> </a>
                        </div>
                        \n\t\t\t<div class=\"newsHeader\"> 
                            \n\t\t\t\t<h3><a href=\"" . base_url() . "multimedia/video/" . $row->id . "-" . teamUrlFormat($row->title) . "\">" . substr(strip_tags($row->title), 0, 70) . "</a></h3>
                        </div>
                        

                </div>
                <!--/Video-->";
            endforeach;
            ?>
        </div>
        <div class="row">
            <h2>Galeries</h2>



            <div >
                <?php

                function xmlParse($xml,$api) {
                    $total = count($xml->photosets->photoset);
                    $c = 0;
                    for ($i = 0; $i < $total; $i++) {
                        $photoset = $xml->photosets->photoset[$i]['id'];
                        $server = $xml->photosets->photoset[$i]['server'];
                        $primary = $xml->photosets->photoset[$i]['primary'];
                        $secret = $xml->photosets->photoset[$i]['secret'];
                        $images = $xml->photosets->photoset[$i]['photos'];
                        $date_create = $xml->photosets->photoset[$i]['date_create'];
                        $title = $xml->photosets->photoset[$i]->title;
                        $img = "<img src=\"http://static.flickr.com/" . $server . "/" . $primary . "_" . $secret . "_z.jpg\" id=\"$primary\" alt=\"$title\" width=280 height=187  >";

                        echo "\n\t<!--Noticia-->
                    \n\t\t<div class=\"large-4 medium-4 columns\">
                        \n\t\t\t<div class=\"newsThumbnail\" >
                           \n\t\t\t<a href=\"" . base_url() . "multimedia/album/" . $photoset . "-" . teamUrlFormat($title) . "/$api\">
                               $img </a>
                        </div>
                        \n\t\t\t<div class=\"newsHeader\"> 
                            \n\t\t\t\t<h3><a href=\"" . base_url() . "multimedia/album/" . $photoset . "-" . teamUrlFormat($title) . "/$api\">" . substr(strip_tags($title), 0, 70) . "</a></h3>
                        </div>
                        \n\t\t\t<div  class=\"newsInfo\">
                            \n\t\t\t\t<div class=\"newsInfoDate\">
                                <i class=\"fi-photo\" style=\"font-size:15px;\"></i> " . $images . " imatges.
                </div>
                </div>

                </div>
                <!--/Noticia-->";
                    }
                }

                $FLICKR_API_KEY = "300670a36543af3e85a4244fc422050a";
                $FLICKR_ID = "166169194@N05";
                $xml = simplexml_load_file("http://flickr.com/services/rest/?method=flickr.photosets.getList&user_id=" . $FLICKR_ID . "&api_key=" . $FLICKR_API_KEY);
                xmlParse($xml, 2);


                $FLICKR_API_KEY = "0df858f7d07620ceb376242e418a08a9";
                $FLICKR_ID = "42695980@N02";
                $xml = simplexml_load_file("http://flickr.com/services/rest/?method=flickr.photosets.getList&user_id=" . $FLICKR_ID . "&api_key=" . $FLICKR_API_KEY);
                xmlParse($xml, 1);
                ?>

            </div>
        </div>
    </div>
</div>