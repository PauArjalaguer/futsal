<section class="content-header">
    <h1><?php echo $complexName; ?>
    </h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/pavellons'>"; ?> Pavellons</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/pavellons/edita/$id'>"; ?> <? echo $complexName; ?></a></li>
        <li><?php echo "<a href='" . base_url() . "admin/pavellons/fusiona/$id'>"; ?> Fusiona</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Pavellons</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="competitionsTable"  class="table table-bordered table-striped">          
                        <thead><tr><th>Pavelló</th><th>Adreça</th></tr></thead>
                        <tbody>
                            <?php
                            $round = "";
                            foreach ($get_all_complex as $row):
                                if ($id != $row->id) {
                                    echo "\n\t\t\t\t\t\t\t<tr id='competicioTr'>";
                                    echo "\n\t\t\t\t\t\t\t\t<td><a style='color:#900;' href='" . base_url() . "admin/pavellons/fusiona_pavello/" . $row->id . "/" . $id . "'>" . $row->complexName . " </a></td>";
                                    echo "\n\t\t\t\t\t\t\t\t<td><a style='color:#900;' href='" . base_url() . "admin/pavellons/fusiona_pavello/" . $row->id . "/" . $id . "'> " . $row->complexAddress . "</a></td>";
                                  
                                    echo "\n\t\t\t\t\t\t\t</td></tr>";
                                }
                            endforeach;
                            ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>
<script>
    $("#competitionsTable").DataTable({ "bStateSave": true,"pageLength": 100,  "oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});

</script>


