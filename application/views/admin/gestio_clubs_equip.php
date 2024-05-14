<section class="content-header">
    <?php //echo "<pre>"; print_r(get_defined_vars()); ?>
    <h1> <?php echo $teamName; ?>
    </h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/gestio_clubs'>"; ?> Gestio de clubs</a></li>
         
          <li><?php echo "<a href='" . base_url() . "admin/gestio_clubs/equip/" . $idTeam . "/" . $this->uri->segment(5)."'>$teamName"; ?></a></li>  
    </ol>
</section>
<section class="content">
    <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Nou jugador</h3>
                </div><!-- /.box-header -->
               <div class="box-body">
                    <div class="form-group">
                        <?php
                        $att = array('role' => 'form');
                        echo form_open('admin/jugador/nou', $att);
                        ?>
                        <label for="PlayerName">Nom del jugador/a</label>
                        <input type="text" class="form-control" id="playerName" name='playerName' placeholder="Introdueix el nom del jugador">
                        <input type="hidden" id="idTeam" name="idTeam" value="<?php echo $idTeam; ?>" />
                    </div>
                </div>
                  <div class="box-footer">
                    <input type="submit" class="btn btn-success" value='Guardar'></button>
                </div>             
                <?php echo form_close(); ?>
            </div>
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Plantilla</h3>
        </div>
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
                    foreach ($get_players_by_idTeam_and_idClub as $row):
                        $playerString = $playerString . "," . $row->id;
                        if ($row->statusPercent == 100) {
                            $background = "#FF7B47";
                            $button = "\n\t\t\t\t\t\t\t\t\t\t<a href='" . base_url() . "admin/gestio_clubs/verifica_jugador/" . $row->id . "/".$idTeam."/".$this->uri->segment(5)."'><button type=\"type\" class=\"btn btn-danger\" >Editar</button></a>";
                        } else {
                            $background = "#E82C0C";
                            $button = "\n\t\t\t\t\t\t\t\t\t\t<a href='" . base_url() . "admin/gestio_clubs/verifica_jugador/" . $row->id . "/".$idTeam."/".$this->uri->segment(5)."'><button type=\"type\" class=\"btn btn-danger\");'> Editar</button></a>";
                        }
                        if ($row->isPayed == 1) {
                            $background = "#12FF54";
                            $button = "\n\t\t\t\t\t\t\t\t\t\t<button type=\"submit\" class=\"btn btn-success\" onClick='window.open(\"../../../_management/playerCardPrint.php?idPlayer=" . $row->id . "\")'>Imprimir</button>";
                        }
                        echo "\n\t\t\t\t\t\t\t<tr id='clubsTr_" . $row->id . "'>";
                        echo "\n\t\t\t\t\t\t\t\t<td style='font-size:10px; text-align:center; font-weight:none;width:60px; background-color:$background;' >" . $row->statusPercent . " %</td>";
                        echo "\n\t\t\t\t\t\t\t\t<td class='pointer' ><a href='" . base_url() . "admin/gestio_clubs/verifica_jugador/" . $row->id . "/".$idTeam."/".$this->uri->segment(5)."'>" . $row->id . " " . $row->playerName . "</a></td>";
                        echo "\n\t\t\t\t\t\t\t\t<td align=center>$button \n\t\t\t\t\t\t\t\t</td>";
                        echo "\n\t\t\t\t\t\t\t</tr>";
                    endforeach;
                    ?>  
                </tbody>
            </table>
        </div>

    </div>
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Informació de l' equip</h3>
        </div>
        <div class="box-body">
            <?php
            $att = array('role' => 'form', 'id' => 'form');
            echo form_open('admin/gestio_clubs/modifica_equip/' . $idTeam . "/" . $this->uri->segment(5), $att);
            ?>
            <div id="clubDataContainer" class="" >
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="playingDay">Dia de joc</label>
                            <select class="form-control" name='playingDay' id="playingDay">
                                <option>&nbsp;</option>
                                <option id="6" value="6" <?php
                                if ($playingDay == 6) {
                                    echo "selected";
                                }
                                ?>>Dissabte</option>
                                <option id="7" value="7" <?php
                                if ($playingDay == 7) {
                                    echo "selected";
                                }
                                ?>>Diumenge</option>
                            </select></div> 
                    </div>
                    <div class="col-md-4" >
                        <label>Hora de joc</label>
                        <input name='playingHour' class="form-control" value="<?php echo $playingHour; ?>">
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pavelló</label>
                            <select class="form-control select2" style="width: 100%;" id='playingComplex' name="playingComplex">
                                <option></option>
                                <?php
                                foreach ($get_all_complex as $row):
                                    if ($row->id == $playingComplex) {
                                        $s = "selected";
                                    } else {
                                        $s = "";
                                    }
                                    echo "\n\t<option value=\"" . $row->id . "\" $s>" . $row->complexName . " (" . $row->complexAddress . " )</option>";
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>   
                </div>
            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-lg btn-info" value='Desar'>
                <?php echo form_close(); ?>
            </div>
        </div>

    </div>

</section>

<script>  $('#playingComplex').select2();</script>