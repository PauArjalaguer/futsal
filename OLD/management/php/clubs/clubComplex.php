<?
include("../../Classes/db.inc");
include("../../Classes/Clubs_Class.php");
$clubs = new Clubs();
if (isset($_COOKIE['idClub'])) {
    $clubs->idClub = $_COOKIE['idClub'];
}
?>
<section class="content-header" >
    <h1 >&nbsp;</h1>

    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Inici</a></li>
        <li><a href="#" onClick='clubComplex()'>Pavellons</a></li>
    </ol></section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border" >
            <h3 class="box-title">Llista de pavellons</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Pavell&oacute;</th>
                        <th>Adre&ccedil;a</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = $clubs->clubComplex();
                    //print_r($data);
                    foreach ($data as $team) {
                        echo "<tr id='clubsTr_" . $team[0] . "'>";
                        echo "<td class='pointer' onClick='clubPlayersGetListByTeamId(" . $team[0] . ");'>" . utf8_encode($team[1]) . "</td>";
                        echo "<td class='pointer' onClick='clubPlayersGetListByTeamId(" . $team[0] . ");'>" . utf8_encode($team[2]) . "</td>";

                        echo "</tr>";
                    }
                    ?>  
                    <tr>
                        <td><input id="clubComplexName" style="width:100%;" type="text"></td>
                        <td><input id="clubComplexAddress" style="width:80%;" type="text"> 
                            <button type="button" class="btn btn-success" onClick="clubComplexInsert()">Guardar</button>
                        </td>
                    </tr>
                </tbody>
        </div>
    </div>
</section>