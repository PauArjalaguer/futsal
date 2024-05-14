<section class="content-header">
    <h1><? echo $name; ?>
    </h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/competicio'>"; ?> Competicions</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/competicio/" . $id . "'>" . $name; ?></a></li>
    </ol>
</section>
<?php //echo "<pre>"; print_r(get_defined_vars()); echo "</pre>"; ?>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Editar competició.</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <?php
                        $att = array('role' => 'form');
                        echo form_open('admin/competicio/modifica_estat_lliga', $att);
                        ?>

                        <div class="col-md-6">
                            <label for="competitionName">Competició</label>
                            <input type="text" class="form-control" id="competitionName" name='competitionName' placeholder="Introdueix el nom de la competició" value="<?php echo $name; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="division">Categoría</label>
                             <input type="hidden" name="idLeague" value="<?php echo $id; ?>" />
                            <input type="hidden" name="statusSelect" value="<?php echo $status; ?>" />
                            <select class="form-control" name='idDivision' id="idDivision">
                                <option>&nbsp;</option>
                                <?php
                                foreach ($get_divisions as $row):
                                    if ($idDivision == $row->id) {
                                        $s = "selected";
                                    } else {
                                        $s = "";
                                    }
                                    echo "\n\t<option $s value=" . $row->id . ">" . $row->name . "</option>";
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="submit" class="btn btn-success" value='Guardar'></button>
                </div>             
                <?php echo form_close(); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Calendari </h3>
                </div>
                <div class="box-body">
                    <?php if($status==4){
                        echo "<a href='".base_url()."admin/competicio/generar_calendari/".$id."/2'> Generar calendari.</a><br />";
                         echo "<a href='".base_url()."admin/competicio/generar_calendari/".$id."/1'> Generar calendari a una volta.</a><hr />";
                        } ?>
                    <a href="<?php echo base_url(); ?>admin/competicio/calendari/<?php echo $id; ?>"> Veure calendari.</a></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Equips </h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <div class="col-md-12">
                        <?php
                        $att = array('role' => 'form');
                        echo form_open('admin/competicio/introduir_equip', $att);
                        ?>
                        <label for="teamsSelect">Equips</label>
                        <input type="hidden" name="idLeague" value="<?php echo $id; ?>" />
                        <select class="form-control js-example-basic-single" name='teamsSelect' id="teamsSelect" onchange="this.form.submit()">
                            <option>&nbsp;</option>
                            <?php
                            foreach ($get_all_teams as $row):
                                echo "\n\t\t\t\t\t\t\t<option  value=" . $row->id . ">" . $row->name . "</option>";
                            endforeach;
                            ?>
                        </select>
                        <?php echo form_close(); ?>
                    </div>&nbsp;
                    <ul id="sortable">
                        <?php
                        $n = 0;
                        foreach ($get_teams_by_idLeague as $row):
                            $n++;
                            echo "\n\t<li id=\"item_" . $row->id . "\">" . $row->name;
                            echo " &nbsp; <a href='" . base_url() . "admin/competicio/eliminar_equip/" . $id . "/" . $row->id . "'>Eliminar</a>";
                            echo "</li>";
                        endforeach;
                        ?>  
                    </ul>

                </div>
            </div>

        </div>


</section>
<script>
    // $("#competitionsTable").DataTable({"lengthMenu": [20, 50, 75, 100], "oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "lengthMenu": [50, 75, 100], "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});
    $('#teamsSelect').select2();
    $('#division').select2();
    $("#sortable").sortable({
        update: function (event, ui) {
            var data = $(this).sortable('serialize');
            // POST to server using $.post or $.ajax
            $.ajax({
                data: data,
                type: 'POST',
                url: '<?php echo base_url(); ?>admin/competicio/ordenar/<?php echo $id; ?>'
                            });
                        }
                    });

</script>
   <?php // echo "<pre>"; print_r(get_defined_vars()); echo "</pre>"; ?>

