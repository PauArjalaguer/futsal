<section class="content-header">
    <h1>Calendari <?php echo $name; ?>
    </h1>
    <ol class="breadcrumb">

        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/competicio'>"; ?> Competicions</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/competicio/" . $id . "'> $name"; ?> </a></li>
        <li><?php echo "<a href='" . base_url() . "admin/competicio/calendari" . $id . "'>"; ?> Calendari</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Calendari</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="competitionsTable"  class="table table-bordered table-striped">
                        <tbody>
                            <?php
                            $round = "";
                            foreach ($get_calendar as $row):
                                if ($row->roundName != $round) {
                                    echo "\n<tr>\n\t<td colspan=1 style='font-weight:bold;'>JORNADA " . $row->roundName . "</td>";
                                    $att = array('role' => 'form', 'id' => 'myform_' . $row->roundId);
                                    echo "\n\t<td colspan=5>";
                                    echo form_open('admin/competicio/generar_jornada/' . $id . "/" . $row->roundId, $att);

                                    echo " \n\t<input type='hidden' name='idLeague' value='" . $row->idLeague . "'>";
                                    echo "<input type='text' placeholder='Data inici jornada'  name='initialDate' value='" . invertdateformat($row->initialDate) . "'>";
                                    echo "&nbsp;\n\t<input  disabled type='text' placeholder='Data final jornada' name='endDate' value='" . invertdateformat($row->endDate) . "'> \n\t<input type='submit' value='Generar jornada'>";
                                    echo form_close();
                                    echo "</td></tr>";
                                }
                                echo "\n\t\t\t\t\t\t\t<tr id='competicioTr'>";
                                echo "\n\t\t\t\t\t\t\t\t<td><a href='" . base_url() . "admin/gestio_clubs/equip/" . $row->idLocal . "/" . $row->localClub . "'>" . $row->local . " </a></td><td><a href='" . base_url() . "admin/gestio_clubs/equip/" . $row->idVisitor . "/" . $row->visitorClub . "'>" . $row->visitor . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td align=center>" . $row->localResult ." - " . $row->visitorResult . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . invertdateformat($row->updateddatetime) . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->complexName . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->rfr . " arbitre designat</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td><a href=\"" . base_url() . "admin/competicio/partit/" . $row->idMatch . "\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a></td>";
                                echo "\n\t\t\t\t\t\t\t</tr>";
                                $round = $row->roundName;
                            endforeach;
                            ?>  
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Estat de la lliga</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <?php
                    $att = array('role' => 'form');
                    echo form_open('admin/competicio/modifica_estat_lliga', $att);
                    ?>
                    <input type="hidden" name="idLeague" value="<?php echo $id; ?>">
                    <input type="hidden" name="competitionName" value="<?php echo $name; ?>" />
                    <input type="hidden" name="idDivision" value="<?php echo $idDivision; ?>" />
                    <select class="form-control js-example-basic-single" name='statusSelect' id="statusSelect" onchange="this.form.submit()">
                        <option>&nbsp;</option>
                        <?php
                        foreach ($get_all_status as $row):
                            if ($status == $row->id) {
                                $s = "selected";
                            } else {
                                $s = "";
                            }
                            echo "\n\t\t\t\t\t\t\t<option $s value=" . $row->id . ">" . $row->status . "</option>";
                        endforeach;
                        ?>
                    </select>
                    <?php echo form_close(); ?>
                </div>
            </div>
            </section>
            <script>
                $("#competitionsTable").DataTable({"oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});
                $('#division').select2();
                });
            </script>
            <?php // echo "<pre>"; print_r(get_defined_vars()); echo "</pre>"; ?>


