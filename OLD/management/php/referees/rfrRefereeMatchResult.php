<?
include("../../Classes/db.inc");
include("../../Classes/News_Class.php");
include("../../Classes/Competition_Class.php");
$cmpt = new Competition();
$cmpt->idMatch = $_GET['idMatch'];
//echo $_GET['idMatch'];
$data = $cmpt->cmptGetResultsByMatchId();
$idLocal = $data[5];
$idVisitor = $data[6];
$comment=$data[7];
//print_r($data);
$positions = $cmpt->cmptPositions();
$cmpt->idTeam = $idLocal;
$localPlayers = $cmpt->cmptGetPlayersListByIdMatch();
$cmpt->idTeam = $idVisitor;
$visitorPlayers = $cmpt->cmptGetPlayersListByIdMatch();
?>     
<div class="box">

    <div class="box-header">
        <h3 class="box-title" onClick="rfrRefereeMatchResult(<? echo $data[0]; ?>)">Resultats</h3>
    </div><!-- /.box-header -->
    <div class="row">
        <div class="col-lg-6" style='text-align: right; font-size:24px; font-weight: bolder;'>
            <? echo utf8_encode($data[1]); ?><br />
			<input type='hidden' value=<? echo $data[3]; ?> id='rfrMatchPrevLocalResult' />
			<input type='hidden' value=<? echo $data[8]; ?> id='idLocal' />
            <input type='text' onkeyup='rfrRefereeMatchResultInsert(<? echo $data[0]; ?>);' id='rfrMatchLocalResult' style='width:100px; height:100px; font-weight: bold; font-size: 64px; text-align: center;' value="<? echo $data[3]; ?>">
			<? 
			$cmpt->idTeam=$idLocal;
			$dataG=$cmpt->cmptGoalsByMatchAndTeam();
			
			foreach($dataG as $goals){
				echo "<br />\n\t<select style='width:225px ;height:30px; padding:0; margin:0; margin-top:5px;' id='rfrRefereesGoalPlayer_". $_GET['idMatch'] . "_" . $goals[3] . "' onChange='rfrRefereesGoalPlayerUpdate(" . $_GET['idMatch'] . "," . $goals[3] . ");'><option>Selecciona un jugador</option>";
				foreach($localPlayers as $p){
					if($goals[0]==$p[0]){ $selected=" selected ";}else {$selected="";}
					if($p[4]>0){
						echo "\n\t\t<option $selected value=\"".$p[0]."\"> ".utf8_encode($p[1])."</option>";
					}
				}
				echo "</select>\n\t<input id='rfrRefereesGoalMinute_". $_GET['idMatch'] . "_" . $goals[3] . "' onKeyUp='rfrRefereesGoalPlayerUpdate(" . $_GET['idMatch'] . "," . $goals[3] . ");' style='width:35px ;height:30px; padding:0; margin:0;' type='text' value=\"".$goals[2]."\">";
			}
		
			?>
		</div>
        <div class="col-lg-6" style='text-align: left; font-size:24px; font-weight: bolder;'>
            <? echo utf8_encode($data[2]); ?><br />
			<input type='hidden' value=<? echo $data[4]; ?> id='rfrMatchPrevVisitorResult' />
						<input type='hidden' value=<? echo $data[9]; ?> id='idVisitor' />
            <input type='text' onkeyup='rfrRefereeMatchResultInsert(<? echo $data[0]; ?>);' id='rfrMatchVisitorResult' style='width:100px; height:100px; font-weight: bold; font-size: 64px; text-align: center;' value="<? echo $data[4]; ?>">
				<? 
			$cmpt->idTeam=$idVisitor;
			$dataG=$cmpt->cmptGoalsByMatchAndTeam();
			
			foreach($dataG as $goals){
				echo "<br />\n\t<select style='width:225px ;height:30px; padding:0; margin:0; margin-top:5px;' id='rfrRefereesGoalPlayer_". $_GET['idMatch'] . "_" . $goals[3] . "' onChange='rfrRefereesGoalPlayerUpdate(" . $_GET['idMatch'] . "," . $goals[3] . ");'><option>Selecciona un jugador</option>";
				foreach($visitorPlayers as $p){
					if($goals[0]==$p[0]){ $selected=" selected ";}else {$selected="";}
					if($p[4]>0){
						echo "\n\t\t<option $selected value=\"".$p[0]."\"> ".utf8_encode($p[1])."</option>";
					}
				}
				echo "</select>\n\t<input id='rfrRefereesGoalMinute_". $_GET['idMatch'] . "_" . $goals[3] . "' onKeyUp='rfrRefereesGoalPlayerUpdate(" . $_GET['idMatch'] . "," . $goals[3] . ");' style='width:35px ;height:30px; padding:0; margin:0;' type='text' value=\"".$goals[2]."\">";
			}
		
			?>
			</div>
   </div>
    <div class="row">
        <div class="col-lg-12" style="margin:10px;">
            <div id="myId" class="dropzone"></div>
        </div>
        <div class="col-lg-6">


            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <tr>    

                        <th>Jugador</th>

                        <th style='text-align: center;'><i class="fa fa-check-square-o "></i></th>
                        <th style='text-align: center;'>C</th>
                        <th style='text-align: center;'><i class="fa fa-sort-numeric-asc"></i></th>
                        <th style='text-align: center;'><i class="fa fa-sticky-note" style='color:#ffcc00;'></i></th>

                        <th style='text-align: center;'><i class="fa fa-sticky-note" style='color:#00b;'></i></th>
                        <th>Posici&oacute;</th>
                    </tr>
                    <?
                    //$cmpt->idTeam = $idLocal;
                   // $data = $cmpt->cmptGetPlayersListByIdMatch();

                    foreach ($localPlayers as $player) {
                        if ($team != $player[5]) {
                            echo "<tr><td colspan=7 align=center style='font-weight:bold;'> " . $player[5] . "</td>";
                        }
                        $player[1] = substr($player[1], 0, 20);
                        echo "\n<tr>";
                        echo "\n\t<td style>" . utf8_encode($player[1]) . "</td>";

                        if ($player[4] > 0) {
                            $c = "checked";
                            $d = "";
                        } else {
                            $c = "";
                            $d = "disabled";
                        }
                        if ($player[12] > 0) {
                            $cap = "checked";
                        } else {
                            $cap = "";
                        }
                        echo "\n\t<td style='text-align: center;'>\n\t\t<input $c type='checkbox' onClick='rfrRefereesPlayerMatchInsert(" . $_GET['idMatch'] . "," . $player[0] . "," . $idLocal . ",0);' style='width:25px;' id=\"rfrRefereesPlayerMatchInsertRadio_" . $_GET['idMatch'] . "_" . $player[0] . "_" . $idLocal . "\" />\n\t</td>";
                        echo "\n\t<td  style='text-align: center;'>\n\t\t<input $cap $d type='checkbox' onClick='rfrRefereesPlayerMatchInsertCaptain(" . $_GET['idMatch'] . "," . $player[0] . "," . $idLocal . ",1);' style='width:25px;' id=\"rfrRefereesPlayerMatchInsertCaptainRadio_" . $_GET['idMatch'] . "_" . $player[0] . "_" . $idLocal . "\" />\n\t</td>";
							//echo "\n\t<td align=center>\n\t\t<input  $d onKeyUp='rfrRefereesPlayersGoalsMatchInsert(" . $_GET['idMatch'] . "," . $player[0] . "," . $idLocal . ");' style='width:25px;border:1px solid #d0d0d0; text-align:center; background-color:transparent;' type='text' id='rfrRefereesGoalsPerPlayer_" . $player[0] . "_" . $idLocal . "' value=\"" . $player[7] . "\"></td>";
					    echo "\n\t<td align=center>\n\t\t<input  $d onKeyUp='rfrRefereesPlayerNumberUpdate(" . $_GET['idMatch'] . "," . $player[0] . "," . $idLocal . ");' style='width:25px;border:1px solid #d0d0d0; text-align:center; background-color:transparent;' type='text' id='rfrRefereesNumberPerPlayer_" . $player[0] . "_" . $idLocal . "' value=\"" . $player[7] . "\"></td>";
                        echo "\n\t<td align=center>\n\t\t<input $d onKeyUp='rfrRefereesPlayersGoalsCardInsert(" . $_GET['idMatch'] . "," . $player[0] . "," . $idLocal . ",\"yellow\");'  type='text' style='width:25px;border:1px solid #d0d0d0; text-align:center; background-color:transparent;' id='rfrRefereesCardsPerPlayer_" . $player[0] . "_" . $idLocal . "_yellow' value=\"" . $player[8] . "\"></td>";
                        echo "\n\t<td align=center>\n\t\t<input $d onKeyUp='rfrRefereesPlayersGoalsCardInsert(" . $_GET['idMatch'] . "," . $player[0] . "," . $idLocal . ",\"blue\");'  type='text' style='width:25px;border:1px solid #d0d0d0; text-align:center; background-color:transparent;' id='rfrRefereesCardsPerPlayer_" . $player[0] . "_" . $idLocal . "_blue' value=\"" . $player[9] . "\"></td>";
                        echo "\n\t<td>\n\t\t\t<select $d id='rfrRefereesPlayerPosition_" . $_GET['idMatch'] . "_" . $player[0] . "_" . $idLocal . "' onChange='rfrRefereesPlayerPositionUpdate(" . $_GET['idMatch'] . "," . $player[0] . "," . $idLocal . ");'>";
                        foreach ($positions as $p) {
                            if ($player[11] == 0) {
                                if ($p[0] == $player[10]) {
                                    $s = "selected";
                                } else {
                                    $s = 0;
                                }
                            } else {
                                if ($p[0] == $player[11]) {
                                    $s = "selected";
                                } else {
                                    $s = 0;
                                }
                            }
                            echo "\n\t\t\t\t<option value=\"" . $p[0] . "\" $s >" . $p[1] . "</option>";
                        }
                        echo "\n\t\t</select>\n\t</td>";
                        echo "\n</tr>";
                        $team = $player[5];
                    }
                    ?>

                </table>
            </div>
        </div>
        <div class="col-lg-6" align="right" >
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <tr>
                        <th>Jugador</th>
                        <th style='text-align: center;'><i class="fa fa-check-square-o "></i></th>
                        <th style='text-align: center;'>C</th>
                           <th style='text-align: center;'><i class="fa fa-sort-numeric-asc"></i></th>
                        <th style='text-align: center;'><i class="fa fa-sticky-note" style='color:#ffcc00;'></i></th>
                        <th style='text-align: center;'><i class="fa fa-sticky-note" style='color:#00b;'></i></th>
                        <th>Posici&oacute;</th></tr>
                    <?
                    //$cmpt->idTeam = $idVisitor;
                    //$data = $cmpt->cmptGetPlayersListByIdMatch();
// print_r($data);
                    foreach ($visitorPlayers as $player) {
                         if ($team != $player[5]) {
                            echo "<tr><td colspan=7 align=center style='font-weight:bold;'> " . $player[5] . "</td>";
                        }
                        if ($player[4] > 0) {
                            $c = "checked";
                            $d = "";
                        } else {
                            $c = "";
                            $d = "disabled";
                        }
                        if ($player[12] > 0) {
                            $cap = "checked";
                        } else {
                            $cap = "";
                        }
                        $player[1] = substr($player[1], 0, 20);
                        /* echo "<tr>";
                          echo "\n\t<td style>" . utf8_encode($player[1]) . "</td>";
                          echo "\n\t<td>" . utf8_encode($player[5]) . "</td>";
                          echo "\n\t<td><input $c type='checkbox' onClick='rfrRefereesPlayerMatchInsert(" . $_GET['idMatch'] . "," . $player[0] . "," . $player[6] . ");' style='width:25px;' id=\"rfrRefereesPlayerMatchInsertRadio_" . $_GET['idMatch'] . "_" . $player[0] . "_" . $player[6] . "\"/></td>";
                          echo "\n\t<td><input onKeyUp='rfrRefereesPlayersGoalsMatchInsert(" . $_GET['idMatch'] . "," . $player[0] . "," . $player[6] . ");' style='width:25px;border:1px solid #d0d0d0; text-align:center; background-color:transparent;' type='text' id='rfrRefereesGoalsPerPlayer_" . $player[0] . "_" . $player[6] . "' value=\"" . $player[7] . "\"></td>";
                          echo "\n\t<td><input $d onKeyUp='rfrRefereesPlayersGoalsCardInsert(" . $_GET['idMatch'] . "," . $player[0] . "," . $player[6] . ",\"yellow\");'  type='text' style='width:25px;border:1px solid #d0d0d0; text-align:center; background-color:transparent;' id='rfrRefereesCardsPerPlayer_" . $player[0] . "_" . $player[6] . "_yellow' value=\"" . $player[8] . "\"></td>";
                          echo "\n\t<td><input $d onKeyUp='rfrRefereesPlayersGoalsCardInsert(" . $_GET['idMatch'] . "," . $player[0] . "," . $player[6] . ",\"blue\");'  type='text' style='width:25px;border:1px solid #d0d0d0; text-align:center; background-color:transparent;' id='rfrRefereesCardsPerPlayer_" . $player[0] . "_" . $player[6] . "_blue' value=\"" . $player[9] . "\"></td>";
                         */
                         echo "<tr>\n\t<td style>" . utf8_encode($player[1]) . "</td>";
                        echo "\n\t<td style='text-align: center;'>\n\t\t<input $c type='checkbox' onClick='rfrRefereesPlayerMatchInsert(" . $_GET['idMatch'] . "," . $player[0] . "," . $idVisitor . ",0);' style='width:25px;' id=\"rfrRefereesPlayerMatchInsertRadio_" . $_GET['idMatch'] . "_" . $player[0] . "_" . $idVisitor . "\" />\n\t</td>";
                        echo "\n\t<td  style='text-align: center;'>\n\t\t<input $cap $d type='checkbox' onClick='rfrRefereesPlayerMatchInsertCaptain(" . $_GET['idMatch'] . "," . $player[0] . "," . $idVisitor . ",1);' style='width:25px;' id=\"rfrRefereesPlayerMatchInsertCaptainRadio_" . $_GET['idMatch'] . "_" . $player[0] . "_" . $idVisitor . "\" />\n\t</td>";
                      //  echo "\n\t<td>\n\t\t<input $d onKeyUp='rfrRefereesPlayersGoalsMatchInsert(" . $_GET['idMatch'] . "," . $player[0] . "," . $idVisitor . ");' style='width:25px;border:1px solid #d0d0d0; text-align:center; background-color:transparent;' type='text' id='rfrRefereesGoalsPerPlayer_" . $player[0] . "_" . $idVisitor . "' value=\"" . $player[7] . "\"></td>";
                        echo "\n\t<td align=center>\n\t\t<input  $d onKeyUp='rfrRefereesPlayerNumberUpdate(" . $_GET['idMatch'] . "," . $player[0] . "," . $idVisitor . ");' style='width:25px;border:1px solid #d0d0d0; text-align:center; background-color:transparent;' type='text' id='rfrRefereesNumberPerPlayer_" . $player[0] . "_" . $idVisitor . "' value=\"" . $player[7] . "\"></td>";
                        
echo "\n\t<td>\n\t\t<input $d onKeyUp='rfrRefereesPlayersGoalsCardInsert(" . $_GET['idMatch'] . "," . $player[0] . "," . $idVisitor . ",\"yellow\");'  type='text' style='width:25px;border:1px solid #d0d0d0; text-align:center; background-color:transparent;' id='rfrRefereesCardsPerPlayer_" . $player[0] . "_" . $idVisitor . "_yellow' value=\"" . $player[8] . "\"></td>";
                        echo "\n\t<td>\n\t\t<input $d onKeyUp='rfrRefereesPlayersGoalsCardInsert(" . $_GET['idMatch'] . "," . $player[0] . "," . $idVisitor . ",\"blue\");'  type='text' style='width:25px;border:1px solid #d0d0d0; text-align:center; background-color:transparent;' id='rfrRefereesCardsPerPlayer_" . $player[0] . "_" . $idVisitor . "_blue' value=\"" . $player[9] . "\"></td>";
                        echo "\n\t<td>\n\t\t\t<select $d id='rfrRefereesPlayerPosition_" . $_GET['idMatch'] . "_" . $player[0] . "_" . $idVisitor . "' onChange='rfrRefereesPlayerPositionUpdate(" . $_GET['idMatch'] . "," . $player[0] . "," . $idVisitor . ");'>";
                        foreach ($positions as $p) {
                            if ($player[11] == 0) {
                                if ($p[0] == $player[10]) {
                                    $s = "selected";
                                } else {
                                    $s = 0;
                                }
                            } else {
                                if ($p[0] == $player[11]) {
                                    $s = "selected";
                                } else {
                                    $s = 0;
                                }
                            }
                            echo "\n\t\t\t\t<option value=\"" . $p[0] . "\" $s >" . $p[1] . "</option>";
                        }
                        echo "\n\t\t</select>\n\t</td>";
                        echo "\n</tr>";
                          $team = $player[5];
                    }
                    ?>

                </table>
            </div>
        </div>

    </div>
<hr />
    <div class="row">
        <div class="col-lg-12"  style='background-color: #fff; margin:20px;' >

            <textarea style='width: 100%; height:180px;' id="comment" placeholder='Omplir només si hi ha hagut incidencies al partit'><? echo stripcslashes(utf8_decode($comment)); ?></textarea>
            <input type='button' value='Enviar comentari' onClick="rfrRefereesPlayersMatchCommentSave(<? echo $_GET['idMatch']; ?>)" />
        </div>
    </div>



</div>	