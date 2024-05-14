<section class="content-header">
    <h1 ><?php
      
        ?>&nbsp;</h1>
    <ol class="breadcrumb">
         <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?><i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/gestio_clubs'>"; ?> Gestió de clubs</a></li>     
        <li class="active"><?php echo $name; ?></li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Control econòmic</h3>
        </div>
        <div class="box-body">
            <?php
        foreach($divisions as $row){
        }
        ?>
        </div>
    </div>
</section>
<script>
    $("#competitionsTable").DataTable({ "aaSorting": [5,'asc'],"pageLength": 1000, "oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:&nbsp; ", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Ãšltima pÃ gina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});

</script>