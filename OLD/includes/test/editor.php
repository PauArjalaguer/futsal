<?

if (!$_COOKIE['userName']) {
    header("Location: http://www.futsal.cat");
}

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

if (isset($_POST['new_submit'])) {
    if (!$_POST['id']) {

        $camps = "title,insertDate,updateDate, content,pathImage,categoryId,pinned";


        $valors = "'" . addslashes($_POST['newsTitle']) . "',";

        $valors .= "NOW(),";

        $valors .= "NOW(),";

        $valors .= "'" . addslashes($_POST['newsText']) . "',";


        $valors .= "'" . $_POST['image'] . "',";
        $valors .= "" . $_POST['categoryId'] . ",";
          $valors .= "'" . $_POST['pinned'] . "' ";


        $sql = "INSERT INTO news ($camps) VALUES ($valors)";
        //echo $sql;
        $res = mysql_query($sql) or die(mysql_error());
        $lastId = mysql_insert_id();


    } else {
        $sql = "update news set pinned='" . $_POST['pinned'] . "', title='" . addslashes($_POST['newsTitle']) . "', pathImage='" . $_POST['image'] . "', content='" . addslashes($_POST['newsText']) . "', categoryId=" . $_POST['categoryId'] . "  where id=" . $_POST['id'];
        //echo $sql;
        $res = mysql_query($sql) or die(mysql_error());
        $lastId=$_POST['id'];
    }
   header("Location: editor.php?id=".$lastId);
}

$news_per_page = 25;
if ($_GET['p']) {
    $page = $_GET['p'];
} else {
    $page = 1;
}
if ($page == 1) {
    $start = 0;
} else {
    $start = ($news_per_page * ($page - 1));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="../scripts/jquery-ui-1.10.4/js/jquery-ui-1.10.4.min.js" /></script>
       <link rel="stylesheet" type="text/css" href="../scripts/jquery-ui-1.10.4/css/ui-lightness/jquery-ui-1.10.4.min.css" />
        <script src="../scripts/ckeditor/ckeditor.js"></script>
        <title>Editor</title>
        <style>
            #popup_container
            {
                left: 0px;
                overflow: hidden;
                position: fixed;
                top: 50px;
                width: 100%;
                z-index: 2;
            }
            #popup
            {
                background-color: #fff;
                border: 1px solid #666;
                display: none;
                height: 50%;
                overflow: hidden;

                text-align: justify;
                width: 70%;
            }
            #alpha
            {
                background-color: #fff;
                display: none;
                height: 100%;
                left: 0px;
                position: fixed;
                top: 0px;
                width: 100%;
                z-index: 0;
                opacity: .0;
                filter: alpha(opacity=0);
                -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";


            }
            a{text-decoration: none; color:#fff;}
            .title{-webkit-border-radius: 5px 5px 0px 0px;
                   border-radius: 5px 5px 0px 0px; border:1px solid #ccc; background: #eeeeee; /* Old browsers */
                   background: -moz-linear-gradient(top,  #eeeeee 0%, #eeeeee 40%, #e5e5e5 100%); /* FF3.6+ */
                   background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#eeeeee), color-stop(40%,#eeeeee), color-stop(100%,#e5e5e5)); /* Chrome,Safari4+ */
                   background: -webkit-linear-gradient(top,  #eeeeee 0%,#eeeeee 40%,#e5e5e5 100%); /* Chrome10+,Safari5.1+ */
                   background: -o-linear-gradient(top,  #eeeeee 0%,#eeeeee 40%,#e5e5e5 100%); /* Opera 11.10+ */
                   background: -ms-linear-gradient(top,  #eeeeee 0%,#eeeeee 40%,#e5e5e5 100%); /* IE10+ */
                   background: linear-gradient(to bottom,  #eeeeee 0%,#eeeeee 40%,#e5e5e5 100%); /* W3C */
                   filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee', endColorstr='#e5e5e5',GradientType=0 ); /* IE6-9 */ padding:10px 15px; font-family: Helvetica; font-size:17px; color:#222; font-weight: bold;
            }
            th{font-family:Arial; font-size:15px; color:#555; font-weight: bold; background-color: #fff; border-bottom: 1px solid #ddd; text-align: left;}
            td{font-family: Arial; font-size:13px; color:#555;}

            .lastTd{background-color: #fff;border-top: 1px solid #ddd; }
            .paginator{padding:0 px ; text-align: right;}
            .paginatorItems{-webkit-border-radius: 3px;border-radius: 3px; border:1px solid #ddd; width:10px; float:left;  text-align:center; margin:0 3px; padding:5px; font-family: Verdana; font-size:10px; color:#57A000;}
            .paginatorItems a{color:#57A000;}
            .paginatorItems a:hover{color:#ddd;}
            .selectedPage{color:#fff;border:1px solid #57A000;background: #7dbc00; /* Old browsers */
                          background: -moz-linear-gradient(top,  #7dbc00 0%, #4e9a00 100%); /* FF3.6+ */
                          background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#7dbc00), color-stop(100%,#4e9a00)); /* Chrome,Safari4+ */
                          background: -webkit-linear-gradient(top,  #7dbc00 0%,#4e9a00 100%); /* Chrome10+,Safari5.1+ */
                          background: -o-linear-gradient(top,  #7dbc00 0%,#4e9a00 100%); /* Opera 11.10+ */
                          background: -ms-linear-gradient(top,  #7dbc00 0%,#4e9a00 100%); /* IE10+ */
                          background: linear-gradient(to bottom,  #7dbc00 0%,#4e9a00 100%); /* W3C */
                          filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7dbc00', endColorstr='#4e9a00',GradientType=0 ); /* IE6-9 */
            }
            .selectedPage a{color:#fff;}
            input, textarea, select{ width:850px; -webkit-border-radius: 3px;border-radius: 3px;  border:1px solid #ddd; padding:6px; background-color: #fff;



            }
        </style>
        <script type="text/javascript">
            function nuevoAjax(){
                var xmlhttp=false;
                try {
                    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e) {
                    try {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (E) {
                        xmlhttp = false;
                    }
                }

                if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
                    xmlhttp = new XMLHttpRequest();
                }
                return xmlhttp;
            }
            function opacity(id, opacStart, opacEnd, millisec) {
                //speed for each frame
                var speed = Math.round(millisec / 100);
                var timer = 0;

                //determine the direction for the blending, if start and end are the same nothing happens
                if(opacStart > opacEnd) {
                    for(i = opacStart; i >= opacEnd; i--) {
                        setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed));
                        timer++;


                    }
                } else if(opacStart < opacEnd) {
                    for(i = opacStart; i <= opacEnd; i++)
                    {
                        setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed));
                        timer++;
                    }
                }
            }

            //change the opacity for different browsers
            function changeOpac(opacity, id) {

                var object = document.getElementById(id).style;
                object.opacity = (opacity / 100);
                object.MozOpacity = (opacity / 100);
                object.KhtmlOpacity = (opacity / 100);
                object.filter = "alpha(opacity=" + opacity + ")";
                //document.getElementById("left").innerHTML=opacity;
                //	if(opacity==80){document.getElementById("alpha").style.visibility = "hidden";}
            }
            function showPopUp(){
                document.getElementById("alpha").style.display="block";
                var pos=document.documentElement.scrollTop+100;
                document.getElementById("popup_container").style.top=pos+"px";
                document.getElementById("popup").style.display="block";
                opacity("alpha",0,60,1000);
            }
            function closePopUp(){
                opacity("alpha",60,0,1000);
                document.getElementById("alpha").style.display="none";
                document.getElementById("popup").style.display="none";
                document.getElementById("popup").innerHTML="";
            }
            function NewsImagesShow(){
                showPopUp();

                ajax=nuevoAjax();
                ajax.open("GET","newsImageManagement.php",true);
                ajax.onreadystatechange=function() {
                    if (ajax.readyState==4) {
                        document.getElementById("popup").innerHTML=ajax.responseText;

                        fillImageContainer();
                    }
                }
                ajax.send(null);
            }
            function fillImageContainer(){

                ajax2=nuevoAjax();
                ajax2.open("GET","newsImageContainer.php",true);
                ajax2.onreadystatechange=function() {
                    if (ajax2.readyState==4) {
                        document.getElementById("imageContainer").innerHTML=ajax2.responseText;

                    }
                }
                ajax2.send(null);
            }
            function imageOptions(image){
                var cont=document.getElementById("imageOptions");
                cont.style.display="block";
                cont.innerHTML="<div style=' clear:both;border:1px solid #333; background-color:#666;padding:3px;'><table cellpadding=2 cellspacing=2><tr><td rowspan=2><img src='../newsImages/thumbs/"+image+"' width=40></td></tr><tr><td>http://www.futsal.cat/newsImages/"+image+"<br><span class='image_button' style='font-size:14px;' onclick=\"mainImage('"+image+"');\">insertar com imatge principal</span></td></tr></table></div>";
            }

            function insertImageInTextArea(image) {
                var	field=document.getElementById("newsText");
                field.focus();
                field.value += "\n<img src='"+image+"' />\n";
                closePopUp();
            }
            function mainImage(image){
                document.getElementById("image").value=image;
                document.getElementById("imageNew").src="../newsImages/thumbs/"+image;
                document.getElementById("imageNew").style.display="block";
                document.getElementById("trImageNew").style.display="block";
                closePopUp();
            }
            function eraseMainImage(image){
                document.getElementById("image").value="";
                document.getElementById("imageNew").src="";
                document.getElementById("imageNew").style.display="none";
                 document.getElementById("trImageNew").style.display="none";
                closePopUp();
            }
        </script>
    </head>
    <body style="background-color:#f0f0f0; font-family: Verdana;">
        <div id="web" style="margin:auto; width:960px; ">
            <div class="title" >Notícies</div>
            <div style="border: 1px solid #ccc; border-top:0; background-color:#fff; min-height: 300px; padding:15px;">
                <form name="form1"  enctype="multipart/form-data" method="post" action="editor.php?id=<? echo $_GET['id']; ?>">
                    <table width="100%" cellpadding="6" cellspacing="0">
                        <tr>
                            <td colspan="2">

                                
                                <img class='image_button' alt="Gestió imatges" src="../backOffice/images/pictures_icon.png" align="absbottom" onclick="NewsImagesShow();" /> |
                              
                            </td>
                        </tr>
                        <tr id="trImageNew" style="display:none;">
                            <td>Imatge principal</td>
                            <td colspan="6">  <img id="imageNew" onClick="eraseMainImage();" style="display:none;" /></td>
                        </tr>
                        <?
                        if ($_GET['id']) {
                            $query = "SELECT title, content,categoryId,pathImage, pinned from news where id=" . $_GET['id'];
                            $res = mysql_query($query);
                            $row = mysql_fetch_array($res);
                        }
                        ?>
                         <input type="hidden" id="image" name="image" value="<? echo stripslashes($row['pathImage']); ?>" />
                        <tr><td width="50">Títol</td><td><input type="text" name="newsTitle" value="<? echo stripslashes($row['title']); ?>"/></td></tr>
                        <tr><td width="50" valign="top">Text</td><td><textarea name="newsText" id="newsText" rows="50"><? echo stripcslashes($row['content']); ?></textarea></td></tr>


                        <tr>
                            <td>Categoría</td>
                            <td>
                                <input type="hidden" name="id" value="<? echo $_GET['id']; ?>"/>
                                <select name="categoryId">
                                    <?
                                    $sql2 = "SELECT * FROM newscategories order by category asc";
                                    $res2 = mysql_query($sql2) or die(mysql_error());
                                    while ($row2 = mysql_fetch_array($res2)) {
                                        if ($row2['id'] == $row['categoryId']) {
                                            $s = " selected";
                                        } else {
                                            $s = "";
                                        }
                                        echo "<option $s value=\"" . $row2['id'] . "\">" . $row2['category'] . "</option>";
                                    }
                                    ?>
                                </select> 

                            </td>
                        </tr>
                        <tr><td>Destacar</td><td><input type="text" name="pinned" id="datepicker" value="<? echo $row['pinned']; ?>" /></td></tr>
<tr><td colspan="3"><input type="submit" name="new_submit" value="Enviar" /></td></tr>
                    </table>
                </form>

            </div>

        </div>
        <div id="popup_container" align="center" ><div id="popup" style="width:1000px; background-color: #000; -webkit-box-shadow: 0px 0px 10px 5px rgba(0, 0, 0, 0.2);
                                                       -moz-box-shadow: 0px 0px 10px 5px rgba(0, 0, 0, 0.2);
                                                       box-shadow: 0px 0px 10px 5px rgba(0, 0, 0, 0.2);">&nbsp;</div></div>
        <div id="alpha" > &nbsp;</div>
    </body>
</html>
<script>
    CKEDITOR.replace( 'newsText');
    $(function() {
    $( "#datepicker" ).datepicker();
     $( "#datepicker" ).datepicker( "option", "dateFormat", "y-m-d" );

  });

</script>