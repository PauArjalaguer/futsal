<div class="row" id="content" style='padding:12px;'>
    <div  class="large-12 medium-12 columns">
        <div class="row">
            <h2>Competició</h2>
            <div >
                <?php
                $division='';
               foreach ($get_competitions as $row):
                    if ($row->division != $division) {
                        echo "\n\t</div>\n\t<div class='large-4 medium-4 columns end' style='margin-top:30px;'>\n\t\t<h3 style='color:" . $row->color . "; font-weight:bold; font-size:20px;'>" . $row->division . "</h3>";
                    }

                    $league = str_replace($row->division, "", $row->name);
					$league= str_replace(">","<i class=\"fi-torsos-all large\"></i>",$league);
                    echo "\n\t\t<div style='border:1px solid " . $row->color . "; height:40px; font-size:15px; width:80px; margin:5px 10px; padding-top:8px; text-align:center; float:left; color:" . $row->color . "'><a style='color:" . $row->color . ";' href='competicio/lliga/" . $row->id . "-" . teamUrlFormat($row->name) . "'>" . $league . "</a></div>";
                    $division = $row->division;
                endforeach;
                ?>
            </div>
        </div>
    </div>
</div>