<?php
//echo "<pre>"; print_r(get_defined_vars()); echo "</pre>";
if ($idClub) {
    $disabled = "disabled";
    $styleDisabled = "style='display:none;'";
}else{
    $disabled="";
    $styleDisabled="";
}
?>

<section class="content-header">
    <h1 >
        <?php
        /*
          if (isset($idClub)) {
          $title = "Editar club";
          $clubs->idClub = $_GET['idClub'];
          $data = $clubs->clubsGetById();
          // print_r($data);
          } else {
          $title = "Nou club";
          }
          echo $title; */
        echo $name;
        ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Clubs</a></li>
        <li class="active"><?php echo $name; ?></li>
    </ol>
</section>
<section class="content">
    <div class="panel panel-default">
        <div class="panel-body"> 
            <div class="row">

                <section class="col-md-12 connectedSortable">  

                    <div class="nav-tabs-custom">
                        <!-- Tabs within a box -->
                        <ul class="nav nav-tabs pull-right">
                            <li class="active" ><a href="#clubDataContainer" data-toggle="tab">Dades</a></li>
                            <li <? echo $styleDisabled; ?>><a href="#clubTeamsContainer" data-toggle="tab">Equips</a></li>
                            <li <? echo $styleDisabled; ?>><a href="#clubTeamsTransfersContainer" data-toggle="tab">Traspassos</a></li>
                            <li <? echo $styleDisabled; ?>><a href="#clubAccountsContainer" data-toggle="tab">Comptes</a></li>
                        </ul>
                        <div class="tab-content no-padding">
                            <?php
                            $att = array('role' => 'form', 'id' => 'form');
                            echo form_open('admin/clubs/modifica/' . $id, $att);
                            ?>
                            <div id="clubDataContainer" class="chart tab-pane active" >
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nom del club</label>
                                            <input  readonly="readonly" name='clubName' class="form-control" value="<?php echo $name; ?>">
                                        </div> 
                                    </div>
                                    <div class="col-lg-6" <? echo $styleDisabled; ?>>
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
                                    } else {
                                        $newsImageContainerDisplay = "block";
                                        $newsImageContainerClass = "col-lg-2";

                                        $newsUploaderContainer = "col-lg-3";
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


                                <?
                                /* if ($_GET['idClub']) {
                                $idClub = $_GET['idClub'];
                                } else {
                                $idClub = 0;
                                }*/
                                ?>

                                <input type="submit" class="btn btn-lg btn-info" value='Desar'>
                                <?php echo form_close(); ?>
                            </div>
                            <div id="clubTeamsContainer" class="chart tab-pane" >
                                <div class="row">
                                    <div class='col-lg-4'>  
                                        <label>Nou equip</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" id="clubsNewTeamInput" value="<? echo utf8_encode($data[1]); ?>">
                                            <span class="input-group-btn">
                                                <button class="btn btn-info btn-flat" type="button" onClick="clubsTeamNewInsert( < ? echo $_GET['idClub']; ? > )">Crear</button>
                                            </span>
                                        </div><!-- /input-group -->
                                    </div>
                                </div>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nom</th>
                                            <th>Divis&oacute;</th>
                                            <th>Dia i hora que juga</th>

                                            <th colspan="1">Accions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?/*
                                        $data = $clubs->clubsGetTeambByIdClub();
                                        $teamsArray = $data;
                                        if ($data[3] == 1) {
                                        $day = "Diumenge";
                                        } else if ($data[3] == 7) {
                                        $day = "Dissabte";
                                        }
                                        foreach ($data as $team) {

                                        echo "<tr><td>" . $team[0] . "</td><td> " . utf8_encode($team[1]) . "</td><td>" . utf8_encode($team[2]) . "</td><td>" . $day . " " . utf8_encode($team[4]) . "</td><td>" . utf8_encode($team[2]) . "</td></tr>";
                                        }*/
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="clubAccountsContainer" class="chart tab-pane" >Comptes</div>
                            <div id="clubTeamsTransfersContainer" class="chart tab-pane" > 
                                <div class="row">
                                    <div class='col-lg-4'>  
                                        <label>Traspassos</label>
                                    </div>
                                </div>
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nom</th>
                                            <th>Equip</th>
                                            <th>Valor</th>

                                            <th colspan="1">Accions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        /*
                                        $data = $clubs->clubsGetPlayersByIdClub();
                                        //print_r($data);

                                        foreach ($data as $player) {
                                        if (isset($player[4])) {
                                        $rate = $player[4];
                                        } else {
                                        $rate = $player[3];
                                        }
                                        echo "<tr><td>" . $player[0] . "</td><td> " . utf8_encode($player[1]) . "</td><td>" . utf8_encode($player[2]) . "</td><td>" . $rate . "</td><td> Preu: <input type=\"text\"  style='width:40px; text-align:center;' id=\"clubsTeamTransferSelectorPrice_" . $player[0] . "\" value=\"" . $rate . "\"> <select id=\"clubsTeamTransferSelector_" . $player[0] . "\"  onChange=\"clubsTransferPlayer(" . $player[0] . ");\"><option></option>";
                                        foreach ($teamsArray as $t) {
                                        echo "\n\t<option value=\"" . $t[0] . "\">" . $t[1] . "</option>";
                                        }

                                        echo "</select> </td></tr>";
                                        }*/
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
<script>
    var myDropzone = new Dropzone("div#myId", {
        url: "<?php echo base_url() . "admin/clubs/puja_foto/$id"; ?>",
        dictDefaultMessage: "<span style='font-size:26px; color:#2a6496;'>\n\<i style='font-size:28px;' class=\"fa fa-cloud-upload fa-fw\"></i> Insertar arxiu per a pujar.",
        success: function (file, response) {
            //alert(response);
            document.getElementById('clubImage').value=response;
            document.getElementById("form").submit();
        //location.reload();
           


        }
    });
    
</script>