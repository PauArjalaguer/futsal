<section class="content-header">
    <h1>Partits per designar
    </h1>
    <ol class="breadcrumb">

        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/competicio'>"; ?> Competicions</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/competicio/" . $id . "'> $name"; ?> </a></li>
        <li><?php echo "<a href='" . base_url() . "admin/competicio/calendari" . $id . "'>"; ?> Calendari</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">              
                <div class="box box-body">
                    <table class="table table-responsive" id="playersTable" >
                        <?php
                        //  echo "<pre>";print_r($get_next_week_matches); echo "</pre>";

                        foreach ($get_next_week_matches as $matches) {

                            echo "\n\t<tr>";

                            echo "\n\t\t<td   style=' padding:3;border-top:1px solid #ccc; width:33%;'>\n\t\t\t<img src=\"http://v3.futsal.cat/webImages/clubsImages/" . $matches->localImage . "\" height=40>&nbsp;<b> " . $matches->local . "</b></td>";
                            echo "\n\t\t<td  style=' border-top:1px solid #ccc; text-align:center;  width:33%;' nowrap ><strong>" . $matches->league . "</strong><br /> " . invertdateformatshort($matches->updateddatetime) . " $hour <br /></td>";
                            echo "\n\t\t<td  style=' padding:3;border-top:1px solid #ccc; text-align:right;  width:33%;' nowrap >\n\t\t\t&nbsp;<b>" . $matches->visitor . "</b>&nbsp; <img src=\"http://v3.futsal.cat/webImages/clubsImages/" . $matches->visitorImage . "\" height=40>\n\t\t</td>";
                            $h = explode(" ", $matches->updateddatetime);
                            $hour = substr($h[1], 0, 5);

                            $rfrData = $this->competicio_model->get_referees_by_match($matches->idMatch);

                            $att = array('role' => 'form', 'id' => 'partit');
                            echo form_open('admin/arbitres/designa/' . $matches->idMatch, $att);

                            echo "\n\t</tr>";
                            echo "\n\t<tr>";
                            echo "\n\t\t<td>&nbsp;</td>";
                            echo "\n\t\t<td  style='vertical-align:middle;' align=center>\n\t\t\t<select  id=\"" . $matches->idMatch . "_1\" class=\"form-control select2 rfrSelect\" style='width:auto;' name=\"matchReferee1\" >\n\t\t\t\t<option></option>";

                            $ref = $rfrData[0]->idReferee;

                            foreach ($referees as $row):
                                if ($row->id == $ref) {
                                    $s = "selected";
                                } else {
                                    $s = "";
                                }
                                echo "\n\t\t\t\t<option  value=\"" . $row->id . "\" $s>" . $row->name . " (" . $row->delegationName . ")</option>";
                            endforeach;
                            if ($rfrData[0]->isDriver == 1) {
                                $checked = "checked";
                            } else {
                                $checked = "";
                            }
                            echo " \n\t\t\t</select>&nbsp;<input onchange=\"this.form.submit()\" type=\"checkbox\" name=\"isDriver1\" $checked>";
                            echo "<br /><select  id=\"" . $matches->idMatch . "_2\"  class=\"form-control select2 rfrSelect\"   style='width:auto;'  name=\"matchReferee2\" >\n\t\t\t\t<option></option>";

                            $ref = $rfrData[1]->idReferee;

                            foreach ($referees as $row):
                                if ($row->id == $ref) {
                                    $s = "selected";
                                } else {
                                    $s = "";
                                }
                                echo "\n\t\t\t\t<option value=\"" . $row->id . "\" $s>" . $row->name . " (" . $row->delegationName . ")</option>";
                            endforeach;
                            if ($rfrData[1]->isDriver == 1) {
                                $checked = "checked";
                            } else {
                                $checked = "";
                            }
                            echo " \n\t\t\t</select>&nbsp;<input  onchange=\"this.form.submit()\"  type=\"checkbox\"  name=\"isDriver2\" $checked>";
                            echo "<br /><select id=\"" . $matches->idMatch . "_3\"  class=\"form-control select2 rfrSelect\"  style='width:auto;'  name=\"matchReferee3\" >\n\t\t\t<option></option>";

                            $ref = $rfrData[2]->idReferee;

                            foreach ($referees as $row):
                                if ($row->id == $ref) {
                                    $s = "selected";
                                } else {
                                    $s = "";
                                }
                                echo "&nbsp;<option  onchange=\"this.form.submit()\"  value=\"" . $row->id . "\" $s>" . $row->name . " (" . $row->delegationName . ")</option>";
                            endforeach;
                            if ($rfrData[2]->isDriver == 1) {
                                $checked = "checked";
                            } else {
                                $checked = "";
                            }
                            echo " \n\t\t\t</select>&nbsp;<input onchange=\"this.form.submit()\" type=\"checkbox\"  name=\"isDriver3\" $checked></td></tr><tr><td>&nbsp;</td>";
                            echo "\n\t\t<td style='vertical-align:middle; ' align=center><input class=\"btn btn-primary\" name='enviar' type=\"submit\" value=\"Enviar\" /></td>\n\t<td>&nbsp;</td></tr>";


                            echo form_close();
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $('.select2').select2( );
    // $("#playersTable").DataTable({"oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});
    $(".rfrSelect")
            .change(function () {
                var id = "";
                id = $(this).attr('id');
                id = id.split("_");
                var idMatch = id[0];
                var refereeNum = id[1];

                // alert(idGoal);
                var idReferee = $(this).val() + " ";
                var param = "idMatch=" + idMatch + "&matchReferee" + refereeNum + "=" + idReferee;
                var request = $.ajax({
                    url: "<?php echo base_url(); ?>admin/arbitres/designa/" + idMatch,
                    type: "POST",
                    data: param,
                    dataType: "html"

                });
            })
</script>