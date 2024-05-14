<section class="content-header">
    <h1>Calendari <?php echo $name; ?>
    </h1>
    <ol class="breadcrumb">

        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/gestio_partits'>"; ?> Gestio de partits</a></li>       
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
                            foreach ($get_matches_by_idClub as $row):
                                if ($row->roundName != $round) {
                                    // echo "\n<tr>\n\t<td colspan=1 style='font-weight:bold;'>JORNADA " . $row->roundName . "</td>";
                                   // echo "\n\t<td colspan=6>";
                                    //echo "</td></tr>";
                                }
                                if($row->matchChange>0){
                                    $alert=" <i style='color:#c00;' class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i> ";
                                }else{
                                    $alert="";
                                }
                                echo "\n\t\t\t\t\t\t\t<tr id='competicioTr'>";
                                echo "\n\t\t\t\t\t\t\t\t<td>$alert" . $row->idMatch . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->local . " </td><td> " . $row->visitor . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . invertdateformat($row->updateddatetime) . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->complexName . "</td>";
                                // if ($row->days <6) {
                                if ($row->days != 0) {
                                    echo "\n\t\t\t\t\t\t\t\t<td align=center><a href=\"" . base_url() . "admin/gestio_partits/partit/" . $row->idMatch . "\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a></td>";
                                } else {
                                    echo "\n\t\t\t\t\t\t\t\t<td align=center><i class=\"fa fa-lock\" aria-hidden=\"true\"></i></td>";
                                }
                                echo "\n\t\t\t\t\t\t\t</tr>";
                                $round = $row->roundName;
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
    });
</script>


