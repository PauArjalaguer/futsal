<section class="content-header" >
    <h1 >&nbsp;</h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?><i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/equips'>"; ?>Equips</a></li>
    </ol></section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border" >
            <h3 class="box-title">Llista d' equips</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <tbody>
                    <?php
                    foreach ($get_all_teams as $row):
                        echo "\n\t<tr id='clubsTr_" . $row->id . "'>";
                        echo "\n\t\t<td class='pointer'><a href='" . base_url() . "admin/equip/" . $row->id . "'>" . $row->name . "</td>";
                        echo "\n\t</tr>";
                    endforeach;
                    ?>  
                </tbody>
            </table>
        </div>
    </div>
</section>