<?
include("../../Classes/db.inc");
include("../../Classes/News_Class.php");
include("../../Classes/Competition_Class.php");
?>
<section class="content-header">
    <h1>
        <?
        $news = new News;
        if (isset($_GET['idNew'])) {
            $title = "Editar noticia";
            $news->idNew = $_GET['idNew'];
            $data = $news->newsGetById();
        } else {
            $title = "Nova not&iacute;cia";
        }
        echo $title;
        ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Not&iacute;cies</a></li>
        <li class="active"><? echo $title; ?></li>
    </ol>
</section>

<div class="panel panel-default">


    <div class="panel-body"> 
        <div class="form-group">
            <label>Títol</label>
            <input id='newsTitle' class="form-control" value="<? echo utf8_encode($data[1]); ?>">
        </div> 
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Categor&iacute;a</label>
                    <select  id='newsCategory'' class="form-control">
                    <?
                    $data2 = $news->newsGetCategories();
                    foreach ($data2 as $cat) {
                        if($cat[0]==$data[5]){
                            $s="selected";
                        }else{
                            $s="";
                        }
                        echo "\n\t<option $s value=\"" . $cat[0] . "\">" . utf8_encode($cat[1]) . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Destacar</label>
                <input   class="form-control" id="datepicker" value="<? echo $data[6]; ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <?
        if (empty($data[3])) {
            $newsImageContainerDisplay = "none";
            $newsLibraryContainerClass = "col-lg-6";
            $newsUploaderContainer = "col-lg-6";
        } else {
            $newsImageContainerDisplay = "block";
            $newsImageContainerClass = "col-lg-2";
            $newsLibraryContainerClass = "col-lg-7";
            $newsUploaderContainer = "col-lg-3";
        }
        ?>
        <div style='display:<? echo $newsImageContainerDisplay; ?>;' id="newsImageContainer" class="<? echo $newsImageContainerClass; ?>">
            <label>Imatge</label><br />
            <img id="newsImageContainerImage" src='http://wwww.futsal.cat/newsImages/<? echo utf8_encode($data[3]); ?>' />

        </div>
        <div class="<? echo $newsLibraryContainerClass; ?>" id="newsLibraryContainer">
            <label>Imatges disponibles</label>
            <div class="well" id="imageContainer">


            </div>
        </div>	
        <div class="<? echo $newsUploaderContainer; ?>"  id="newsUploaderContainer">
            <label>Pujar imatge</label>
            <div id="imageUploader">
                <div id="myId" class="dropzone"></div>
            </div>

        </div>
    </div>
    <div class="form-group box">
        <div class='box-header'>

            <label>Text</label>
            <textarea class="form-control" name="newsText" id="newsText" rows="20"><? echo utf8_encode($data[2]); ?></textarea>
        </div>
    </div>
    <div class="row box">
        <div class="box-header"><h3 class='box-title'>Buscador de partits <small>Busca un partit pels equips que l' han jugat</small></h3></div>
        <div class="col-lg-12">
            <label>Buscar partit</label>
            <input onKeyUp="newsMatchSearch()"  id='newsMatchSearchInput' class="form-control" >
        </div>

    </div>
    <div class="row box">
        <div class="box-header"><h3 class='box-title'>Assignar partits <small>Assigna un partit a la not&iacute;cia</small></h3></div>
        <div class="col-lg-4">
            <label>Lliga</label>
            <select class="form-control" onChange="newsMatchSearchSelectLeague();" id="newsMatchSearchLeagueSelect">
                <option></option>
                <?
                $competition = new Competition;
                $data2 = $competition->cmptGetLeagues();
                foreach ($data2 as $cat) {
                    if ($cat[2] != $d) {
                        echo "\n\t<option disabled>" . utf8_encode($cat[2]) . "</option>";
                    }
                    echo "\n\t<option value=\"" . $cat[0] . "\">- " . utf8_encode($cat[1]) . "</option>";
                    $d = $cat[2];
                }
                ?>   	
            </select>

        </div>
        <div class="col-lg-4" id="newsMatchSearchRoundContainer">
            <label>Jornada</label>

        </div>
        <div class="col-lg-4" id="newsMatchSearchMatchContainer">
            <label>Partit</label>
        </div>
        <? // print_r($data); ?>
        <input type="hidden" id="newsMatchSearchMatchSelected" name="newsMatchSearchMatchSelected" value="<? if(!is_array($data[7])){echo $data[7];} ?>" ></input>
        <input type="hidden" id="newsImageAssigned" name="newsImageAssigned" value="<? if(!is_array($data[3])){echo $data[3];} ?>"></input>


    </div>

    <?
    if ($_GET['idNew']) {
        $idNew = $_GET['idNew'];
    } else {
        $idNew = 0;
    }
    ?>
    <button type="submit" class="btn btn-lg btn-primary" onClick='newsSave(<? echo $idNew; ?>,true)'>Desar i tornar</button>       
    <button type="submit" class="btn btn-lg btn-info" onClick='newsSave(<? echo $idNew; ?>,false)'>Desar</button>
</div>
