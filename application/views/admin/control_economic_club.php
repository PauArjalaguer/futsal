<section class="content-header">
    <h1><?php echo $name; ?></h1>
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
        </div> <div class="box-body ">
            <div class="row">
                <div class="col-lg-3" >
                    <table class="table">
                        <tr>
                            <td style='border-bottom: 2px #aaa solid; font-size: 16px;'>
                                <strong>Saldo</strong>

                            </td>
                            <td style='border-bottom: 2px #aaa solid;font-size: 16px; text-align: right;'><?php
                                $total = $totalPlayersToBePaid + $totalCardsToBePaid + $totalRefereedMatchesToBePaid + $totalTeamEntriesToBePaid+$totalOthersToBePaid;
                                echo "-" . number_format($total);
                                ?> &euro;
                            </td>

                        </tr>
                        <tr>
                            <td style='border-bottom: 1px #aaa solid;'>Factures emeses</td>
                            <td style='border-bottom: 1px #aaa solid; text-align: right; font-weight: bold;'><?php
                                $total = $totalPlayers + $totalCards + $totalRefereedMatches + $totalTeamEntries+$totalOthersToBePaid;
                                echo number_format($total);
                                ?> &euro;
                            </td>
                        </tr>
                        <tr>
                            <td style='text-indent: 10px;border-bottom: 0px transparent solid;'>Inscripcions</td>
                            <td style='border-bottom: 0px #ddd solid; text-align: right;'><?php
                                echo number_format($totalTeamEntries);
                                ?> &euro;
                            </td>
                        </tr>
                        <tr>
                            <td style='text-indent: 10px;border-bottom: 0px #aaa solid;'>Fitxes</td>
                            <td style='border-bottom: 0px #ddd solid; text-align: right;'><?php
                                echo number_format($totalPlayers);
                                ?> &euro;
                            </td>
                        </tr>
                        <tr>
                            <td style='text-indent: 10px;border-bottom: 0px #aaa solid;'>Arbitratges</td>
                            <td style='border-bottom: 0px #ddd solid; text-align: right;'><?php
                                echo number_format($totalRefereedMatches);
                                ?> &euro;
                            </td>
                        </tr>
                        <tr>
                            <td style='text-indent: 10px;border-bottom: 0px #aaa solid;'>Sancions</td>
                            <td style='border-bottom: 0px #ddd solid; text-align: right;'><?php
                                echo number_format($totalCards);
                                ?> &euro;
                            </td>
                        </tr>
                         <tr>
                            <td style='text-indent: 10px;border-bottom: 0px #aaa solid;'>Altres</td>
                            <td style='border-bottom: 0px #ddd solid; text-align: right;'><?php
                                echo number_format($totalOthers);
                                ?> &euro;
                            </td>
                        </tr>


                        <tr>
                            <td style='border-bottom: 1px #aaa solid;border-top: 1px #aaa solid;'>Cobrat</td>
                            <td style='border-bottom: 1px #aaa solid; text-align: right;border-top: 1px #aaa solid; color:#0c0;'><?php
                                $totalPayed = $totalPaidPlayers + $totalPaidCards + $totalPaidRefereedMatches + $totalPaidTeamEntries+$totalPaidOthers;
                                echo number_format($totalPayed);
                                ?> &euro;
                            </td>
                        </tr>
                        <tr>
                            <td style='text-indent: 10px;border-bottom: 0px transparent solid;'>Inscripcions</td>
                            <td style='border-bottom: 0px #ddd solid; text-align: right;'><?php
                                echo number_format($totalPaidTeamEntries);
                                ?> &euro;
                            </td>
                        </tr>
                        <tr>
                            <td style='text-indent: 10px;border-bottom: 0px #aaa solid;'>Fitxes</td>
                            <td style='border-bottom: 0px #ddd solid; text-align: right;'><?php
                                echo number_format($totalPaidPlayers);
                                ?> &euro;
                            </td>
                        </tr>
                        <tr>
                            <td style='text-indent: 10px;border-bottom: 0px #aaa solid;'>Arbitratges</td>
                            <td style='border-bottom: 0px #ddd solid; text-align: right;'><?php
                                echo number_format($totalPaidRefereedMatches);
                                ?> &euro;
                            </td>
                        </tr>
                        <tr>
                            <td style='text-indent: 10px;border-bottom: 0px #aaa solid;'>Sancions</td>
                            <td style='border-bottom: 0px #ddd solid; text-align: right;'><?php
                               echo number_format($totalPaidCards);
                                ?> &euro;
                            </td>
                        </tr>
                         <tr>
                            <td style='text-indent: 10px;border-bottom: 0px #aaa solid;'>Altres</td>
                            <td style='border-bottom: 0px #ddd solid; text-align: right;'><?php
                                echo number_format($totalPaidOthers);
                                ?> &euro;
                            </td>
                        </tr>

                        <tr>
                            <td style='border-bottom: 1px #aaa solid;border-top: 1px #aaa solid;'>Pendent</td>
                            <td style='border-bottom: 1px #aaa solid; text-align: right;border-top: 1px #aaa solid; color:#c00;'><?php
                                $total = $totalPlayersToBePaid + $totalCardsToBePaid + $totalRefereedMatchesToBePaid + $totalTeamEntriesToBePaid+$totalOthersToBePaid;
                                echo number_format($total);
                                ?> &euro;
                            </td>
                        </tr>
                        <tr>
                            <td style='text-indent: 10px;border-bottom: 0px transparent solid;'>Inscripcions</td>
                            <td style='border-bottom: 0px #ddd solid; text-align: right;'><?php
                                $total = $totalPlayers + $totalCards + $totalRefereedMatches + $totalTeamEntries;
                                echo number_format($totalTeamEntriesToBePaid);
                                ?> &euro;
                            </td>
                        </tr>
                        <tr>
                            <td style='text-indent: 10px;border-bottom: 0px #aaa solid;'>Fitxes</td>
                            <td style='border-bottom: 0px #ddd solid; text-align: right;'><?php
                                $total = $totalPlayers + $totalCards + $totalRefereedMatches + $totalTeamEntries;
                                echo number_format($totalPlayersToBePaid);
                                ?> &euro;
                            </td>
                        </tr>
                        <tr>
                            <td style='text-indent: 10px;border-bottom: 0px #aaa solid;'>Arbitratges</td>
                            <td style='border-bottom: 0px #ddd solid; text-align: right;'><?php
                                $total = $totalPlayers + $totalCards + $totalRefereedMatches + $totalTeamEntries;
                                echo number_format($totalRefereedMatchesToBePaid);
                                ?> &euro;
                            </td>
                        </tr>
                        <tr>
                            <td style='text-indent: 10px;border-bottom: 0px #aaa solid;'>Sancions</td>
                            <td style='border-bottom: 0px #ddd solid; text-align: right;'><?php
                                $total = $totalPlayers + $totalCards + $totalRefereedMatches + $totalTeamEntries;
                                echo number_format($totalCardsToBePaid);
                                ?> &euro;
                            </td>
                        </tr>
                        <tr>
                            <td style='text-indent: 10px;border-bottom: 0px #aaa solid;'>Altres</td>
                            <td style='border-bottom: 0px #ddd solid; text-align: right;'><?php
                                $total = $totalPlayers + $totalCards + $totalRefereedMatches + $totalTeamEntries;
                                echo number_format($totalOthersToBePaid);
                                ?> &euro;
                            </td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr><td colspan="2" style='border-top: 2px #aaa solid; border-bottom: 1px #aaa solid;'>Ingressos</td></tr>
                        <?php
                        $totalPayments = 0;
                        foreach ($get_payments as $payment) {
                            echo "<tr><td >" . invertdateformatshort($payment->datetime) . "</td><td style='border-bottom: 0px #ddd solid; text-align: right;'>" . number_format($payment->amount) . " €</td></tr>";
                            $totalPayments = $totalPayments + $payment->amount;
                        }
                        ?><!--<div class="form-group">
                        <?php
                        $att = array('role' => 'form');
                        echo form_open('admin/control_economic/fer_ingres_admin/'.$id, $att);
                        ?>
                            <tr>
                                <td colspan="2">
                                    <div class="col-md-12">
                                        <label for="amount">Data</label>
                                        <input type="text" class="form-control" id="date" name='date' placeholder="Introdueix la data de l' ingrés">

                                    </div>
                                    <div class="col-md-12">
                                        <label for="amount">Quantitat</label>
                                        <input type="text" class="form-control" id="amount" name='amount' placeholder="Introdueix el valor de l' ingrés">

                                    </div>
                                </td>
                            </tr>
                            <tr><td colspan="2"> 
                                    <input type="submit" class="btn btn-success" value='Guardar'>
                                </td></tr>
                             <?php echo form_close(); ?>
                  
                </div>   --> 
                        </div>
                        <tr>
                            <td  style='border-top: 2px #aaa solid; border-bottom: 1px #aaa solid;'>Moneder</td>
                            <td  style='border-top: 2px #aaa solid; border-bottom: 1px #aaa solid; text-align: right;' ><?php echo number_format($totalPayments - $totalPayed); ?> €</td></tr>
                    </table>
                </div>
                <div class="col-lg-9" >
                    <?php
                    $att = array('role' => 'form');
                    echo form_open('admin/control_economic/fer_pagaments/' . $id, $att);
                    ?>
                    <table id="competitionsTable"  class="table table-bordered table-striped">       
                        <thead> 
                            <tr>
                                <th>&nbsp;</th>
                                <th>Data</th>
                                <th>Tipus</th>
                                <th>Concepte</th>
                                <th>Categoría</th>
                                <th>Import</th>
                                <th>Pendent</th>

                                <th>&nbsp;</th>
                            </tr>  
                        </thead>
                        <tbody>

                            <?php
                            $round = "";
                            $b = 0;
                            foreach ($get_economic_control_by_idClub as $row):
                                if ($row->type != 'Pagament') {
                                    $b = $b - $row->amount;
                                } else {
                                    $b = $b + $row->amount;
                                }
                                echo "\n\t\t\t\t\t\t\t<tr id='competicioTr'>";
                                echo "\n\t\t\t\t\t\t\t\t<td style='width:10px;'>";
                                if ($row->isPaid != 1) {
                                    echo "<input class='checkbox' type=\"checkbox\" name=\"item_" . $row->id . "\" value=\"" . $row->amount . "\">";
                                } else {
                                    echo "<a href=\"" . base_url() . "/admin/control_economic/assentament/" . $row->id . "\"><i class=\"fa fa-check-circle\" style='color:#0c0;'></a>";
                                }
                                echo "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td nowrap>" . invertdateformatshort($row->datetime) . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td nowrap>" . $row->type . "</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td nowrap>" . substr($row->concept, 0, 45) . "</td>";
                                 echo "\n\t\t\t\t\t\t\t\t<td nowrap>" . substr($row->name, 0, 45) . "</td>";
                                if ($row->type != 'Pagament') {
                                    $neg = "-";
                                } else {
                                    $neg = "";
                                }
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->amount . " &euro;</td>";
                                if ($b < 0) {
                                    $color = "style='color:#c00;font-weight:bold;'";
                                } else {
                                    $color = "";
                                }
                                if ($row->isPaid == 1) {
                                    $b = "0";
                                    $color = "";
                                } else {
                                    $b = $row->amount;
                                    $color = "style='color:#c00;font-weight:bold;'";
                                }
                                echo "\n\t\t\t\t\t\t\t\t<td $color>" . $b . " &euro;</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td width=1 style='color:transparent;width:1px; background-color:transparent;' width=1>" . $row->diff . "</td>";
                                echo "\n\t\t\t\t\t\t\t</tr>";

                            endforeach;
                            ?>  

                        <input type="submit" id="submit" class="btn btn-success" value='Pagar'>
                        <button id="noSubmit" class="btn btn-danger" style="display:none;">No tens prou saldo</button>

                        </tbody>
                    </table><?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var totalSelected = 0;
    var balance = <?php echo $totalPayments - $totalPayed; ?>;

    $('.checkbox').click(function () {
        if ($(this).is(':checked')) {
            totalSelected = totalSelected + parseInt($(this).prop('value'));
            $("#submit").val("Pagar " + totalSelected + " €");

        } else {
            totalSelected = totalSelected - parseInt($(this).prop('value'));
            $("#submit").val("Pagar " + totalSelected + " €");

        }
        if (totalSelected > balance) {
            $("#submit").hide();
            $("#noSubmit").show();
        } else {
            $("#submit").show();
            $("#noSubmit").hide();
        }
    });

    $("#competitionsTable").DataTable({"paging": false,
        "info": false,  "pageLength": 1000, "oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});
    //$("#competitionsTable").DataTable({"aaSortingFixed": [[6, 'asc']], "pageLength": 1000});

</script>
