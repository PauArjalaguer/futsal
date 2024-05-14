<section class="content-header">
    <h1>Àrbitres
    </h1>
    <ol class="breadcrumb">

        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/arbitres'>"; ?> Àrbitres</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Nou àrbitre.</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <?php
                        $att = array('role' => 'form');
                        echo form_open('admin/arbitres/nou', $att);
                        ?>

                        <div class="col-md-4">
                            <label for="competitionName">Nom</label>
                            <input type="text" class="form-control" id="refereeName" name='refereeName' placeholder="Introdueix el nom de l' àrbitre.">
                        </div>
                         <div class="col-md-4">
                            <label for="refereeEmail">Email</label>
                            <input type="text" class="form-control" id="refereeEmail" name='refereeEmail' placeholder="Introdueix email de l' àrbitre.">
                        </div>
                        <div class="col-md-4">
                            <label for="delegation">Delegació</label>
                            <select class="form-control" name='delegation' id="delegation">
                                <option>&nbsp;</option>
                                <?php
                                foreach ($get_delegations as $row):
                                    echo "<option  value=" . $row->idDelegation . ">" . $row->delegationName . "</option>";
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
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Llistat</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="competitionsTable"  class="table table-bordered table-striped">      
                        <thead><tr><th>&nbsp;</th><th>Nom</th><th>Acció</th></thead>
                        <tbody>
                            <?php
                            $delegation = "";
                            foreach ($get_all_referees as $row):

                                if ($delegation != $row->delegationName) {
                                    // echo "<tr ><td colspan=2><strong>".$row->delegationName."</td></tr>";
                                }
                                echo "\n\t\t\t\t\t\t\t<tr >";
                                echo "<td ><strong>" . $row->delegationName . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->name . " </td>";

                                echo "\n\t\t\t\t\t\t\t\t<td align=center>";
                                echo "<a href=\"" . base_url() . "admin/arbitre/edita/" . $row->id . "\"><i class=\"fa fa-pencil-square-o fa-fw\" aria-hidden=\"true\"></i></a>";

                                echo "<a href=\"" . base_url() . "admin/control_economic/arbitre/" . $row->id . "\"><i class=\"fa fa-eur \" aria-hidden=\"true\"></i></a>";
                                echo "</td>";
                                echo "\n\t\t\t\t\t\t\t</tr>";
                                $delegation = $row->delegationName;
                            endforeach;
                            ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

</section>
<script>
    $("#competitionsTable").DataTable({ "pageLength": 100, "bSort" : false, "oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});

</script>


