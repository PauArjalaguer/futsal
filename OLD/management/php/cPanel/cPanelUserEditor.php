<?
include("../../Classes/db.inc");
include("../../Classes/cPanel_Class.php");
include("../../Classes/Competition_Class.php");
?>
<section class="content-header">
    <h1 onClick="cPanelUserEdit(<? echo $_GET['idUser']; ?>)">
        <?
        $cPanel = new cPanel();

        $cPanel->idUser = $_GET['idUser'];

        $data = $cPanel->cPanelUsersGetById();

        echo "Editar usuari";
        //print_r($data);
        ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Usuaris</a></li>
        <li class="active"><? echo "Editar usuari"; ?></li>
    </ol>
</section>

<div class="panel panel-default">
    <div class="panel-body"> 

        <div class="row">
            <!-- Custom tabs (Charts with tabs)-->
            <section class="col-md-12 connectedSortable">                            

                <div class="nav-tabs-custom">
                    <!-- Tabs within a box -->
                    <ul class="nav nav-tabs pull-right">
                        <li class="active"><a href="#userDataContainer" data-toggle="tab">Dades</a></li>
                        <li><a href="#userPermissions" data-toggle="tab">Permisos</a></li>
                        <li class="pull-left header"><i class="fa fa-user"></i> Usuari</li>
                    </ul>
                    <div class="tab-content no-padding">
                        <div id="userDataContainer" class="chart tab-pane active" style='padding:9px;'>
                            <div class="row">
                                <?
                                if (empty($data[6])) {
                                    $userAvatarDivDisplay = "none";
                                    $imageUploaderClass = "col-lg-6";
                                } else {
                                    $imageUploaderClass = "col-lg-3";
                                }
                                ?>
                                <div  class="col-lg-3"  style='display:<? echo $userAvatarDivDisplay; ?>' id="userAvatarContainer">  
                                    <label>Imatge</label>
                                    <div>
                                        <div style='width: 200px; height: 200px; border-radius: 150px;-webkit-border-radius: 150px; -moz-border-radius: 150px; background: url(../users/avatars/thumbs/<? echo $data[6]; ?>) no-repeat;' id="userAvatarImage" >
                                            <input type='hidden' id='userAvatarInput' value='<? echo $data[6]; ?>' />
                                        </div>
                                    </div>
                                </div>
                                <div class="<? echo $imageUploaderClass; ?>" id="imageUploaderContainer">

                                    <label>Pujar imatge</label>
                                    <div id="imageUploader">
                                        <div id="myId" class="dropzone"></div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Nom</label>
                                        <input id='userName' class="form-control" value="<? echo utf8_encode($data[1]); ?>">
                                    </div> 
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input id='userEmail' class="form-control" value="<? echo utf8_encode($data[4]); ?>">
                                    </div> 

                                </div>


                                <div class="col-lg-3">
                                    <div class="form-group">

                                        <label>Login</label>
                                        <input id='userLogin' class="form-control" value="<? echo utf8_encode($data[2]); ?>">
                                    </div> 

                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input id='userPassword' class="form-control" value="<? echo utf8_encode($data[3]); ?>">
                                    </div> 

                                </div> 

                            </div>
                             <button type="submit" class="btn btn-lg btn-primary" onClick='fileSave(<? echo $_GET['idFile']; ?>, true)'>Desar i tornar</button>       
                <button type="submit" class="btn btn-lg btn-info" onClick='fileSave(<? echo $_GET['idFile']; ?>, false)'>Desar</button>

                        </div>
                        <div id="userPermissions" class="tab-pane" style='padding:9px;'>
                            <div class="row">
                                <div class='col col-lg-12'>



                                    <?
                                    $data2 = $cPanel->cPanelGetAllSectionsByUser();

                                    foreach ($data2 as $perm) {
                                        if ($perm[2] >= 1) {
                                            $checked = "checked";
                                        } else {
                                            $checked = "";
                                        }
                                        echo "<div class=\"checkbox\"><label>
                                                    <input onChange=\"cPanelUserPermissionsUpdate(".$_GET['idUser'].",".$perm[0].")\"  type=\"checkbox\" id=\"userPermissionsRadio_" . $perm[0] . "\" $checked/>
                                                    " . utf8_encode($perm[1]) . "
                                                </label></div>";
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
               
            </section>

        </div>
    </div>

</div>


