<section class="content-header">
    <h1><?php echo "<a href='" . base_url() . "admin/equip/$idTeam'>$teamName"; ?>
        </a>
    </h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/equips'>"; ?> Equips</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/equip/$idTeam'>$teamName"; ?></a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Nou jugador.</h3>
                </div>
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
                            foreach ($get_players_by_idTeam_and_idClub as $row):
                                $playerString = $playerString . "," . $row->id;
                                if ($row->statusPercent == 100) {
                                    $background = "#FF7B47";
                                    $button = "\n\t\t\t\t\t\t\t\t\t\t<a href='".base_url()."admin/jugador/edita/".$row->id."'><button type=\"type\" class=\"btn btn-danger\" >Editar</button></a>";
                                } else {
                                    $background = "#E82C0C";
                                    $button = "\n\t\t\t\t\t\t\t\t\t\t<a href='".base_url()."admin/jugador/edita/".$row->id."'><button type=\"type\" class=\"btn btn-danger\");'> Editar</button></a>";
                                }
                                if ($row->isPayed == 1) {
                                    $background = "#12FF54";
                                    $button = "\n\t\t\t\t\t\t\t\t\t\t<button type=\"submit\" class=\"btn btn-success\" onClick='window.open(\"../../../_management/playerCardPrint.php?idPlayer=" . $row->id . "\")'>Imprimir</button>";
                                }
                                echo "\n\t\t\t\t\t\t\t<tr id='clubsTr_" . $row->id . "'>";
                                echo "\n\t\t\t\t\t\t\t\t<td style='font-size:10px; text-align:center; font-weight:none;width:40px; background-color:$background;' >" . $row->statusPercent . " %</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td class='pointer' >" . $row->id . " " . $row->playerName . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td align=center>$button \n\t\t\t\t\t\t\t\t</td>";
                                echo "\n\t\t\t\t\t\t\t</tr>";
                            endforeach;
                            ?>  
                        </tbody>
                    </table>
                </div>
            </div>
            <div  class="box box-info" style='display:none;'>
                <div class="box-header">
                    <h3 class="box-title">Foto de l'equip</h3>
                </div><!-- /.box-header -->
                <?php
                if (empty($teamImage)) {
                    $fU = "display:block;";
                    $fI = "display:none;";
                } else {
                    $fU = "display:none;";
                    $fI = "display:block;";
                }
                ?>
                <div id="imageUploader" style='<?php echo $fU; ?>'>
                    <div id="myId" class="dropzone"></div>
                </div>
                <div id="imageContainer" style='<?php echo $fI; ?>'>
                    <img src='../images/dynamic/teamsImages/<?php echo $teamImage; ?>?d=<?php echo time(); ?>' width=100%/><br />
                    <i class="fa fa-times-circle pointer" aria-hidden="true" onClick='clubTeamEditImageDelete(<?php echo $idTeam; ?>)'></i>
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
                            $this->load->model('admin/equips_model');
                            $p = $this->equips_model->get_players_from_previousSeason_by_idTeam_and_idClub($idTeam, $idClub, $playerString);
                            foreach ($p as $row):
                                echo "\n\t\t\t\t\t\t\t<tr id='clubsTr_" . $row->id . "'>";
                                echo "\n\t\t\t\t\t\t\t\t<td >" . $row->name . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td align=center><a href='".base_url()."admin/jugador/activa/" . $row->id . "/" . $idTeam . "'><button type=\"submit\" class=\"btn btn-info\" \">Activar</button></td>";
                                echo "\n\t\t\t\t\t\t\t</tr>";
                            endforeach;
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
                            <input type="text" class="form-control" id="playerDNItoSearch" placeholder="Introdueix el DNI del jugador" onkeyup="clubTeamEditSearchPlayerByDni(<?php echo $idTeam; ?>)">
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
                            foreach ($get_cards_by_idTeam as $row):
                                echo "\n\t\t\t\t\t\t\t<tr id='clubsTr_" . $row->id . "'>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->name . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td align=center>" . $row->yellow . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td align=center>" . $row->blue . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td align=center>" . $row->lastCicle . "</td>";
                                echo "\n\t\t\t\t\t\t\t</tr>";
                            endforeach;
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
                            foreach ($get_scorers_by_idTeam as $row) :
                                echo "\n\t\t\t\t\t\t\t<tr id='clubsTr_" . $row->id . "'>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->name . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td align=center>" . $row->goals . "</td>";
                                echo "\n\t\t\t\t\t\t\t</tr>";
                            endforeach;
                            ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $("#newPlayersTable").DataTable({"oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});
    $("#oldPlayersTable").DataTable({"oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});
    var myDropzone = new Dropzone("div#myId", {
        url: "php/clubs/clubTeamEditPhotoUploader.php?idTeam=" + id,
        success: function (file, response) {
            //lubPlayersGetListByTeamId(id);

        }
    });
</script>


