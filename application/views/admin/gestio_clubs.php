<section class="content-header">
    <h1>Gestió de clubs 
    </h1>
    <ol class="breadcrumb">

        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/gestio_clubs'>"; ?> Gestio de clubs</a></li>       
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Nou club</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <?php
                        $att = array('role' => 'form');
                        echo form_open('admin/gestio_clubs/nou', $att);
                        ?>

                        <div class="col-md-12">
                            <label for="competitionName">Introdueix el nom del club</label>
                            <input type="text" class="form-control" id="clubName" name='clubName' placeholder="Introdueix el nom del club">
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
                    <h3 class="box-title">Clubs</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="competitionsTable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Accio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $round = "";
                            foreach ($get_all_clubs as $row):
                                echo "\n\t\t\t\t\t\t\t<tr>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->id . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->name . " </td>";
                                echo "\n\t\t\t\t\t\t\t\t<td><a href='".base_url()."admin/gestio_clubs/edita/".$row->id."'>Edita</a></td>";
                                echo "\n\t\t\t\t\t\t\t</tr>";
                            endforeach;
                            ?>  
                        </tbody>
                    </table>
                </div>
            </div>

        </div>


</section>
<script>
    $("#competitionsTable").DataTable({"oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});
    $('#division').select2();

</script>


