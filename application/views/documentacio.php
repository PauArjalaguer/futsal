<div class="row" id="content" style='padding:12px;'>
    <div  class="large-12 medium-12 columns">
        <div class="row">
            <h2>Documents</h2>
            <div><table border="1" width="100%">
                    <?php
                    $title = '';
                    foreach ($documents as $row):

                        if ($row->title != $title) {
                            echo "\n\t\t\t\t</table>\n\t\t</div>\n\t\t<div class='large-12 medium-12 columns' style='margin-top:30px;'>\n\t\t\t<h3  style='font-weight:bold; font-size:20px;'>" . $row->title . "</h3>\n\t\t\t<table class=\"classificationTable\">";
                        }
                        echo "\n\t\t\t<tr>";
                        echo "\n\t\t\t\t<td width=90%>";
                        echo "\n\t\t\t\t\t<a href='".base_url()."content/documentacio/" . $row->filePath . "' target=_blank>";
                        echo "\n\t\t\t\t\t\t<span class=\"classificationTableTeamCount\">" . $row->fileName . "</span>";
                        echo "\n\t\t\t\t\t</a>";
                        echo "\n\t\t\t\t</td>";
                        echo "\n\t\t\t\t<td  style='text-align:right;' width=10%>";
                        echo "\n\t\t\t\t\t<span>";
                        echo "\n\t\t\t\t\t\t<a href='".base_url()."content/documentacio/" . $row->filePath . "' target=_blank>";
                        echo "\n\t\t\t\t\t\t\t<i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i> ";
                        echo "\n\t\t\t\t\t\t</a>";
                        echo "\n\t\t\t\t\t</td>";
                        echo "\n\t\t\t\t</tr>";
                        $title = $row->title;

                    endforeach;
                    ?></table>
            </div>
        </div>
    </div>
</div>