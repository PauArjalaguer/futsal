<section class="content-header" >
    <h1 >&nbsp;</h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?><i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/noticia/llista'>"; ?>Notícies</a></li>
    </ol></section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border" >
            <h3 class="box-title">Notícies</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Notícia</th>
                        <th>Data</th>
                        <th align="center"><a href="<?php echo base_url(); ?>admin/noticia/crea"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($get_news as $row):
                        echo "\n\t<tr id='clubsTr_" . $row->id . "'>";
                    if($row->draft==1){
                        $style=" style='color:#ccc;'"; 
                    }else{
                        $style="";
                    }
                        echo "\n\t\t<td class='pointer'> <a $style href='" . base_url() . "admin/noticia/edita/" . $row->id . "'> &bull; " . $row->title . "</td>";
                       echo "\n\t\t<td class='pointer' colspan=2>".invertdateformat($row->insertDate)."</td>";
                       
                        echo "\n\t</tr>";
                    endforeach;
                    ?>  
                </tbody>
        </div>
    </div>
</section>