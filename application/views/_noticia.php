<div class="row" id="content" style='padding:12px;'>
    <div  class="large-8 medium-8 columns">
        <div class="row">
            <?php echo "<img src='https://www.futsal.cat/images/dynamic/newsImages/" . $pathImage . "' width=730>"; ?>
            <?php echo "<h2 style='color:#242424;'>$title</h2>"; ?>

            <?php echo "\n\t\t\t\t<div class=\"newsInfoDateFull\">
                                <i class=\"fi-calendar\" style=\"font-size:15px;\"></i> " . invertdateformat($updateDate) . " | <i class=\"fi-social-twitter\"></i> | <i class=\"fi-social-facebook\"></i> |
                            </div>"; ?>
            <?php echo "<p>" . strip_tags(nl2br($content), ',<br><iframe>,<b>,<strong>,<i>') . "</p>"; ?>
        </div>
    </div>
    <div class="large-4 medium-4 columns">
        <h2 style='color:#242424;'>Notícies relacionades</h2>
        <?php
        foreach ($get_news_by_category as $row):

            echo "\n\t<!--Noticia-->
                    \n\t\t<div>
                        \n\t\t\t<div class=\"newsThumbnail relatedNews\" >
                           \n\t\t\t<a href=\"" . base_url() . "noticies/detall/" . $row->id . "-" . teamUrlFormat($row->title) . "\">
                                <img src=\"https://www.futsal.cat/images/dynamic/newsImages/" . $row->pathImage . "\"  >
                            </a>
                        </div>
                        \n\t\t\t<div class=\"newsHeader relatedNews\"> 
                            \n\t\t\t\t<h3 style='min-height:24px;'><a href=\"" . base_url() . "noticies/detall/" . $row->id . "-" . teamUrlFormat($row->title) . "\">" . substr(strip_tags($row->title), 0, 70) . "</a></h3>
                        </div>
                        <!--\n\t\t\t<div class=\"newsInfo relatedNews\">
                            \n\t\t\t\t<div class=\"newsInfoDate\">
                                <i class=\"fi-calendar\" style=\"font-size:15px;\"></i> " . invertdateformat($row->updateDate) . "
                            </div>
                        </div>-->
                        <!--\n\t\t\t<div class=\"newsContent relatedNews\" >
                            " . substr(strip_tags($row->content), 0, 110) . "...<br /><a href=\"" . base_url() . "noticies/detall/" . $row->id . "-" . teamUrlFormat($row->title) . "\" class=\"read-more\">Llegir</a>
                        </div>-->
                        <hr />
                    </div>
                    <!--/Noticia-->";
        endforeach;
        ?>
    </div>
</div>