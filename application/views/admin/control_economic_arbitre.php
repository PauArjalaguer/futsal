<section class="content-header">
    <h1><?php echo $name; ?>
    </h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/control_economic'>"; ?> Control economic</a></li>       
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Control econòmic</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="competitionsTable"  class="table table-bordered table-striped">
                        <thead><tr><th>Data</th><th>Partit</th><th>Preu</th><th>Dieta</th><th>Kms</th><th>Subtotal</th><th>Total</th></thead>
                        <tbody>
                            <?php
                            $total="";
                            $round = "";
                            foreach ($get_refereed_matches_by_idReferee as $row):
                                $d=explode(" ",$row->updateddatetime);
                            $hour=$d[1];
                            if($row->excludeKM==1){$row->distance=0;$v=0;}else{$v=1;}
                                echo "\n\t\t\t\t\t\t\t<tr id='competicioTr'>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . invertdateformat($row->updateddatetime) . " $hour</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->local . " - " . $row->visitor . " </td>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->price . " </td>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $row->allowance . " </td>";
                                $distance = ($row->distance * 0.19);
                                echo "\n\t\t\t\t\t\t\t\t<td><a href='".base_url()."/admin/control_economic/deshabilita_kilometratge/".$row->idRef."/".$id."/$v'> $distance &euro; (" . $row->distance . " km) </a></td>";

                                $subTotal = $distance + $row->price + $row->allowance;
                                $total = $total + $subTotal;
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $subTotal . " &euro;</td>";
                                echo "\n\t\t\t\t\t\t\t\t<td>" . $total . " €</td>";
                                echo "\n\t\t\t\t\t\t\t</tr>";

                            endforeach;
                            ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>