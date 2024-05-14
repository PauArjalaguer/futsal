<section class="content-header">
    <h1> <?php
        //  echo "<pre>";print_r(get_defined_vars()); echo "</pre>";
        if ($_SESSION['logged_in']['idClub'] == $idClub) {
            $local = 0;
        } else {
            $local = 1;
        }
        echo $localName . " - " . $visitorName . ". <br /><span style='font-size:12px; '>Partit de la jornada $roundName de $leagueName</span>";
        ?>
    </h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/gestio_partits'>"; ?> Gestio de partits</a></li>       
        <li><?php echo "<a href='" . base_url() . "admin/gestio_partits/partit/" . $id . "'> $localName - $visitorName"; ?> </a></li>
    </ol>
</section>
<section class="content">
    <div class="row" <?php
    if ($local == 0) {
        echo "style='display:none;'";
    }
    ?>>
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">Dades del partit</div>
                <?php
                $d = explode(" ", $updateddatetime);
                $date = $d[0];
                $hour = $d[1];
                $att = array('role' => 'form', 'id' => 'partit');
                echo form_open('admin/gestio_partits/modifica_partit/' . $id, $att);
                ?>
                <div class="box-body">
                    <div class="col-md-4"
                         <div class="form-group">
                            <label>Data:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input  name="matchDate" type="text" class="form-control pull-right" id="datepicker" value="<?php echo invertdateformat($date); ?>">
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
                                        <input name="matchHour" type="text" class="form-control" value="<?php echo $hour; ?>">                                          
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Pavelló</label>
                                <select class="form-control select2" style="width: 100%;" name="matchComplex">
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
                        <div class='col-lg-12' <?php
                        if ($statusId != 1) {
                            echo "style='display:none;'";
                        }
                        ?>>
                            <br /><input type="submit" class="btn btn-info pull-right" value="Guardar" />
                        </div>
                    </div>
<?php echo form_close(); ?>

                </div><!-- /.box-header -->



            </div>
        </div>
        <div class="row" <?php
if ($local == 1) {
    echo "style='display:none;'";
}
?>>
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header with-border">Canvi de data</div>
                    <?php
                    $d = explode(" ", $get_last_date_change_by_idMatch['updateddatetime']);
                    $original_date = $d[0];
                    $original_hour = $d[1];

                    $d = explode(" ", $get_last_date_change_by_idMatch['datetime']);
                    $date = $d[0];
                    $hour = $d[1];
                    $att = array('role' => 'form', 'id' => 'partit');
                    echo form_open('admin/gestio_partits/modifica_partit/' . $id, $att);
                    ?>
                    <div class="box-body">
                        <div class="col-md-4"
                             <div class="form-group">
                                <label>Data original:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input  disabled name="originalMatchDate" type="text" class="form-control pull-right" id="dateapicker" value="<?php echo invertdateformat($original_date); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Hora original:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input disabled name="originalMatchHour" type="text" class="form-control" value="<?php echo $original_hour; ?>">                                          
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
                            <div class="col-md-4"
                                 <div class="form-group">
                                    <label>Data proposada:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input  disabled name="matchDate" type="text" class="form-control pull-right" id="dateapicker" value="<?php echo invertdateformat($date); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <label>Hora proposada:</label>
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
                                    &nbsp; <br /><input type="submit" class="btn btn-info pull-right" value="Acceptar" />
                                </div>  
                                <div class='col-lg-12' <?php
                                        if ($statusId != 1) {
                                            echo "style='display:none;'";
                                        }
                                        ?>>

                                </div>
                            </div>
<?php echo form_close(); ?>

                        </div><!-- /.box-header -->



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
