<?
include("../../Classes/db.inc");
include("../../Classes/Competition_Class.php");
$competition = new Competition();

$competition->idClub = $_COOKIE['idClub'];
?>
<section class="content-header" >
    <h1 >&nbsp;</h1>

    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Inici</a></li>
        <li><a href="#" onClick='cmptMatchListByIdClub()'>Partits</a></li>
    </ol></section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border" >
            <h3 class="box-title">Llista de partits</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead><tr><th>Partit</th><th>Lliga</th><th>Jornada</th><th>Data</th><th>&nbsp;</th></thead>
                <tbody>
                    <?php
                    $data = $competition->cmptMatchListByIdClub();
                    /* echo "<pre>";
                      print_r($data);
                      echo "</pre>"; */

                    foreach ($data as $match) {
                        $d = explode(" ", $match[5]);
                        $da = explode("-", $d[0]);
                        $date = $da[2] . "-" . $da[1] . "-" . $da[0] . " " . $d[1];

                        echo "<tr id='clubsTr_" . $match[0] . "'>";
                        echo "<td>" . utf8_encode($match[2]) . " - " . utf8_encode($match[4]) . "</td>";
                        echo "<td>" . utf8_encode($match[8]) . "</td>";
                        echo "<td align=center>" . utf8_encode($match[6]) . "</td>";
                        echo "<td>$date</td>";
                        echo "<td class='pointer' onClick='cmptMatchDateChange(".$match[0].")'>Modificar</td>";

                        echo "</tr>";
                    }
                    ?>  
                </tbody>
        </div>
    </div>
</section>