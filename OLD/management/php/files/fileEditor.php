<?
include("../../Classes/db.inc");
include("../../Classes/Files_Class.php");
include("../../Classes/Competition_Class.php");
?>
<section class="content-header">
    <h1>
        <?
        $files = new Files();
        
            $files->idFile = $_GET['idFile'];
            $data = $files->filesGetById();
       
        echo "Editar arxiu";
        ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Arxius</a></li>
        <li class="active"><?  echo "Editar arxiu";  ?></li>
    </ol>
</section>

<div class="panel panel-default">


    <div class="panel-body"> 
        <div class="form-group">
            <label>Títol</label>
            <input id='fileTitle' class="form-control" value="<? echo utf8_encode($data[2]); ?>">
        </div> 
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Categor&iacute;a</label>
                    <select  id='fileCategory' class="form-control">
                    <?
                    $data2 = $files->filesGetCategories();
                    foreach ($data2 as $cat) {
                        if($cat[0]==$data[6]){
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
       
    </div>

  
  
   
  

  
    <button type="submit" class="btn btn-lg btn-primary" onClick='fileSave(<? echo $_GET['idFile']; ?>,true)'>Desar i tornar</button>       
    <button type="submit" class="btn btn-lg btn-info" onClick='fileSave(<? echo $_GET['idFile']; ?>,false)'>Desar</button>
</div>
