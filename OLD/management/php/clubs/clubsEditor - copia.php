<?
include("../../Classes/db.inc");
include("../../Classes/Clubs_Class.php");
?>
<section class="content-header">
    <h1 onClick='clubsEdit(<? echo $_GET['idClub']; ?>)'>
        <?
        $clubs = new Clubs;
        if (isset($_GET['idClub'])) {
            $title = "Editar club";
            $clubs->idClub = $_GET['idClub'];
            $data = $clubs->clubsGetById();
           // print_r($data);
        } else {
            $title = "Nou club";
        }
        echo $title;
        ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Clubs</a></li>
        <li class="active"><? echo $title; ?></li>
    </ol>
</section>

<div class="panel panel-default">


    <div class="panel-body"> 
             <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Nom del club</label>
                <input id='clubName' class="form-control" value="<? echo utf8_encode($data[1]); ?>">
            </div> 
        </div>
        <div class="col-lg-6">
            <label>Codi de club</label>
            <input id='clubCode' class="form-control" value="<? echo utf8_encode($data[12]); ?>">
        </div>
             </div>
        <div class="row">
            <div class="col-lg-6">
                <label>Adreça</label>
                <input   class="form-control" id="clubAddress" value="<? echo $data[4]; ?>">  
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Ciutat</label>
                    <input   class="form-control" id="clubCity" value="<? echo $data[9]; ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <label>Telefon 1 </label>
                <input   class="form-control" id="clubPhone1" value="<? echo $data[5]; ?>">  
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Telefon 2</label>
                    <input   class="form-control" id="clubPhone2" value="<? echo $data[6]; ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Email</label>
                    <input   class="form-control" id="clubEmail" value="<? echo $data[8]; ?>">
                </div>
            </div>
        </div>


        <div class="form-group box">
            <div class='box-header'>

                <label>Text</label>
                <textarea class="form-control" name="clubText" id="clubText" rows="20"><? echo nl2br($data[2]); ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <label>Facebook</label>
                <input   class="form-control" id="clubFacebook" value="<? echo $data[10]; ?>">  
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Twitter</label>
                    <input   class="form-control" id="clubTwitter" value="<? echo $data[11]; ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Web</label>
                    <input   class="form-control" id="clubWeb" value="<? echo $data[7]; ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <?
            if (empty($data[3])) {
                $newsImageContainerDisplay = "none";

                $newsUploaderContainer = "col-lg-6";
            } else {
                $newsImageContainerDisplay = "block";
                $newsImageContainerClass = "col-lg-2";

                $newsUploaderContainer = "col-lg-3";
            }
            ?>
            <div style='display:<? echo $newsImageContainerDisplay; ?>;' id="newsImageContainer" class="<? echo $newsImageContainerClass; ?>">
                <label>Imatge</label><br />
                <img id="newsImageContainerImage" src='http://www.futsal.cat/webImages/clubsImages/<? echo utf8_encode($data[3]); ?>' />
                <input type="hidden" id="clubImage" value="<? echo $data[3]; ?>" />
            </div>

            <div class="<? echo $newsUploaderContainer; ?>"  id="newsUploaderContainer">
                <label>Pujar imatge</label>
                <div id="imageUploader">
                    <div id="myId" class="dropzone"></div>
                </div>

            </div>
        </div>


        <?
        if ($_GET['idClub']) {
            $idClub = $_GET['idClub'];
        } else {
            $idClub = 0;
        }
        ?>
        <button type="submit" class="btn btn-lg btn-primary" onClick='clubsSave(<? echo $idClub; ?>, true)'>Desar i tornar</button>       
        <button type="submit" class="btn btn-lg btn-info" onClick='clubsSave(<? echo $idClub; ?>, false)'>Desar</button>
    </div>
