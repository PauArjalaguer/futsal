<section class="content-header">
    <h1 >
        <?php
        echo $name;
        ?>
    </h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?><i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/gestio_clubs'>"; ?> Gestió de clubs</a></li>     
        <li class="active"><?php echo $name; ?></li>
    </ol>
</section>
<section class="content">
    <div class="box box-danger">
        <div class="box-header">Control economic</div>
        <div class="box-body">Saldo: <?php echo $balance; ?> &euro; <br /><a href='<?php echo base_url(); ?>admin/Control_economic/club/<?php echo $id; ?>'>Veure control econòmic</a>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header">Equips</div>
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead><tr><th>Nom</th>
                <tbody>
                    <?php
                    foreach ($get_all_teams as $row):
                        echo "\n\t<tr id='clubsTr_" . $row->id . "'>";
                        echo "\n\t\t<td class='pointer'><a href='" . base_url() . "admin/gestio_clubs/equip/" . $row->id . "/$id'>" . $row->name . "</td>";
                        echo "\n\t</tr>";
                    endforeach;
                    ?>  
                </tbody>
            </table>
            <div class="form-group">
                <?php
                $att = array('role' => 'form');
                echo form_open('admin/gestio_clubs/nou_equip', $att);
                ?>
                <div class="col-md-12">
                    <input type='hidden' value='<?php echo $id; ?>' name='idClub'>
                    <label for="competitionName">Crear nou equip</label>
                    <input type="text" class="form-control" id="teamName" name='teamName' placeholder="Introdueix el nom de l' equip" value='<?php echo $name; ?>'>
                </div>
                <div class="col-md-12">
                    <input type="submit" class="btn btn-success" value='Guardar'>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Informació del club</h3>
        </div>
        <div class="box-body">
            <?php
            $att = array('role' => 'form', 'id' => 'form');
            echo form_open('admin/gestio_clubs/modifica/' . $id, $att);
            ?>
            <div id="clubDataContainer" class="" >
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nom del club</label>
                            <input  readonly="readonly" name='clubName' class="form-control" value="<?php echo $name; ?>">
                        </div> 
                    </div>
                    <div class="col-lg-6" >
                        <label>Codi de club</label>
                        <input name='clubCode' class="form-control" value="<?php echo $id; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label>Adreça</label>
                        <input   class="form-control" name="clubAddress" value="<?php echo $address; ?>">  
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Ciutat</label>
                            <input   class="form-control" name="clubCity" value="<?php echo $city; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label>Telefon 1 </label>
                        <input   class="form-control" name="clubPhone1" value="<?php echo $phone1; ?>">  
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Telefon 2</label>
                            <input   class="form-control" name="clubPhone2" value="<?php echo $phone2; ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Email</label>
                            <input   class="form-control" name="clubEmail" value="<?php echo $email; ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>President</label>
                            <input   class="form-control" name="clubPresident" value="<?php echo $president; ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Vicepresident 1</label>
                            <input   class="form-control" name="clubVicepresident1" value="<?php echo $vicepresident1; ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Vicepresident 2</label>
                            <input   class="form-control" name="clubVicepresident2" value="<?php echo $vicepresident2; ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Registre entitats</label>
                            <input   class="form-control" name="cceCode" value="<?php echo $cceCode; ?>">
                        </div>
                    </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                            <label>NIF per factura</label>
                            <input   class="form-control" name="clubNif" value="<?php echo $clubNif; ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group box">
                    <div class='box-header'>
                        <label>Text</label>
                        <textarea class="form-control" name="clubText" name="clubText" rows="20"><?php echo $description; ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label>Facebook</label>
                        <input   class="form-control" name="clubFacebook" value="<?php echo $facebook; ?>">  
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Twitter</label>
                            <input   class="form-control" name="clubTwitter" value="<?php echo $twitter; ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Web</label>
                            <input   class="form-control" name="clubWeb" value="<?php echo $web; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                    if (empty($image)) {
                        $newsImageContainerDisplay = "none";
                        $newsUploaderContainer = "col-lg-6";
                        $newsImageContainerClass = "";
                    } else {
                        $newsImageContainerDisplay = "block";
                        $newsImageContainerClass = "col-lg-6";

                        $newsUploaderContainer = "col-lg-6";
                    }
                    ?>
                    <div style='display:<?php echo $newsImageContainerDisplay; ?>;' id="newsImageContainer" class="<?php echo $newsImageContainerClass; ?>">
                        <label>Imatge</label><br />
                        <img id="newsImageContainerImage" width="200" src='<?php echo base_url() . "images/dynamic/clubsImages/" . $image; ?>?d=<?php echo time(); ?>' />
                        <input type="hidden" id="clubImage" name="clubImage" value="<?php echo $image; ?>" />
                    </div>

                    <div class="<?php echo $newsUploaderContainer; ?>"  id="newsUploaderContainer">
                        <label>Pujar imatge</label>
                        <div id="imageUploader">
                            <div id="myId" class="dropzone"></div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-lg btn-info" value='Desar'>
                <?php echo form_close(); ?>
            </div>
        </div>

    </div>
    <div class="box box-primary">
        <div class="box-header">Administradors</div>
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead><tr><th>Nom</th><th>Email</th><th>&nbsp;</th>
                <tbody>
                    <?php
                    foreach ($get_all_users_by_idClub as $row):
                        echo "\n\t<tr id='clubsTr_" . $row->id . "'>";
                        echo "\n\t\t<td class='pointer'>" . $row->name . "</td>";
                        echo "\n\t\t<td class='pointer'>" . $row->email . "</td>";
                        echo "\n\t\t<td class='pointer'><a href='".base_url()."admin/gestio_clubs/elimina_usuari/".$row->id."/".$id."'><button class='btn btn-danger'>Eliminar</button></a></td>";

                        echo "\n\t</tr>";
                    endforeach;
                    ?>  
                </tbody>
            </table>

            <?php
            $att = array('role' => 'form');
            echo form_open('admin/gestio_clubs/nou_usuari', $att);
            ?>
            <div class="col-md-6">
                <input type='hidden' value='<?php echo $id; ?>' name='idClub'>
                <label for="competitionName">Nom d'usuari</label>
                <input type="text" class="form-control" id="userName" name='userName' placeholder="Introdueix el nom de l' usuari">

            </div>
            <div class="col-md-6">
                <label for="competitionName">Email</label>
                <input type="text" class="form-control" id="userEmail" name='userEmail' placeholder="Introdueix l'email  de l' usuari">
            </div>
            <div class="col-md-12">
                <input type="submit" class="btn btn-success" value='Guardar'>
            </div>
            <?php echo form_close(); ?>

        </div>
    </div>
</section>
<script>
    var myDropzone = new Dropzone("div#myId", {
        url: "<?php echo base_url() . "admin/gestio_clubs/puja_foto/$id"; ?>",
        dictDefaultMessage: "<span style='font-size:26px; color:#2a6496;'>\n\<i style='font-size:28px;' class=\"fa fa-cloud-upload fa-fw\"></i> Insertar arxiu per a pujar.",
        success: function (file, response) {
            document.getElementById('clubImage').value = response;
            document.getElementById("form").submit();
        }
    });

</script>