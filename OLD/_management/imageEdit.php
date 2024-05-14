<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?
        $idClub = $_COOKIE['idClub'];
        //echo $idClub;
        ?>
        <link rel="stylesheet" href="css/css.css" />
        <link rel="stylesheet" href="scripts/imgAreaSelect/css/imgareaselect-default.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Administració</title>

        <script type="text/javascript" src="scripts/jquery.js"></script>
        <script type="text/javascript" src="scripts/imgAreaSelect/jquery.imgareaselect.js"></script>
    </head>

    <body>

        <div style="width:1000px; margin:10px auto ; border:2px solid; background-color: #fff; padding:10px;">
            <h1>Retalla la imatge del perfil del jugador</h1><br />
            <?
            include ("../includes/config.php");
            include ("../includes/funciones.php");
            conectar();
            $lastSeason = lastSeason();
            $lastSeasonId = $lastSeason[0];
            if ($_GET['cropFromPicture'] == "yes") {
                $sql = "select image from team_image_season where idTeam=" . $_GET['idTeam'] . " and idSeason=$lastSeasonId";
                $folder = "teamsImages";
            } else {
                $sql = "select image from players where id=" . $_GET['idPlayer'];
                $folder = "playersImages";
            }
            $res = mysql_query($sql) or die(mysql_error());
            $row = mysql_fetch_array($res);
            $imgSize = getimagesize("../images/dynamic/$folder/" . $row['image']);

            $imgSizeW = $imgSize[0];
            $imgSizeH = $imgSize[1];
            $ratio = $imgSizeH / $imgSizeW;
            $h = abs(640 * $ratio);

            $percent = ($imgSizeW / 640) * 100;
            //echo $imgSizeW." ".$percent;
            mysql_close();
            ?>
            <script>
                function preview(img, selection) {
                    var scaleX = 320 / (selection.width || 1);
                    var scaleY = 480 / (selection.height || 1);

                    $('#ferret + div > img').css({
                        width: Math.round(scaleX * 640) + 'px',
                        height: Math.round(scaleY * <? echo $h; ?>) + 'px',
                        marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
                        marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
                    });
                }

                $(document).ready(function () {
                    $('<div><img src="../images/dynamic/<? echo $folder . "/" . $row['image']; ?>" style="position: relative;" /><div>')
                    .css({
                        float: 'left',
                        position: 'relative',
                        overflow: 'hidden',
                        width: '320px',
                        height: '480px'
                    })
                    .insertAfter($('#ferret'));

                    $('#ferret').imgAreaSelect({ aspectRatio: '3:4.5', onSelectChange: preview,
                        onSelectEnd: function ( image, selection ) {

                            $('input[name=x1]').val(selection.x1);
                            $('input[name=y1]').val(selection.y1);
                            $('input[name=x2]').val(selection.x2);
                            $('input[name=y2]').val(selection.y2);
                            $('input[name=w]').val(selection.width);
                            $('input[name=h]').val(selection.height);

                            document.getElementById("cropButton").disabled=false;
                        }
                    });
                });</script>
            <img id="ferret" src="../images/dynamic/<? echo $folder . "/" . $row['image']; ?>" width="640" height="<? echo $h; ?>"  alt="It's coming right for us!"
                 title="It's coming right for us!" style="float: left; margin-right: 10px;" />
            <form action="imageCrop.php" method="post">
                <input type="hidden" name="cropType" value="<? echo $folder; ?>" />
                <input type="hidden" name="idPlayer" value="<? echo $_GET['idPlayer']; ?>" />
                <input type="hidden" name="idTeam" value="<? echo $_GET['idTeam']; ?>" />
                <input type="hidden" name="percent" value="<? echo $percent; ?>" />
                <input type="hidden" name="x1" value="" />

                <input type="hidden" name="y1" value="" />

                <input type="hidden" name="x2" value="" />

                <input type="hidden" name="y2" value="" />

                <input type="hidden" name="w" value="" />

                <input type="hidden" name="h" value="" />
                <input type="hidden" name="img" value="<? echo $row['image']; ?>" />

                <button type="submit" id="cropButton" value="Crop" disabled  style="width:100px;height:100px; padding:10px;font-size:16px;"/>Retallar</button>
            </form>

            <div style="clear: both;"></div>
        </div>
    </body>
</html>