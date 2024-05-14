<?
include("../../Classes/db.inc");
include("../../Classes/News_Class.php");
include("../../Classes/Referees_Class.php");
?>     

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Actes</h3>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Partit</th>
                    <th>Data</th>

                    <th colspan="2">Accions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $referee = new Referees();
                $data = $referee->rfrRefereeMatchesList();
                /* echo "<pre>";
                  print_r($data);
                  echo "</pre>"; */
                foreach ($data as $rfr) {
                    if ($rfr[1] != $id) {
                        echo "<tr id='newsTr_" . $news[0] . "'><td>" . $rfr[11] . "</td>";
                        echo "<td><strong>" . $rfr[12] . "</strong> " . utf8_encode($rfr[2]) . " - " . utf8_encode($rfr[3]) . "</td>";
                        echo "<td>" . utf8_encode($rfr[8]) . "</td>";
                        echo "<td align=left>";

                        echo "<a href=# onClick='rfrRefereeMatchResultForClub(" . $rfr[1] . ");'>Actes</a><br />";
                        echo "</td></tr>";
                    }
                    $id = $rfr[1];
                }
                ?>  
            </tbody>
    </div>
</div>

