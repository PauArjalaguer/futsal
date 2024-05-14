<section class="content-header">
    <h1> <?php
        //echo "<pre>"; print_r(get_defined_vars()); echo "</pre>";
        echo $localName . " - " . $visitorName . ". <br /><span style='font-size:12px; '>Partit de la jornada $roundName de $leagueName</span>";
        ?>
    </h1>
    <ol class="breadcrumb">

        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/competicio'>"; ?> Competicions</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/competicio/" . $idLeague . "'> $leagueName"; ?> </a></li>
        <li><?php echo "<a href='" . base_url() . "admin/competicio/calendari/" . $idLeague . "'>"; ?> Calendari</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/competicio/partit/" . $id . "'>$localName - $visitorName"; ?> </a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">Dades del partit</div>
                <?php
                $d = explode(" ", $updateddatetime);
                $date = $d[0];
                $hour = $d[1];
                $att = array('role' => 'form', 'id' => 'partit');
                echo form_open('admin/competicio/modifica_partit/' . $id, $att);
                ?>
                <div class="box-body">

                    <div class="col-md-4"
                         <div class="form-group">
                            <label>Data:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input disabled name="matchDate" type="text" class="form-control pull-right" id="datepicker" value="<?php echo invertdateformat($date); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Hora:</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input disabled name="matchHour" type="text" class="form-control" value="<?php echo $hour; ?>">                                          
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Pavelló</label>
                                <select disabled class="form-control select2" style="width: 100%;" name="matchComplex">
                                    <?php
                                    foreach ($get_all_complex as $row):
                                        if ($row->id == $idComplex) {
                                            $s = "selected";
                                        } else {
                                            $s = "";
                                        }
                                        echo "\n\t<option value=\"" . $row->id . "\" $s>" . $row->complexName . " (" . $row->complexAddress . " " . $row->complexCity . ")</option>";
                                    endforeach;
                                    ?>
                                </select>
                            </div>

                        </div>
                        <?php
                        /* echo "<pre>";
                          print_r($referees_by_match);
                          echo "</pre>"; */
                        ?>
                        <div class="col-lg-4">
                            <label>Àrbitre:</label> 
                            <select  disabled class="form-control select2" style="width: 100%;" name="matchReferee1"><option></option>
                                <?php
                                $ref = $referees_by_match[0]->idReferee;
                                foreach ($referees as $row):
                                    if ($row->id == $ref) {
                                        $s = "selected";
                                    } else {
                                        $s = "";
                                    }
                                    echo "\n\t\t\t<option value=\"" . $row->id . "\" $s>" . $row->name . " (" . $row->delegationName . ")</option>";
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label>Àrbitre:</label> 
                            <select  disabled class="form-control select2" style="width: 100%;" name="matchReferee2"><option></option>
                                <?php
                                if ($referees_by_match[1]->idRefereeType == 2) {
                                    $ref = $referees_by_match[1]->idReferee;
                                } else {
                                    $ref = "";
                                }
                                foreach ($referees as $row):
                                    if ($row->id == $ref) {
                                        $s = "selected";
                                    } else {
                                        $s = "";
                                    }
                                    echo "\n\t\t\t<option value=\"" . $row->id . "\" $s>" . $row->name . " (" . $row->delegationName . ")</option>";
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label>Taula:</label>
                            <select disabled class="form-control select2" style="width: 100%;" name="matchReferee3"><option></option>
                                <?php
                                if ($referees_by_match[1]->idRefereeType == 3) {
                                    $ref = $referees_by_match[1]->idReferee;
                                }
                                if ($referees_by_match[2]->idRefereeType == 3) {
                                    $ref = $referees_by_match[2]->idReferee;
                                }
                                foreach ($referees as $row):
                                    if ($row->id == $ref) {
                                        $s = "selected";
                                    } else {
                                        $s = "";
                                    }
                                    echo "\n\t<option value=\"" . $row->id . "\" $s>" . $row->name . " (" . $row->delegationName . ")</option>";
                                endforeach;
                                ?>
                            </select>
                        </div>
                      
                         <div class="col-lg-12"><label>Comentari:</label>
                            <p style='margin-top:3px;padding:12px;border:1px solid #900;'><?php echo $comment; ?></p>
                        </div>
                    </div>
                    <?php echo form_close(); ?>

                </div><!-- /.box-header -->

                <div class="box box-success">
                    <div class="box-header with-border">Resultat</div>
                    <div class="box-body">
                        <div align="center"><?php
                            $att = array('role' => 'form', 'id' => 'resultat');
                            echo form_open('admin/competicio/modifica_resultat/' . $id . "/admin", $att);
                            ?>
                            <table border="0">
                                <tr>
                                    <td>
                                        <img height=100 src="http://v3.futsal.cat/webImages/clubsImages/<?php echo $localImage; ?>">
                                    </td>
                                    <td >
                                        <input  type="hidden" value="<?php echo $idLocal; ?>" name="idLocal">
                                        <input disabled value="<?php echo $localResult; ?>" name="localResult" type="number" style="margin-left:40px;border:1px solid #ddd; font-size:54px; width:100px; height:100px; text-align: center;"> 
                                    </td>
                                    <td>:</td>
                                    <td> 
                                        <input  type="hidden"  value="<?php echo $idVisitor; ?>" name="idVisitor">
                                        <input disabled value="<?php echo $visitorResult; ?>" name="visitorResult" type="number" style="margin-right:40px;border:1px solid #ddd; font-size:54px; width:100px; height:100px;text-align: center;"> </td>
                                    <td>
                                        <img height=100 src="http://v3.futsal.cat/webImages/clubsImages/<?php echo $visitorImage; ?>">
                                    </td>
                                </tr>
                                <tr><td>&nbsp;</td></tr>
                                <tr>
                                    <td colspan="2" valign="top" align="right">                                       
                                        <?php
                                        foreach ($localGoals as $row) {
                                            echo " \n\t<select disabled class=\"form-control select2 playerSelect\" style=\"width: 200px;\" id=\"" . $row->idGoal . "\"><option>Selecciona un jugador</option>";
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
                                            echo " \n\t<select  disabled class=\"form-control select2 playerSelect\" style=\"width: 200px;\" id=\"" . $row->idGoal . "\"><option>Selecciona un jugador</option>";
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
                        <div class="box box-footer">

                            <?php echo form_close(); ?>
                        </div>
                    </div>

                </div>
                <div class="box box-warning">
                    <div class="box-header with-border">Acta</div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-condensed strie" id="playersTable">
                                    <thead><tr>
                                            <th>&nbsp;</th>
                                            <th>Dorsal</th>                                           
                                            <th>Jugador</th>
                                            <th>DNI</th>
                                            <th>TG</th>
                                            <th>TB</th>
                                            <th>Cap</th>     
                                            <th>Equip</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //echo "<pre>"; print_r(get_defined_vars()); echo "</pre>";
                                        foreach ($localPlayers as $row) {
                                            if ($row->idTeam) {
                                                $s = 'checked';
                                            }
                                            if ($row->teamName != $teamName) {
                                                //echo "<tr><td colspan=6>".$row->teamName."</td></tr>";
                                            }
                                            $teamName = $row->teamName;
                                            echo "\n<tr>\n\t<td style=\"width: 40px\"><input disabled $s class='playersInput' id='active_" . $row->id . "_" . $id . "_$idLocal' type='checkbox'>&nbsp;</td>";
                                            $s = "";
                                            echo "\n\t<td style=\"width: 40px\"><input disabled  class='playersInput' id='number_" . $row->id . "_" . $id . "_$idLocal' style=\"width: 40px\" value=\"" . $row->number . "\" type='number' style=\"width: 30px; text-align:center;\"></td>";
                                            echo "\n\t<td><img src='http://v3.futsal.cat/images/dynamic/playersImages/" . $row->image . "' width=20>";
                                            echo "\n\t &nbsp; " . $row->name . "</td>";
                                            echo "\n\t<td>" . $row->dni . "</td>";

                                            echo "\n\t<td style=\"width: 20px\"><input disabled value='" . $row->yellowCards . "' class='playersInput' id='yellowCards_" . $row->id . "_" . $id . "_$idLocal' style=\"width: 40px\" type='number'>&nbsp;</td>";
                                            echo "\n\t<td style=\"width: 20px\"><input disabled value='" . $row->blueCards . "' class='playersInput' id='blueCards_" . $row->id . "_" . $id . "_$idLocal' style=\"width: 40px\" type='number'>&nbsp;</td>";
                                            if ($row->isCaptain) {
                                                $s = 'checked';
                                            }
                                            echo "\n\t<td style=\"width: 20px\"><input  disabled $s class='playersInput' id='isCaptain_" . $row->id . "_" . $id . "_$idLocal' type='checkbox' >&nbsp;</td>";
                                            echo "\n<td>" . $row->teamName . "</td>";
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
                                            <th>Equip</th>
                                        </tr></thead>
                                    <tbody>
                                        <?php
                                        //echo "<pre>"; print_r(get_defined_vars()); echo "</pre>";
                                        foreach ($visitorPlayers as $row) {
                                            if ($row->idTeam) {
                                                $s = 'checked';
                                            }
                                            echo "\n<tr>\n\t<td style=\"width: 40px\"><input disabled $s class='playersInput' id='active_" . $row->id . "_" . $id . "_$idVisitor' type='checkbox'>&nbsp;</td>";
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
                                            echo "\n<td>" . $row->teamName . "</td>";
                                            echo "\n</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<script>

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

    var table = $('#playersTable,#playersTable2').DataTable({"pageLength": 100, "oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}},
        "columnDefs": [
            {"visible": false, "targets": 7}
        ],
        "order": [[7, 'asc']],
        "displayLength": 25,
        "drawCallback": function (settings) {
            var api = this.api();
            var rows = api.rows({page: 'current'}).nodes();
            var last = null;

            api.column(7, {page: 'current'}).data().each(function (group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                            '<tr class="group"><td colspan="8"><h4>' + group + '</h4></td></tr>'
                            );

                    last = group;
                }
            });
        }
    });

    // Order by the grouping
    $('#playersTable tbody').on('click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if (currentOrder[0] === 7 && currentOrder[1] === 'asc') {
            table.order([7, 'desc']).draw();
        } else {
            table.order([7, 'asc']).draw();
        }
    });


</script>
