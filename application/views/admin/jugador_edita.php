
<section class="content-header">
    <h1 ><?php 
        $n = "";
      
        if (!$firstName) {
            list($firstName, $surName, $surName2) = explode(' ', $playerName);

            $surName = $surName . " " . $surName2;
        }
        //echo "<pre>"; print_r(get_defined_vars()); echo "</pre>";
        echo $playerName;
        ?></h1>
    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Inici</a></li>
        <li><a href="<?php echo base_url(); ?>admin/equips" >Equips</a></li>
        <li><a href="<?php echo base_url(); ?>admin/equip/<?php echo $idTeam; ?>"><?php echo $teamName; ?></a></li>
        <li><a href="#"><?php echo $playerName; ?></a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12" <?php
       
        if (!$rejectedReason) {
            echo "style='display:none;'";
        }
        ?>>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Alerta</h4>
                <?php echo $rejectedReason; ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Evolució de la fitxa</h3>
                </div>
                <div class="box-body">
                    <div class="progress">
                        <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="<?php
                        //$statusPercent = 0;
                        echo $statusPercent;
                        ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $statusPercent; ?>%">
                            <span class="sr-only"><?php echo $statusPercent; ?>% Complete (success)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>	
        <div class="col-md-10">

            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Dades</h3>
                </div><?php
                $att = array('role' => 'form', 'id' => 'form');
                echo form_open('admin/jugador/modifica/' . $id, $att);
                ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="PlayerName">Nom del jugador/a <span style='color:red;'>*</span></label>
                                <input type="text" class="form-control" name="playerName" placeholder="Introdueix el nom del jugador" value="<?php echo $firstName; ?>">
                                <input type="hidden" name="idCard" value="<?php echo $idCard; ?>" />
                                <input type="hidden" name="idTeam" value="<?php echo $idTeam; ?>" />
                                <input type="hidden" name="idSeason" value="<?php echo $idSeason; ?>" />
                                <input type="hidden" name="idPlayer" value="<?php echo $id; ?>" />

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="PlayerName">Cognom del jugador/a <span style='color:red;'>*</span></label>
                                <input type="text" class="form-control" name="playerSurname" placeholder="Introdueix el cognom del jugador" value="<?php echo trim($surName); ?>">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="PlayerName">Fitxa <span style='color:red;'>*</span></label>
                                <select class="form-control" name='playerPosition' id="playerPosition"><option>&nbsp;</option>
                                    <?php
                                    foreach ($get_player_positions as $row):
                                        if ($position == $row->id) {
                                            $s = "selected";
                                        } else {
                                            $s = "";
                                        }
                                        echo "<option $s value=" . $row->id . ">" . $row->position . "</option>";

                                    endforeach;
                                    ?>
                                </select>

                            </div>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Data de naixement: <span style='color:red;'>*</span></label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <?php
                                    if ($birthdate) {
                                        $d = explode("-", $birthdate);
                                        $birthdate = $d[2] . "-" . $d[1] . "-" . $d[0];
                                        $n++;
                                    }
                                    ?>
                                    <input  name="playerBirthDate" type="text" class="form-control pull-right" id="datepicker" value="<?php echo $birthdate; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-2">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="PlayerName">País de naix.</label>
                                <input type="text" name="playerBirthCountry" class="form-control"  placeholder="Introdueix el país de naixement del jugador" value="<?php echo $countryofbirth; ?>">

                            </div>
                        </div>
                    </div>
                   <div class="col-md-2">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="PlayerName">Provi. de naix.</label>
                                <input type="text" name="playerBirthProvince" class="form-control"  placeholder="Introdueix la provincia de naixement del jugador" value="<?php echo $provinceofbirth; ?>">

                            </div>
                        </div>
                    </div>-->
                    <div class="col-md-2">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="PlayerName">Ciutat <span style='color:red;'>*</span></label>
                                <input type="text" name="playerCity" class="form-control"  placeholder="Introdueix la ciutat del jugador" value="<?php echo $addressCity; ?>">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="PlayerName">Provincia <span style='color:red;'>*</span></label>
                                <input type="text" name="playerProvince" class="form-control"  placeholder="Introdueix la provincia del jugador" value="<?php echo $addressProvince; ?>">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="PlayerName">DNI</label>
                                <input type="text" name="playerDNI" class="form-control"  placeholder="Introdueix el DNI del jugador" value="<?php echo $dni; ?>">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="box-body" >
                            <div class="form-group">
                                <label for="PlayerName">Lletra</label>
                                <input type="text" name="playerNIF" class="form-control"  placeholder="" value="<?php echo $nif ?>">

                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="PlayerName">Carrer <span style='color:red;'>*</span></label>
                                <input type="text" name="playerStreet" class="form-control"  placeholder="Introdueix el carrer del jugador" value="<?php echo $address; ?>">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="box-body" >
                            <div class="form-group">
                                <label for="PlayerName">Num <span style='color:red;'>*</span></label>
                                <input type="text" name="playerStreetNumber" class="form-control"  placeholder="Introdueix el numero del carrer del jugador" value="<?php echo $addressNumber; ?>">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="box-body" >
                            <div class="form-group">
                                <label for="PlayerName">Pis </label>
                                <input type="text" name="playerFloor" class="form-control"  placeholder="Introdueix el pis del jugador" value="<?php echo $addressFloor; ?>">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="box-body" >
                            <div class="form-group">
                                <label for="PlayerName">Porta</label>
                                <input type="text" name="playerDoor" class="form-control"  placeholder="Introdueix la porta del jugador" value="<?php echo $addressDoor; ?>">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="box-body" >
                            <div class="form-group">
                                <label for="PlayerName">CP <span style='color:red;'>*</span></label>
                                <input type="text" name="playerCP" class="form-control"  placeholder="Introdueix el codi posta del jugador" value="<?php echo $cp; ?>">

                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Notes

                                </h3>

                                <div class="pull-right box-tools">
                                    <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fa fa-minus"></i></button>
                                    <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                                        <i class="fa fa-times"></i></button>
                                </div>
                                <!-- /. tools -->
                            </div>
                            <div class="box-body pad">

                                <textarea name="playerNotes" class="textarea" placeholder="" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $playerNotes; ?></textarea>

                            </div>
                        </div>
                    </div>
                </div>


                <?php
                $style="";
                if ($isPayed == 1) {
                    $style = " style=\"display:none; \"";
                }
                ?>
                <div class="box-footer" <?php echo $style; ?>>

                    <input type="submit" value="Guardar" class="btn btn-success" />
                   <!--<a href="<?php echo base_url() . "admin/jugador/modifica/" . $id; ?>"><button type="button" class="btn btn-primary">Guardar i tornar</button></a>-->
                    <a href="<?php echo base_url() . "admin/jugador/elimina/" . $id . "/" . $idTeam; ?>"><button type="button" class="btn btn-danger">Eliminar fitxa</button></a>


                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Documentació</h3>
                </div>

                <div class="box-body with-border">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-file-image-o" aria-hidden="true"></i> Foto <span style='color:red;'>*</span></h3>
                        <input type='hidden' name='playerImage' value='<?php echo $image; ?>' />
                    </div>
                    <?php
                    if (empty($image)) {
                        $fU = "display:block;";
                        $fI = "display:none;";
                    } else {
                        $fU = "display:none;";
                        $fI = "display:block;";
                    }
                    ?>
                    <div id="imageUploader" style='<?php echo $fU; ?>'>
                        <div id="myId" class="dropzone"></div>
                    </div>
                    <div id="imageContainer" style='<?php echo $fI; ?>'>
                        <img src='<?php echo base_url(); ?>images/dynamic/playersImages/<?php echo $image; ?>?d=<?php echo time(); ?>' width=100%/><br />
                        <i class="fa fa-undo pointer" aria-hidden="true" ></i>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url() . "admin/jugador/elimina_foto/" . $id."/". urlencode(urlencode($_SERVER['REQUEST_URI']));  ?>"><i class="fa fa-times-circle pointer" aria-hidden="true"></i></a>
                    </div>
                </div>

                <div class="box-body with-border">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-wpforms" aria-hidden="true"></i> DNI <span style='color:red;'>*</span></h3>
                    </div>
                    <input type='hidden' name='playerDNI' value='<?php echo $DNIscan; ?>' />
                    <?php
                    if (empty($DNIscan)) {
                        $dU = "display:block;";
                        $dI = "display:none;";
                    } else {
                        $dU = "display:none;";
                        $dI = "display:block;";
                    }
                    ?>
                    <div id="imageUploader" style='<?php echo $dU; ?>'>
                        <div id="myId2" class="dropzone"></div>
                    </div>
                    <div id="imageContainer" style='<?php echo $dI; ?>'>
                        <img src='<?php echo base_url(); ?>images/dynamic/playersImages/<?php echo $DNIscan; ?>?d=<?php echo time(); ?>' width=100%/>
                        <a href="<?php echo base_url() . "admin/jugador/elimina_document/" . $id . "/dni/". urlencode(urlencode($_SERVER['REQUEST_URI'])); ?>"><i class="fa fa-times-circle pointer" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="box-body with-border">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-hospital-o" aria-hidden="true"></i> Assegurança <span style='color:red;'>*</span></h3>
                    </div>
                    <input type='hidden' name='playerInsurance' value='<?php echo $insuranceScan; ?>' />

                    <?php
                   /* if (empty($insuranceScan)) {
                        $insuranceScan = $scan;
                    }

*/
                    if (empty($insuranceScan)) {
                        $iU = "display:block;";
                        $iI = "display:none;";
                    } else {
                        $iU = "display:none;";
                        $iI = "display:block;";
                    }
                    ?>
                    <div id="imageUploader" style='<?php echo $iU; ?>'>
                        <div id="myId3" class="dropzone"></div>
                    </div>
                    <div id="imageContainer" style='<?php echo $iI; ?>'>
                        <img src='<?php echo base_url(); ?>images/dynamic/playersImages/<?php echo $insuranceScan; ?>?d=<? echo time(); ?>' width=100%/>
                        <a href="<?php echo base_url() . "admin/jugador/elimina_document/" . $id . "/seguro". urlencode(urlencode($_SERVER['REQUEST_URI']));  ?>"><i class="fa fa-times-circle pointer" aria-hidden="true"></i></a>
                            <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $('#datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true
    }).val();

    var myDropzone = new Dropzone("div#myId", {
        url: "<?php echo base_url() . "admin/jugador/puja_foto/$id"; ?>",
        dictDefaultMessage: "<span style='font-size:26px; color:#2a6496;'>\n\<i style='font-size:28px;' class=\"fa fa-cloud-upload fa-fw\"></i> Insertar arxiu per a pujar.",
        success: function (file, response) {
            // clubPlayerEdit(idPlayer);
            document.getElementById("form").submit();

        }
    });
    var myDropzone2 = new Dropzone("div#myId2", {
        url: "<?php echo base_url() . "admin/jugador/puja_document/$id/dni"; ?>",
        dictDefaultMessage: "<span style='font-size:26px; color:#2a6496;'>\n\<i style='font-size:28px;' class=\"fa fa-cloud-upload fa-fw\"></i> Insertar arxiu per a pujar.",
        success: function (file, response) {
            document.getElementById("form").submit();

        }
    });
    var myDropzone3 = new Dropzone("div#myId3", {
        url: "<?php echo base_url() . "admin/jugador/puja_document/$id/seguro"; ?>",
        dictDefaultMessage: "<span style='font-size:26px; color:#2a6496;'>\n\<i style='font-size:28px;' class=\"fa fa-cloud-upload fa-fw\"></i> Insertar arxiu per a pujar.",
        success: function (file, response) {
            document.getElementById("form").submit();

        }
    });
</script>