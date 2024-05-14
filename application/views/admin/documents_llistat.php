<section class="content-header" >
    <h1 >&nbsp;</h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?><i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/documents'>"; ?>Documents</a></li>
    </ol></section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border" >
            <h3 class="box-title">Documents</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <div id="imageUploader">
                <div id="myId" class="dropzone"></div>
            </div>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($get_all_documents as $row):
                        echo "\n\t<tr id='clubsTr_" . $row->id . "'>";

                        echo "\n\t\t<td class='pointer'> <a href='" . base_url() . "admin/documents/edita/" . $row->id . "'> &bull; " . $row->fileName . "</td>";
                        echo "\n\t\t<td class='pointer' colspan=2>" . invertdateformat($row->inserted) . "</td>";

                        echo "\n\t</tr>";
                    endforeach;
                    ?>  
                </tbody>
        </div>
    </div>
</section>
<script>var myDropzone3 = new Dropzone("div#myId", {
        url: "<?php echo base_url() . "admin/documents/puja_arxiu/"; ?>",
        dictDefaultMessage: "<span style='font-size:32px; color:#2a6496;'>\n\<i style='font-size:32px;' class=\"fa fa-cloud-upload fa-fw\"></i> Insertar arxiu.",
        success: function (file, response) {

            location.reload();
        }
    });
</script>