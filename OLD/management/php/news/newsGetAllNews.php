<?
include("../../Classes/db.inc");
include("../../Classes/News_Class.php");
include("../../Classes/Competition_Class.php");
?>     
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Not&iacute;cies</h3>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Titol</th>
                    <th>Categoria</th>
                    <th>Data</th>
                    <th colspan="2">Accions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $news = new News();
                $data = $news->newsGetAllNews();
                foreach ($data as $news) {
                    echo "<tr id='newsTr_".$news[0]."'><td>" . $news[0] . "</td>";
                    echo "<td>" . utf8_encode($news[1]) . "</td>";
                    echo "<td>" . utf8_encode($news[3]) . "</td>";
                    echo "<td>" . $news[2] . "</td>";
                    echo "<td align=center><i class=\"fa  fa-edit\" style='cursor:pointer' onClick='newsEdit(".$news[0].");'></i></td><td  align=center><i style='cursor:pointer' class=\"fa  fa-trash-o\" onClick='newsDelete(".$news[0].");'></i></td></tr>";
                }
                ?>  
            </tbody>
    </div>
</div>

