
<section class="content-header">
    <h1>Competicions
    </h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/competicio'>"; ?> Competicions</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Nova competició.</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <?php
                        $att = array('role' => 'form');
                        echo form_open('admin/competicio/nova', $att);
                        ?>

                        <div class="col-md-6">
                            <label for="competitionName">Competició</label>
                            <input type="text" class="form-control" id="competitionName" name='competitionName' placeholder="Introdueix el nom de la competició">
                        </div>
                        <div class="col-md-6">
                            <label for="division">Categoría</label>
                            <select class="form-control" name='division' id="division">
                                <option>&nbsp;</option>
                                <?php
                                foreach ($get_divisions as $row):
                                    echo "<option  value=" . $row->id . ">" . $row->name . "</option>";
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
                    <h3 class="box-title">Competicions actuals</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="competitionsTable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $playerString = 0;
                            foreach ($get_leagues_by_idSeason as $row):
                                if ($row->status == 0) {
                                    $background = "#900";
                                } else if ($row->status == 1) {
                                    $background = '#009';
                                } else {
                                    $background = '#090';
                                }
                                echo "\n\t\t\t\t\t\t\t<tr id='competicioTr_" . $row->id . "'>";
                                echo "\n\t\t\t\t\t\t\t\t<td  ><a href='". base_url()."admin/competicio/calendari/".$row->id."' style='color:$background;
                                '>" . $row->name . " </a></td>";
                                 echo "\n\t\t\t\t\t\t\t\t<td align=right ><a href='". base_url()."admin/competicio/".$row->id."' ><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a></td>";
                               
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
    $("#competitionsTable").DataTable({"oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});
    $('#division').select2();
</script>


