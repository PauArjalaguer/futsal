<?
include("../../Classes/db.inc");
include("../../Classes/News_Class.php");
include("../../Classes/Referees_Class.php");
?>     
<div class='box box-warning'>
    <div class='box-header'>
        <h3 class='box-title'>CANVIS ACTA DIGITAL</h3>
    </div>
    <div class='box-body'>
         <a target=_blank style='font-size:34px; color:#f00;' href='php/referees/canvisActa.php'>VEURE CANVIS ACTA DIGITAL</a>
       
    </div>
</div>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Arbitres</h3>
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
                /*echo "<pre>";
                print_r($data);
                echo "</pre>";*/
                foreach ($data as $rfr) {
                    echo "<tr id='newsTr_" . $news[0] . "'><td>" . $rfr[11] . "</td>";
                    echo "<td><strong>" . $rfr[12] . "</strong> " . utf8_encode($rfr[2]) . " - " . utf8_encode($rfr[3]) . "</td>";
                    echo "<td>" . utf8_encode($rfr[8]) . "</td>";
                    //echo "<td>" . $news[2] . "</td>";
                    //echo "<td align=center><i class=\"fa  fa-edit\" style='cursor:pointer' onClick='newsEdit(".$news[0].");'></i></td><td  align=center><i style='cursor:pointer' class=\"fa  fa-trash-o\" onClick='newsDelete(".$news[0].");'></i></td></tr>";
                    echo "<td align=left>";
                   //echo "<a href=# onClick='rfrRefereeMatchResult(" . $rfr[1] . ");'>Resultats</a><br />";

                   echo "<a href='" . $serverURL . "/arbitres/bills.php?idMatch=" . $rfr[1] . "'>Nomenaments</a><br />";
                   // echo "<a href='" . $serverURL . "/arbitres/billsPerClub.php?idMatch=" . $rfr[1] . "'>Rebut lliga</a><br />";
                   // echo "<a href='" . $serverURL . "/arbitres/billsPerClub.php?idMatch=" . $rfr[1] . "&idTeam=" . $rfr[4] . "&t=local'>Rebut copa local</a><br />";
                   // echo "<a href='" . $serverURL . "/arbitres/billsPerClub.php?idMatch=" . $rfr[1] . "&idTeam=" . $rfr[4] . "&t=visitor'>Rebut copa visitant</a>";
                    if ($rfr[13] == 0) {
                        echo "<br /><button type=\"button\"  class=\"css3button\" onClick='rfrMatchAssignationAccept(" . $rfr[1] . "," . $_COOKIE['idReferee'] . ");'>ACCEPTAR</button>";
                    }else{
                        echo "<a href=# onClick='rfrRefereeMatchResult(" . $rfr[1] . ");'>Resultats</a><br />";

                    }

                    echo "</td></tr>";
                }
                ?>  
            </tbody>
    </div>
</div>

