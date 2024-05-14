<?

if (!$_COOKIE['userName']) {
    header("Location: http://www.futsal.cat");
}
//echo $idClub;

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$news_per_page = 25;
if($_GET['p']){
    $page=$_GET['p'];
}else{
    $page=1;
}
if($page==1){
    $start=0;
}else{
    $start=($news_per_page*($page-1));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
        <title>Editor</title>
        <style>
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
            tr:nth-child(odd) {background: #fff}
            tr:nth-child(even) {background: #F3F3F3; border-top:1px solid;}
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
        </style>
    </head>
    <body style="background-color:#f0f0f0; font-family: Verdana;">
        <div id="web" style="margin:auto; width:960px; ">
            <div class="title" >
                <div style="width:50%; float:left;">Notícies</div>
                <div style="width:50%; float:left; text-align: right;"><a href="editor.php"><img src="http://www.gettyicons.com/free-icons/133/shimmer/png/16/document_add_16.png"></a></div>
                <div style="clear:both;"></div>
            </div>
            <div style="border: 1px solid #ccc; border-top:0; background-color:#fff; min-height: 300px; padding:15px;">
                <table width="100%" cellspacing="0" cellpadding="6">
                    <tr><th width="30"><input type="radio" /></th><th>Títol</th><th>Categoría</th><th>Data</th><th colspan="3">Accions</th></tr>
                    <?
                    $query = "select count(*) as c from news";
                    $res = mysql_query($query);
                    $row = mysql_fetch_array($res);
                    $number_of_news = $row['c'];

                    $query = "SELECT n.id, title, insertdate, category, content
FROM  `news` n
JOIN newscategories nc ON nc.id = n.categoryid
order by     n.id desc
LIMIT $start , $news_per_page ";
                    $res = mysql_query($query);
                    while ($row = mysql_fetch_array($res)) {
                        echo "<tr><td><input type='radio'></td><td>" . stripcslashes($row['title']) . "</td><td>" . $row['category'] . "</td><td>" . invertdateformat($row['insertdate']) . "</td><td><a href='editor.php?id=".$row['id']."'><img src='../admin/images/pencil.png' /></a></td><td><img src='../admin/images/cross.png' /></td></tr>";
                    }
                    echo "<tr><td colspan=10 class='lastTd'>&nbsp;</td></tr>";
                    ?>

                </table>
                <div class="paginator" align="right">
                    <?
                    $pages = floor($number_of_news / $news_per_page);
                    for ($i = 1; $i <= $pages; $i++) {
                        if($page==$i){
                            $class=" selectedPage";
                        }else{
                            $class="";
                        }
                        echo "<div class='paginatorItems $class'><a href='?p=$i'>$i</a></div>";
                    }
                    echo "<div style='clear:both;'></div>";
                    ?>

                </div>
            </div>

        </div>
    </body>
</html>
