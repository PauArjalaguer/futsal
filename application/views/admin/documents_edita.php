<section class="content-header">
    <h1><?php echo $fileName; ?>
    </h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/documents/llistat/" . $id . "'>"; ?> Document</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Informació</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <?php
                        $att = array('role' => 'form', 'id' => 'form');
                        echo form_open('admin/documents/modifica/' . $id, $att);
                        ?>

                        <div class="col-md-6">
                            <label>Nom</label>
                            <input type="hidden" value="<?php echo $id; ?>" name="rfrId">
                            <input  name='fileName' class="form-control" value="<?php echo $fileName; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="division">Categoría</label>
                            <select class="form-control" name='category' id="category"><option>&nbsp;</option>
                             <?php
                                foreach ($get_all_categories as $row):
                                    echo "<option  value=" . $row->id . ">" . $row->title . "</option>";
                                endforeach;
                                ?></select>
                        </div>



                    </div>
                </div>
                <div class="box-footer">

                    <input type="submit" value="Guardar" class="btn btn-success" />&nbsp;<a href='<?php echo base_url(); ?>admin/documents/esborra/<?php echo $id; ?>'><button class="btn btn-warning">Eliminar</button></a>
                </div>
                    <?php echo form_close(); ?> </div>
            </div>
        </div>
    </div>
</section>

<script>
    $('#category').select2();
</script>