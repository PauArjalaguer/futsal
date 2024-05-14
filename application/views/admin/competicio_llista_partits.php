<section class="content-header">
    <h1>Base de dades
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
                <div class="box-header">
                    <h3 class="box-title">Filtres</h3>
                </div>
                <div class="box-body">
                    <?php
                    $att = array('role' => 'form');
                    echo form_open('admin/competicio/partits', $att);
                    ?>

                    <div class="col-md-3">
                        <label for="initialDate">Data inici</label>
                        <input type="date" class="form-control" id="initialDate" name='initialDate' onchange="this.form.submit()" value="<?php echo $_POST['initialDate']; ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="endDate">Data final</label>
                        <input type="date" class="form-control" id="endDate" name='endDate' onchange="this.form.submit()" value="<?php echo $_POST['endDate']; ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="team">Equip</label>
                        <select class="form-control select2" name='team' id="team" onchange="this.form.submit()" >
                            <option value="0">&nbsp;</option> 
                            <?php
                            foreach ($get_all_teams as $row):
                                if ($_POST['team'] == $row->id) {
                                    $s = "selected";
                                } else {
                                    $s = "";
                                }
                                echo "<option $s value=" . $row->id . ">" . $row->name . "</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="division">Club</label>
                        <select class="form-control select2" name='club' id="club" onchange="this.form.submit()" >
                            <option value="0">&nbsp;</option>
                            <?php
                            foreach ($get_all_clubs as $row):
                                if ($_POST['club'] == $row->id) {
                                    $s = "selected";
                                } else {
                                    $s = "";
                                }
                                echo "<option $s value=" . $row->id . ">" . $row->name . "</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="complex">Pavelló</label>
                        <select class="form-control select2" name='complex' id="complex" onchange="this.form.submit()" >
                            <option value="0">&nbsp;</option>
                            <?php
                            foreach ($get_all_complex as $row):
                                if ($_POST['complex'] == $row->id) {
                                    $s = "selected";
                                } else {
                                    $s = "";
                                }
                                echo "<option $s value=" . $row->id . ">" . $row->complexName . "(" . $row->complexAddress . ")</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="league">Competició</label>
                        <select class="form-control select2" name='league' id="league" onchange="this.form.submit()" >
                            <option value="0">&nbsp;</option>
                            <?php
                            foreach ($get_leagues_by_idSeason as $row):
                                if ($_POST['league'] == $row->id) {
                                    $s = "selected";
                                } else {
                                    $s = "";
                                }
                                echo "<option $s value=" . $row->id . ">" . $row->name . "</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="division">Categoria</label>
                        <select class="form-control select2" name='division' id="division" onchange="this.form.submit()" >
                            <option value="0">&nbsp;</option>
                            <?php
                            foreach ($get_divisions as $row):
                                if ($_POST['division'] == $row->id) {
                                    $s = "selected";
                                } else {
                                    $s = "";
                                }
                                echo "<option $s value=" . $row->id . ">" . $row->name . "</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="status">Estat partit</label>
                        <select class="form-control select2" name='status' id="status" onchange="this.form.submit()" >
                            <option value="0">&nbsp;</option>
                            <?php
                            foreach ($get_all_matchstatus as $row):
                                if ($_POST['status'] == $row->id) {
                                    $s = "selected";
                                } else {
                                    $s = "";
                                }
                                echo "<option $s value=" . $row->id . ">" . $row->status . "</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label for="excel">excel</label>
                        <input type="checkbox" onchange="this.form.submit()" name="excel" id="excel">
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Partits</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="competitionsTable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Equip 1</th>
                                <th>Equip 2</th>
                                <th>Data</th>
                                <th>Hora</th>
                                <th>Pavelló</th>
                                <th>Categoría</th>
                                <th>Resultat</th>
                                <th>&nbsp;</th>

                        </thead>
                        <tbody>
                            <?php
                            $round = "";
                            foreach ($get_next_week_matches as $row):
                                $date = invertdateformatshort($row->updateddatetime);
                                $hour = hour($row->updateddatetime);
                                echo "<tr>";
                                echo "<td>" . $row->local . "</td>";
                                echo "<td>" . $row->visitor . "</td>";
                                echo "<td>" . $date . "</td>";
                                echo "<td>" . $hour . "</td>";
                                echo "<td>" . $row->complexName . "</td>";
                                echo "<td>" . $row->league . "</td>";
                                echo "<td>" . $row->localResult . " - " . $row->visitorResult . "</td>";
                                echo "<td><a href='" . base_url() . "admin/competicio/acta/" . $row->idMatch . "'><i class=\"fa fa-eye\" aria-hidden=\"true\"></i></a>\n\t";
                                echo "&nbsp;<a href='" . base_url() . "admin/competicio/partit/" . $row->idMatch . "'><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a></td>";
                                echo "</tr>";
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
    $('.select2').select2();
</script>
