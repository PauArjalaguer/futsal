<?
include("../../Classes/db.inc");
include("../../Classes/News_Class.php");
include("../../Classes/Referees_Class.php");
?>     

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Rebuts arbitrals</h3>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Data</th>
                    

                    <th colspan="2">Accions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $referee = new Referees();
                $data = $referee->rfrBills();
                /*echo "<pre>";
                print_r($data);
                echo "</pre>";*/
                foreach ($data as $rfr) {
					$d=explode("-",$rfr[1]);
					$date=$d[2]."-".$d[1]."-".$d[0];
					$data=str_replace("-","",$rfr[1]);
                    echo "<tr><td></td>";
                    echo "<td><strong>$date</strong> </td>";
                
                    echo "<td align=left>";
                   
                   echo "<a href='" . $serverURL . "/factures/arbitrals/rebut_".$data.".pdf'>Descarregar</a><br />";
                   

                    echo "</td></tr>";
                }
                ?>  
				
            </tbody></table><button type="submit" class="btn btn-lg btn-primary" onClick="rfrBillGenerate('<? echo $rfr[1]; ?>')">Generar rebuts</button>  
    </div>
</div>

