<section class="content-header">
    <h1><?php echo $name; ?></h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/pavellons'>"; ?> Pavellons</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/pavellons/edita/" . $id . "'>"; ?> <?php echo $complexName; ?></a></li>
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
                    <?php
                    $att = array('role' => 'form', 'id' => 'form');
                    echo form_open('admin/pavellons/modifica/' . $id, $att);
                    ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="hidden" value="<?php echo $id; ?>" name="complexId">
                                <input  name='complexName' class="form-control" value="<?php echo ucwords(strtolower($complexName)); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Adreça</label>
                                <input  name='complexAddress' class="form-control" value="<?php echo  ucwords(strtolower($complexAddress)); ?>">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Telefon</label>
                                <input  name='complexPhone' class="form-control" value="<?php echo $complexPhone; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <iframe width="100%" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?q=<?php echo urlencode($complexAddress); ?>&output=embed"></iframe>
                        </div>
                        <div class="col-md-3"><h3>Distáncia a delegacions</h3>
                            <table cellpadding="6" width="100%">
                                <?php
                                foreach ($get_distance_to_delegations as $row):
                                    echo "<tr><td><strong>" . $row->delegationName . "</strong><td><td>" . $row->distance . " km.</td></tr>";
                                endforeach;
                                ?>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="box box-footer">
                    <input type="submit" value="Guardar" class="btn btn-success" />
                    <a href="<?php echo base_url();?>admin/pavellons/fusiona/<?php echo $id; ?>"<button class="btn btn-info btn-flat" type="button" >Fusionar</button></a>
                                           
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</section>