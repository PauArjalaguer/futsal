
            <?php
            foreach ($get_news as $row):

                echo "\n\t<!--Noticia-->
                    \n\t\t<div class=\"large-4 medium-4 columns\">
                        \n\t\t\t<div class=\"newsThumbnail\" >
                           \n\t\t\t<a href=\"" . base_url() . "noticies/detall/" . $row->id . "-" . teamUrlFormat($row->title) . "\">
                                <img src=\"https://www.futsal.cat/images/dynamic/newsImages/" . $row->pathImage . "\" width=\"350\" height=175 alt=\"".$row->title."\" title=\"".$row->title."\">
                            </a>
                        </div>
                        \n\t\t\t<div class=\"newsHeader\" style='max-height:37px;'> 
                            \n\t\t\t\t<h3><a href=\"" . base_url() . "noticies/detall/" . $row->id . "-" . teamUrlFormat($row->title) . "\">" . substr(strip_tags($row->title), 0, 70) . "</a></h3>
                        </div>
                        \n\t\t\t<div class=\"newsInfo\">
                            \n\t\t\t\t<div class=\"newsInfoDate\">
                                <i class=\"fi-calendar\" style=\"font-size:15px;\"></i> " . invertdateformat($row->updateDate) . "
                            </div>
                        </div>
                        \n\t\t\t<div class=\"newsContent\" style='max-height:57px;'>
                            " . substr(strip_tags($row->content), 0, 110) . "...<br /><a href=\"" . base_url() . "noticies/detall/" . $row->id . "-" . teamUrlFormat($row->title) . "\" class=\"read-more\">Llegir</a>
                        </div>
                    </div>
                    <!--/Noticia-->";
            endforeach;
            ?>
       