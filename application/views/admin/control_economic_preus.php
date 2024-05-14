<section class="content-header">
    <h1 ><?php
?>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?><i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/gestio_clubs'>"; ?> Gestió de clubs</a></li>     
        <li class="active"><?php echo $name; ?></li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Control econòmic</h3>
        </div>
        <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <tr><th>Divisió</th><th>Fitxa</th><th>Inscripció</th><th>Arbitratge</th><th>Preu àrbitre</th><th>Preu àrbitre 2</th><th>Preu taula</th><th>Tarjeta groga</th><th>Tarjeta blava</th></tr>
                <?php
                foreach ($divisions as $row) {
                    echo "<tr>\n\t\t\t\t\t<td style='font-weight:bold;'>" . $row->name . "</td>";
                    $d = $this->Control_economic_model->get_player_price_by_idDivision($row->id);
                    echo "\n\t\t\t\t\t<td align=center><input class='field' id='player/" . $row->id . "/1' style='border:0; background-color:transparent; width:40px;' type='text' value='" . $d['rate'] . "'></td>";
                    $d = $this->Control_economic_model->get_team_price_by_idDivision($row->id);
                    echo "\n\t\t\t\t\t<td align=center><input class='field' id='team/" . $row->id . "/1' style='border:0; background-color:transparent; width:40px;' type='text' value='" . $d['rate'] . "'></td>";
                    $d = $this->Control_economic_model->get_referee_price_by_idDivision($row->id);
                    echo "\n\t\t\t\t\t<td align=center><input class='field' id='referee/" . $row->id . "/1' style='border:0; background-color:transparent; width:40px;' type='text' value='" . $d['rate'] . "'></td>";
                    $d = $this->Control_economic_model->get_referee_fee_by_idDivision($row->id, 1);
                    echo "\n\t\t\t\t\t<td align=center><input class='field' id='referee_fee/" . $row->id . "/1' style='border:0; background-color:transparent; width:40px;' type='text' value='" . $d['price'] . "'></td>";
                    $d = $this->Control_economic_model->get_referee_fee_by_idDivision($row->id, 2);
                    echo "\n\t\t\t\t\t<td align=center><input class='field' id='referee_fee/" . $row->id . "/2' style='border:0; background-color:transparent; width:40px;' type='text' value='" . $d['price'] . "'></td>";
                   $d = $this->Control_economic_model->get_referee_fee_by_idDivision($row->id, 3);
                    echo "\n\t\t\t\t\t<td align=center><input class='field' id='referee_fee/" . $row->id . "/3' style='border:0; background-color:transparent; width:40px;' type='text' value='" . $d['price'] . "'></td>";
                     
                    $d = $this->Control_economic_model->get_card_by_idDivision($row->id);
                                     echo "\n\t\t\t\t\t<td align=center><input class='field' id='cards/1/1' style='border:0; background-color:transparent; width:40px;' type='text' value='" . $d['yellowCardRate'] . "'></td>";
                    echo "\n\t\t\t\t\t<td align=center><input class='field' id='cards/2/2' style='border:0; background-color:transparent; width:40px;' type='text' value='" . $d['blueCardRate'] . "'>";
                    echo "</td>";
                    echo "\n\t\t\t\t</tr>\n\t\t\t\t";
                }
                ?>
            </table>
        </div>
    </div>
</section>
<script>
    $("#competitionsTable").DataTable({"aaSorting": [5, 'asc'], "pageLength": 1000, "oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});

    $(".field").blur(
            function () {
                var id = $(this).attr('id');
                var value = $(this).val();
              
                var ajax= $.ajax("<?php echo base_url(); ?>admin/Control_economic/modifica_preus/"+id+"/"+value);
            })
</script>
<style>.field{text-align: center;}</style>