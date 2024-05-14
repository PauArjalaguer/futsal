<section class="content-header">
    <h1>Pavellons
    </h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/pavellons'>"; ?> Pavellons</a></li>

    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
              <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Nou pavelló</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <?php
                        $att = array('role' => 'form');
                        echo form_open('admin/pavellons/nou', $att);
                        ?>
                        <div class="col-md-6">
                            <label for="complexName">Nom del pavelló</label>
                            <input type="text" class="form-control" id="complexName" name='complexName' placeholder="Introdueix el nom del pavelló">
                        </div>
                         <div class="col-md-6">
                            <label for="complexAddress">Adreça del pavelló</label>
                            <input type="text" class="form-control" id="complexAddress" name='complexAddress' placeholder="Introdueix l' adreça del pavelló">
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
                    <h3 class="box-title">Pavellons</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="competitionsTable"  class="table table-bordered table-striped">          
                        <thead><tr><th>Pavelló</th><th>Adreça</th><th>&nbsp;</th></tr></thead>
                        <tbody>
                            <?php
                            $round = "";
                            foreach ($get_all_complex as $row):    
                          
                                echo "\n\t\t\t\t\t\t\t<tr id='competicioTr'>";
                                echo "\n\t\t\t\t\t\t\t\t<td><a href='". base_url()."admin/pavellons/edita/".$row->id."'>" . $row->complexName . " </a></td><td> " . $row->complexAddress . "</td><td>";
                                 if($row->revisar==1){ echo "<i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i>";}
                               
                                echo "\n\t\t\t\t\t\t\t</td></tr>";
                             
                            endforeach;
                            ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>
<script>
    $("#competitionsTable").DataTable({"pageLength": 100, "oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});
  
</script>


