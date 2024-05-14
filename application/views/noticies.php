<div class="row" id="content" style='padding:12px;'>
    <div  class="large-12 medium-12 columns">
        <div class="row" style="padding:0 15px;">
            <style>
                .animated-search-form[type=search] {
                    width: 10rem;
                    border: 0.125rem solid #e6e6e6;
                    box-shadow: 0 0 3.125rem rgba(0, 0, 0, 0.18);
                    border-radius: 0;
                    background-image: url("//image.ibb.co/i7NbrQ/search_icon_15.png");
                    background-position: 0.625rem 0.625rem;
                    background-repeat: no-repeat;
                    padding: 0.75rem 1.25rem 0.75rem 2rem;
                    transition: width 0.4s ease-in-out;
                }

                .animated-search-form[type=search]:focus {
                    width: 100%;
                }
            </style>
            <input id='newsSearch' type="search" onKeyUp="newsSearch()" name="search" placeholder="Buscar..." class="animated-search-form">
        </div>
        <div class="row" id="newsContainer">

            <?php
            foreach ($get_news as $row):

                echo "\n\t<!--Noticia-->
                    \n\t\t<div class=\"large-4 medium-4 columns end\">
                        \n\t\t\t<div class=\"newsThumbnail\" >
                           \n\t\t\t<a href=\"" . base_url() . "noticies/detall/" . $row->id . "-" . teamUrlFormat($row->title) . "\">
                                <img src=\"https://www.futsal.cat/images/dynamic/newsImages/" . $row->pathImage . "\" width=\"350\" height=175 title=\"".$row->title."\" alt=\"".$row->title."\">
                            </a>
                        </div>
                        \n\t\t\t<div class=\"newsHeader\"> 
                            \n\t\t\t\t<h3><a href=\"" . base_url() . "noticies/detall/" . $row->id . "-" . teamUrlFormat($row->title) . "\">" . substr(strip_tags($row->title), 0, 70) . "</a></h3>
                        </div>
                        \n\t\t\t<div class=\"newsInfo\">
                            \n\t\t\t\t<div class=\"newsInfoDate\">
                                <i class=\"fi-calendar\" style=\"font-size:15px;\"></i> " . invertdateformat($row->updateDate) . "
                            </div>
                        </div>
                        \n\t\t\t<div class=\"newsContent\" >
                            " . substr(strip_tags($row->content), 0, 110) . "...<br /><a href=\"" . base_url() . "noticies/detall/" . $row->id . "-" . teamUrlFormat($row->title) . "\" class=\"read-more\">Llegir</a>
                        </div>
                    </div>
                    <!--/Noticia-->";
            endforeach;
            ?>
        </div>
    </div>
</div>