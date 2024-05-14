<section class="content-header">
    <h1> <?php
        //echo "<pre>"; print_r(get_defined_vars()); echo "</pre>";
        echo $localName . " - " . $visitorName . ". <br /><span style='font-size:12px; '>Partit de la jornada $roundName de $leagueName</span>";
        ?>
    </h1>
    <ol class="breadcrumb">

        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/arbitre'>"; ?> Partits designats</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php
            if ($accepted['accepted'] == 1) {
                $s1 = "display:none;";
            } else {
                $s2 = "display:none;";
            }
            ?>
            <div class="box box-success" style='<?php echo $s1; ?>'>
                <div class="box-header with-border">Acceptar el partit</div>
                <div class="box-body">

                    <a href='<?php echo base_url() . "admin/arbitre/accepta_partit/" . $id . "/" . $idReferee; ?>'><button type="submit" class="btn btn-success ">Acceptar el partit</button></a> &nbsp;&nbsp;
                    <a href='<?php echo base_url() . "admin/arbitre/rebutja_partit/" . $id . "/" . $idReferee; ?>'><button type="submit" class="btn btn-danger" >Rebutjar el partit</button></a>
                </div>
            </div>
            <div class="box box-success" style='<?php echo $s2; ?>'>
                <div class="box-header with-border">Resultat</div>
                <div class="box-body">
                    <div align="center"><?php
                        $att = array('role' => 'form', 'id' => 'resultat');
                        echo form_open('admin/competicio/modifica_resultat/' . $id . "/arbitre", $att);
                        ?>
                        <table border="0">
                            <tr>
                                <td>
                                    <img height=100 src="http://v3.futsal.cat/webImages/clubsImages/<?php echo $localImage; ?>">
                                </td>
                                <td >
                                    <input  type="hidden" value="<?php echo $idLocal; ?>" name="idLocal">
                                    <input value="<?php echo $localResult; ?>" name="localResult" type="number" style="margin-left:40px;border:1px solid #ddd; font-size:54px; width:100px; height:100px; text-align: center;"> 
                                </td>
                                <td>:</td>
                                <td> 
                                    <input  type="hidden"  value="<?php echo $idVisitor; ?>" name="idVisitor">
                                    <input value="<?php echo $visitorResult; ?>" name="visitorResult" type="number" style="margin-right:40px;border:1px solid #ddd; font-size:54px; width:100px; height:100px;text-align: center;"> </td>
                                <td>
                                    <img height=100 src="http://v3.futsal.cat/webImages/clubsImages/<?php echo $visitorImage; ?>">
                                </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td colspan="2" valign="top" align="right">                                       
                                    <?php
                                    foreach ($localGoals as $row) {
                                        echo " \n\t<select class=\"form-control select2 playerSelect\" style=\"width: 200px;\" id=\"" . $row->idGoal . "\"><option>Selecciona un jugador</option>";
                                        foreach ($localPlayers as $row_p) {
                                            if ($row->idPlayer == $row_p->id) {
                                                $s = "selected";
                                            } else {
                                                $s = "";
                                            }
                                            echo "\n\t\t<option $s value='" . $row_p->id . "'>" . $row_p->name . " </option>";
                                        } echo "</select><br />";
                                    }
                                    ?>

                                </td>
                                <td>&nbsp;</td>
                                <td colspan="2" valign="top">                                       
                                    <?php
                                    foreach ($visitorGoals as $row) {
                                        echo " \n\t<select class=\"form-control select2 playerSelect\" style=\"width: 200px;\" id=\"" . $row->idGoal . "\"><option>Selecciona un jugador</option>";
                                        foreach ($visitorPlayers as $row_p) {
                                            if ($row->idPlayer == $row_p->id) {
                                                $s = "selected";
                                            } else {
                                                $s = "";
                                            }
                                            echo "\n\t\t<option $s value='" . $row_p->id . "'>" . $row_p->name . "</option>";
                                        } echo "</select><br />";
                                    }
                                    ?>

                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
                <div class="box box-footer">
                    <input type="submit" class="btn btn-info pull-right" value="Modificar resultat" />
                <?php echo form_close(); ?>
                </div> <?php
                if ($localResult && $statusId != 4) {
                    echo "<a href=\"" . base_url() . "admin/competicio/tancar_partit/" . $id . "\"><button type=\"button\" class=\"btn btn-danger\">Tancar partit</button></a>";
                }
                ?> 
            </div>
        </div>
    </div>
    <div class="box box-warning" style='<?php echo $s2; ?>'>
        <div class="box-header with-border">Acta</div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-condensed" id="playersTable">
                        <thead><tr>
                                <th>&nbsp;</th>
                                <th>Dorsal</th>                                           
                                <th>Jugador</th>
                                <th>DNI</th>
                                <th>TG</th>
                                <th>TB</th>
                                <th>Cap</th>                                            
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //echo "<pre>"; print_r(get_defined_vars()); echo "</pre>";
                            foreach ($localPlayers as $row) {
                                if ($row->idTeam) {
                                    $s = 'checked';
                                }
                                echo "\n<tr>\n\t<td style=\"width: 40px\"><input $s class='playersInput' id='active_" . $row->id . "_" . $id . "_$idLocal' type='checkbox'>&nbsp;</td>";
                                $s = "";
                                echo "\n\t<td style=\"width: 40px\"><input class='playersInput' id='number_" . $row->id . "_" . $id . "_$idLocal' style=\"width: 40px\" value=\"" . $row->number . "\" type='number' style=\"width: 30px; text-align:center;\"></td>";
                                echo "\n\t<td><img src='http://v3.futsal.cat/images/dynamic/playersImages/" . $row->image . "' width=20>";
                                echo "\n\t &nbsp; " . $row->name . "</td>";
                                echo "\n\t<td>" . $row->dni . "</td>";

                                echo "\n\t<td style=\"width: 20px\"><input value='" . $row->yellowCards . "' class='playersInput' id='yellowCards_" . $row->id . "_" . $id . "_$idLocal' style=\"width: 40px\" type='number'>&nbsp;</td>";
                                echo "\n\t<td style=\"width: 20px\"><input value='" . $row->blueCards . "' class='playersInput' id='blueCards_" . $row->id . "_" . $id . "_$idLocal' style=\"width: 40px\" type='number'>&nbsp;</td>";
                                if ($row->isCaptain) {
                                    $s = 'checked';
                                }
                                echo "\n\t<td style=\"width: 20px\"><input $s class='playersInput' id='isCaptain_" . $row->id . "_" . $id . "_$idLocal' type='checkbox' >&nbsp;</td>";
                                echo "\n</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-condensed" id="playersTable2">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Dorsal</th>                                           
                                <th>Jugador</th>
                                <th>DNI</th>
                                <th>TG</th>
                                <th>TB</th>
                                <th>Cap</th>
                            </tr></thead>
                        <tbody>
                            <?php
                            //echo "<pre>"; print_r(get_defined_vars()); echo "</pre>";
                            foreach ($visitorPlayers as $row) {
                                if ($row->idTeam) {
                                    $s = 'checked';
                                }
                                echo "\n<tr>\n\t<td style=\"width: 40px\"><input $s class='playersInput' id='active_" . $row->id . "_" . $id . "_$idVisitor' type='checkbox'>&nbsp;</td>";
                                $s = "";
                                echo "\n\t<td style=\"width: 40px\"><input class='playersInput' id='number_" . $row->id . "_" . $id . "_$idVisitor' style=\"width: 40px\" value=\"" . $row->number . "\" type='number' style=\"width: 30px; text-align:center;\"></td>";
                                echo "\n\t<td><img src='http://v3.futsal.cat/images/dynamic/playersImages/" . $row->image . "' width=20>";
                                echo "\n\t &nbsp; " . $row->name . "</td>";
                                echo "\n\t<td>" . $row->dni . "</td>";

                                echo "\n\t<td style=\"width: 20px\"><input value='" . $row->yellowCards . "' class='playersInput' id='yellowCards_" . $row->id . "_" . $id . "_$idVisitor' style=\"width: 40px\" type='number'>&nbsp;</td>";
                                echo "\n\t<td style=\"width: 20px\"><input value='" . $row->blueCards . "' class='playersInput' id='blueCards_" . $row->id . "_" . $id . "_$idVisitor' style=\"width: 40px\" type='number'>&nbsp;</td>";
                                if ($row->isCaptain) {
                                    $s = 'checked';
                                }
                                echo "\n\t<td style=\"width: 20px\"><input $s class='playersInput' id='isCaptain_" . $row->id . "_" . $id . "_$idVisitor' type='checkbox' >&nbsp;</td>";
                                echo "\n</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-warning" style='<?php echo $s2; ?>'>
        <div class="box-header with-border">Incidencies</div>
        <?php
        $att = array('role' => 'form', 'id' => 'resultat');
        echo form_open('admin/competicio/introdueix_incidencia/' . $id, $att);
        ?>
        <div class="box-body" >
            <input type="textarea" name="comment" style='vertical-align: text-top;width:100%; height:185px; border:0;' value='<?php echo $comment; ?>'>
        </div>
        <div class="box box-footer">
            <input type="submit" class="btn btn-info pull-right" value="Enviar incidencia" />
<?php echo form_close(); ?>
        </div> 
    </div>
</div>
</div>
</section>
<script>
    $("#playersTable, #playersTable2").DataTable({"oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});
    $('.select2').select2( );
    $('#datepicker').datepicker({dateFormat: 'dd-mm-yy',
        autoclose: true
    })
    $(".playerSelect")
            .change(function () {
                var idPlayer = "";
                idGoal = $(this).attr('id');
                // alert(idGoal);
                idPlayer = $(this).val() + " ";
                var param = "idGoal=" + idGoal + "&idPlayer=" + idPlayer;
                var request = $.ajax({
                    url: "<?php echo base_url(); ?>admin/competicio/actualitza_gol",
                    type: "POST",
                    data: param,
                    dataType: "html"

                });


            })
    //$(".playersInput").change(function () {
    $('#playersTable,#playersTable2').on('change', '.playersInput', function () {
        if ($(this).prop('checked')) {
            checked = 1;
        } else {
            checked = 0;
        }

        id = $(this).attr('id');
        // alert(idGoal);
        value = $(this).val() + " ";

        if ((value >= 1) || (checked == 1)) {
            var arr = id.split("_");
            var active_id = 'active_' + arr[1] + "_" + arr[2] + "_" + arr[3];
            if (arr[0] != 'active') { // alert(active_id);
                $("#" + active_id).prop('checked', true);
            }
        }
        var param = "item=" + id + "&value=" + value + "&checked=" + checked;

        var request = $.ajax({
            url: "<?php echo base_url(); ?>admin/competicio/actualitza_dades_acta",
            type: "POST",
            data: param,
            dataType: "html"

        });


    })

</script>
