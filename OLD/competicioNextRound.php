<br />
<table  cellpadding="0" width="100%" cellspacing="0" border="0" id="taulajornada"  >
    <thead>
        <tr>
            <th colspan="4">
                <?
                // echo "...".$_GET['idRound'];
                if (isset($_GET['idRound'])) {
                    include ("includes/db.inc");
                    include("Classes/Competition_class.php");
                }
                $competition = new Competition;
                $competition->idLeague = 6;



                if (isset($_GET['idRound'])) {
                    $roundNumber = $_GET['idRound'];
                } else {
                    $roundNumberArray = $competition->getLastRoundWithResults();
                    $roundName = $roundNumberArray[1];
                    $roundNumber = $roundNumberArray[0];
                }

                if ($roundNumber > 1) {
                    $prevNumber = $roundNumber - 1;
                    //$comp = " <img class='button' onclick='competitionChangeRound($prevNumber);' src='http://www.futsal.cat/webImages/previous.png'> ";
                }
                $comp = $data = $competition->getLeagueName();


                $comp .= " - Jornada " . $roundName;

                $nextNumber = $roundNumber + 1;
                //$comp .= " <img class='button' onclick='competitionChangeRound($nextNumber);' src='http://www.futsal.cat/webImages/next.png'>";
                ?>
                <?
                if (isset($_GET['idRound'])) {
                    $competition->idRound = $_GET['idRound'];
                }

                $data = $competition->getNextRoundMatchesByLeague();
                foreach ($data as $match) {
                    if ($n == 1) {
                        $color = "#dedede";
                    } else {
                        $color = "#efefef";
                    }
                    if ($n == 1) {
                        $n = 2;
                    } else {
                        $n = 1;
                    }
                    $comp .= "<tr><td class='td' style='background-color:" . $color . ";'>" . $match[2] . "</td><td style='border-bottom:0px solid;background-color:" . $color . ";'' class='td'>-</td><td class='td' style='background-color:" . $color . ";'>" . $match[3] . " </td></tr>";
                }
                $query = "select * from teams_divisions td join teams t on t.id=td.idTeam where (t.id not in (select idlocal from matches where idround=$roundNumber) and t.id not in (select idvisitor from matches where idround=$roundNumber)) and idDivision=6";

                $res = mysql_query($query);

                $row = mysql_fetch_array($res);
                if (mysql_num_rows($res) > 0) {
                    $comp .= "<tr><td class='td' colspan=4>Descansa <strong>" . $row['name'] . "</strong></td></tr>";
                }


                if (isset($_GET['idRound'])) {
                    echo utf8_encode($comp);
                } else {
                    echo $comp;
                }
                ?>
</table>   