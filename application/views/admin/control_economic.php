<section class="content-header">
    <h1>Control economic
    </h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/control_economic'>"; ?> Control economic</a></li>       
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if($balance<0){ $box="box box-danger"; $msg="<h3>Saldo  de $balance &euro; .</h3>Regularitzeu el saldo, el més aviat possible.<hr />"; } else{$box="box box-primary"; $msg=$balance. "&euro;<hr />";} ?>
            <div class="<?php echo $box; ?>">
                <div class="box-header with-border">
                    <h3 class="box-title">Saldo</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="form-group">
                        <?php
                        $att = array('role' => 'form');
                        echo form_open('admin/control_economic/ingres', $att);
                        ?>

                        <div class="col-md-12">
                            <label for="amount">Quantitat</label>
                            <input type="text" class="form-control" id="amount" name='amount' placeholder="Introdueix la quantitat a ingressar">
                            <input type="hidden" name="idClub" value="<?php echo $idClub; ?>">
                        </div>
                       
                    </div>
                </div>
                  <div class="box-footer">
                    <input type="submit" class="btn btn-success" value='Guardar'></button>
                </div>             
                <?php echo form_close(); ?>
            </div>
            <div class="box box-primary" style='display:none;'>
                <div class="box-header with-border">
                    <h3 class="box-title">Jugadors pendents de validació</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="competitionsTable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Equip</th>
                                <th>Preu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $round = "";
                            foreach ($get_unpayed_players as $row):

                                echo "\n\t\t\t\t\t\t\t<tr id='competicioTr'>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->playerName . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->teamName . " </td>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->rate . " </td>";
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
    });
</script>


