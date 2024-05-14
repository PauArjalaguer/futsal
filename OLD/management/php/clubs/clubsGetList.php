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
        <li><a href="#" onClick='clubsGetList()'>Clubs</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border" >
            <h3 class="box-title">Llista d' equips</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Ciutat</th>
                        <th>Codi</th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = $clubs->clubsGetAllClubs();
                    //print_r($data);
                    foreach ($data as $club) {
                        echo "<tr id='clubsTr_" . $club[0] . "'><td>" . $club[0] . "</td>";
                        echo "<td>" . utf8_encode($club[1]) . "</td>";
                        echo "<td>" . utf8_encode($club[9]) . "</td>";
                        echo "<td>" . $club[12] . "</td>";
                        echo "<td align=center><i class=\"fa  fa-edit\" style='cursor:pointer' onClick='clubsEdit(" . $club[0] . ");'></i>&nbsp;<i style='cursor:pointer' class=\"fa  fa-trash-o\" onClick='clubsDelete(" . $club[0] . ");'></i></td></tr>";
                    }
                    ?>  
                </tbody>
            </table>
        </div>
    </div>
</section>

