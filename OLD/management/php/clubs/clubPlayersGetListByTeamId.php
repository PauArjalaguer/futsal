<?
include("../../Classes/db.inc");
include("../../Classes/Clubs_Class.php");
$clubs = new Clubs();
if (isset($_COOKIE['idClub'])) {
    $clubs->idClub = $_COOKIE['idClub'];
}
$clubs->idTeam = $_GET['idTeam'];
$data = $clubs->clubsGetTeamById();

$teamName = utf8_encode($data[0]);
$teamImage = $data[1];
?>     
<section class="content-header">
    <h1 onClick="clubPlayersGetListByTeamId(<? echo $_GET['idTeam']; ?>)"><? echo $teamName; ?></h1>

    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Inici</a></li>
        <li><a href="#" onClick='clubTeamsGetList()'>Equips</a></li>
        <li><a href="#" onClick='clubPlayersGetListByTeamId(<? echo $_GET['idTeam']; ?>)'><? echo $teamName; ?></a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Nou jugador.</h3>
                </div>
                <form role="form">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="PlayerName">Nom del jugador/a</label>
                            <input type="text" class="form-control" id="playerName" placeholder="Introdueix el nom del jugador">
                            <input type="hidden" id="idTeam" value="<? echo $_GET['idTeam']; ?>" />
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="button" class="btn btn-success" onClick="clubPlayersInsert()">Guardar</button>
                    </div>
                </form>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Jugadors actuals.</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="newPlayersTable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Nom</th>
                                <th>Accio</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $playerString = 0;
                            $data = $clubs->clubsGetPlayersByIdClubAndIdTeam();
                            /* echo "<pre>";
                              print_r($data);
                              echo "</pre>"; */
                            foreach ($data as $player) {
                                $playerString = $playerString . "," . $player[0];
                                if ($player[6] == 100) {
                                    $background = "#FF7B47";
                                    $button = "<button type=\"type\" class=\"btn btn-danger\" onClick='clubPlayerEdit(" . $player[0] . ");'>Editar</button>";
                                } else {
                                    $background = "#E82C0C";
                                    $button = "<button type=\"type\" class=\"btn btn-danger\" onClick='clubPlayerEdit(" . $player[0] . ");'> Editar</button>";
                                }
                                if ($player[7] == 1) {
                                    $background = "#12FF54";
                                    $button = "<button type=\"submit\" class=\"btn btn-success\" onClick='window.open(\"../../../_management/playerCardPrint.php?idPlayer=" . $player[0] . "\")'>Imprimir</button>";
                                }
                                echo "<tr id='clubsTr_" . $player[0] . "'>";
                                echo "<td style='font-size:10px; text-align:center; font-weight:none;width:40px; background-color:$background;' >" . $player[6] . " %</td>";
                                echo "<td class='pointer' >" . $player[0] . " " . utf8_encode($player[1]) . "</td>";
                                echo "<td align=center>$button</td>";
                                echo "</tr>";
                            }
                            ?>  
                        </tbody>
                    </table>
                </div>
            </div>
            <div  class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Foto de l'equip</h3>
                </div><!-- /.box-header -->
                <?
                if (empty($teamImage)) {
                    $fU = "display:block;";
                    $fI = "display:none;";
                } else {
                    $fU = "display:none;";
                    $fI = "display:block;";
                }
                ?>
                <div id="imageUploader" style='<? echo $fU; ?>'>
                    <div id="myId" class="dropzone"></div>
                </div>
                <div id="imageContainer" style='<? echo $fI; ?>'>
                    <img src='../images/dynamic/teamsImages/<? echo $teamImage; ?>?d=<? echo time(); ?>' width=100%/><br />
                    <i class="fa fa-times-circle pointer" aria-hidden="true" onClick='clubTeamEditImageDelete(<? echo $_GET['idTeam']; ?>)'></i>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Recuperar fitxa antiga</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="oldPlayersTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>	
                                <th>Accio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $clubs->playerString = $playerString;
                            $data = $clubs->clubsGetPlayersFromAnotherSeasonByIdClubAndIdTeam();
//print_r($data);
                            foreach ($data as $player) {


                                echo "<tr id='clubsTr_" . $player[0] . "'>";
                                echo "<td >" . utf8_encode($player[1]) . "</td>";
                                echo "<td align=center><button type=\"submit\" class=\"btn btn-info\" onClick=\"clubPlayerActivateOldLicense(" . $player[0] . "," . $_GET['idTeam'] . ")\">Activar</button></td>";
                                echo "</tr>";
                            }
                            ?>  
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Recuperar fitxa d' un altre club.</h3>
                </div>
                <form role="form">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="PlayerName">DNI del jugador/a</label>
                            <input type="text" class="form-control" id="playerDNItoSearch" placeholder="Introdueix el DNI del jugador" onkeyup="clubTeamEditSearchPlayerByDni(<? echo $_GET['idTeam']; ?>)">
                            <table id="clubTeamEditSearchPlayerByDniTable" class="table table-bordered table-striped">

                            </table>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Tarjetes.</h3>
                </div>
                <div class="box-body table-responsive">
                    <table id="newPlayersTable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>

                                <th>Jugador</th>
                                <th>Grogues</th>
                                <th>Blaves</th>
                                <th>Cicle</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $data = $clubs->clubTeamCards();
                       
                            foreach ($data as $player) {
                                echo "<tr id='clubsTr_" . $player[0] . "'>";
                                echo "<td >" . utf8_encode($player[3]) . "</td>";
                                echo "<td align=center>" . $player[1] . "</td>";
                                echo "<td align=center>" . $player[2] . "</td>";
                                echo "<td align=center>" . $player[5] . "</td>";
                                echo "</tr>";
                            }
                            ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Golejadors.</h3>
                </div>
                <div class="box-body table-responsive">
                    <table id="newPlayersTable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>

                                <th>Jugador</th>
                                <th>Gols</th>
                               

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                      
                            $data = $clubs->clubTeamScorers();
                           
                            foreach ($data as $player) {
                                $playerString = $playerString . "," . $player[0];

                                echo "<tr id='clubsTr_" . $player[0] . "'>";
                                echo "<td >" . utf8_encode($player[1]) . "</td>";
                                echo "<td align=center>" . $player[0] . "</td>";
                                echo "</tr>";
                            }
                            ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

