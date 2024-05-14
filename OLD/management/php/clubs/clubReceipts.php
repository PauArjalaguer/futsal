<?
include("../../Classes/db.inc");
include("../../Classes/Clubs_Class.php");
$clubs = new Clubs();
$clubs->idClub = $_COOKIE['idClub'];

?>
<section class="content-header" >
    <h1 >&nbsp;</h1>

    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Inici</a></li>
        <li><a href="#" onClick='clubReceipts()'>Factures</a></li>
    </ol></section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border" >
            <h3 class="box-title">Factures</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">

                <tbody>
                    <?php
                    $data = $clubs->clubReceipts();
                    //print_r($data);
                    foreach ($data as $receipt) {
                        echo "<tr id='clubsTr_" . $receipt[0] . "'>";
                        $d=explode(" ",$receipt[3]);
                        $date=explode("-",$d[0]);
                        $data=$date[2]."-".$date[1]."-".$date[0];
                        $r=explode("_",$receipt[2]);
                        $receiptNumber=$r[0];
                        echo "<td class='pointer'><a target=_blank href='../factures/".$receipt[2].".pdf'>Factura num." . $receiptNumber . "</a></td><td>".$data."</td>";
                        echo "</tr>";
                    }
                    ?>  
                </tbody>
        </div>
    </div>
</section>