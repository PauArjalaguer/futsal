<section class="content-header">
    <h1><?php echo $name; ?>
    </h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?> <i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/arbitres'>"; ?> Àrbitres</a></li>
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
                    echo form_open('admin/arbitre/modifica/' . $id, $att);
                    ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="hidden" value="<?php echo $id; ?>" name="rfrId">
                                <input  name='rfrName' class="form-control" value="<?php echo $name; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Data de naixement</label>
                                <input  name='rfrBirthdate' class="form-control" value="<?php echo invertdateformat($birthdate); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>DNI</label>
                                <input  name='rfrDni' class="form-control" value="<?php echo $dni; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Població</label>
                                <input  name='rfrCity' class="form-control" value="<?php echo $city; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Provincia</label>
                                <input  name='rfrProvince' class="form-control" value="<?php echo $province; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="PlayerName">Delegació</label>
                            <select class="form-control" name='rfrDelegation' id="playerPosition"><option>&nbsp;</option>
                                <?php
                                foreach ($get_delegations as $row):
                                    if ($idDelegation == $row->idDelegation) {
                                        $s = "selected";
                                    } else {
                                        $s = "";
                                    }
                                    echo "<option $s value=" . $row->idDelegation . ">" . $row->delegationName . "</option>";

                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                 <label>Compte Corrent</label>
                                <input  name='rfrAccount' class="form-control" value="<?php echo $bankAccount; ?>">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">

                                <label>Telèfon</label>
                                <input  name='rfrTelephone' class="form-control" value="<?php echo $telephone; ?>">
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                                 <label>Email</label>
                                <input  name='rfrEmail' class="form-control" value="<?php echo $email; ?>">
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Guardar" class="btn btn-success" />
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</section>