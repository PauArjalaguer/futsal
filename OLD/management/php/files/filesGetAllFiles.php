<?
include("../../Classes/db.inc");
include("../../Classes/Files_Class.php");
include("../../Classes/Competition_Class.php");
?>     
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Arxius</h3>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Titol</th>
                    <th>Categoria</th>
                    <th>Data</th>
                    <th>Home</th>
                    <th colspan="2">Accions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $files = new Files();
                $data = $files->filesGetAllFiles();
                foreach ($data as $files) {
                    if ($files[5] > 0) {
                        $home = "<i class=\"fa  fa-home\"></i>";
                    } else {
                        $home = "";
                    }
                    echo "\n\t<tr id='newsTr_" . $files[0] . "'>\n\t\t<td>" . $files[0] . "</td>";
                    echo "\n\t\t<td>" . utf8_encode($files[2]) . "</td>";
                    echo "\n\t\t<td>" . utf8_encode($files[4]) . "</td>";
                    echo "\n\t\t<td>" . $files[3] . "</td>";
                    echo "\n\t\t<td align=center>" . $home . "</td>";
                    echo "\n\t\t<td align=center><i class=\"fa  fa-edit\" style='cursor:pointer' onClick='fileEdit(" . $files[0] . ");'></i></td>\n\t<td  align=center><i style='cursor:pointer' class=\"fa  fa-trash-o\" onClick='fileDelete(" . $files[0] . ");'></i></td></tr>";
                }
                ?>  
            </tbody>
    </div>
</div>

