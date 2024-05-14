<section class="content-header">
    <h1>Control economic
    </h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/control_economic/admin'>"; ?> Control economic</a></li>       
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php //if($balance<0){ $box="box box-danger"; $msg="<h3>Saldo  de $balance &euro; .</h3>Regularitzeu el saldo, el més aviat possible.<hr />"; } else{$box="box box-primary"; $msg=$balance. "&euro;<hr />";} ?>
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Pagaments</h3>
                </div><!-- /.box-header -->
                <div class="box-body">

                    <div class="form-group">
                        <?php
                        $att = array('role' => 'form');
                        echo form_open('admin/control_economic/ingres_verifica', $att);
                        ?>

                        <div class="col-md-6">
                            <label for="amount">Codi</label>
                            <input type="text" class="form-control" id="code" name='code' placeholder="Introdueix el codi de l' ingrés">

                        </div>
                        <div class="col-md-6">
                            <label for="amount">Quantitat</label>
                            <input type="text" class="form-control" id="amount" name='amount' placeholder="Introdueix el valor de l' ingrés">

                        </div>

                    </div>
                </div>
                <div class="box-footer">
                    <input type="submit" class="btn btn-success" value='Guardar'></button>
                </div>             
                <?php echo form_close(); ?>
            </div>
            <div class="box box-primary" >
                <div class="box-header with-border">
                    <h3 class="box-title">Clubs amb moviments</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="competitionsTable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>                                   
                                <th>Nom</th>                              
                               
                                <th>Moneder</th>
                                <th>Emès</th>
                                <th>Cobrat</th>
                                <th>Pendent</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $round = "";
                            foreach ($clubs_with_negative_balance as $row):
                                $sum = $row->totalPaid + $row->totalPending + $row->available;
                                if ($sum <> 0) {
                                    echo "\n\t\t\t\t\t\t\t<tr id='competicioTr'>";
                                    echo "\n\t\t\t\t\t\t\t\t<td><a href='" . base_url() . "admin/Control_economic/club/" . $row->id . "'>" . $row->name . "</a></td>";
                                    
                                    echo "\n\t\t\t\t\t\t\t\t<td style='text-align:right;'>" . number_format($row->available) . " &euro;</td>";
                                    echo "\n\t\t\t\t\t\t\t\t<td style='text-align:right;'>" . number_format($row->totalPaid + $row->totalPending) . " &euro;</td>";
                                    echo "\n\t\t\t\t\t\t\t\t<td style='text-align:right;'>" . number_format($row->totalPaid) . " &euro;</td>";
                                    echo "\n\t\t\t\t\t\t\t\t<td style='text-align:right;'>" . number_format($row->totalPending) . " &euro;</td>";
                                    echo "\n\t\t\t\t\t\t\t</tr>";
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
    $("#competitionsTable").DataTable({"oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});
            $('#division').select2();
    });
</script>


