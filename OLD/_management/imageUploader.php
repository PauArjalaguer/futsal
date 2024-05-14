<span style="font-weight: bold; font-size: 14px; color:#242424;">Pujar imatge del jugador</span>
<span style="font-weight: bold; font-size: 14px; color:#242424;float:right;width:10px; cursor: pointer;" onClick="hideModal();">X</span>
<div style='background-color:#bbb;'>
<?
$out .="<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"220\" height=\"30\" id=\"fileUploader\" align=\"middle\">
    <param name=\"movie\" value=\"flash/fileUploader.swf\" />
    <param name=\"quality\" value=\"high\" />
    <param name=\"bgcolor\" value=\"#dddddd\" />
    <param name=\"play\" value=\"true\" />
    <param name=\"loop\" value=\"true\" />
    <param name=\"wmode\" value=\"window\" />
    <param name=\"scale\" value=\"showall\" />
    <param name=\"menu\" value=\"true\" />
    <param name=\"devicefont\" value=\"false\" />
    <param name=\"salign\" value=\"\" />
    <param name=\"allowScriptAccess\" value=\"sameDomain\" />
    <param name=FlashVars value=\"idTeam=".$_GET['idTeam']."&idPlayer=".$_GET['idPlayer']."&fileType=image\">

    <!--[if !IE]>-->
    <object type=\"application/x-shockwave-flash\" data=\"flash/fileUploader.swf\" width=\"220\" height=\"30\">
        <param name=\"movie\" value=\"flash/fileUploader.swf?idPlayer=".$_GET['idPlayer']."&fileType=image\" />
        <param name=\"quality\" value=\"high\" />
        <param name=\"bgcolor\" value=\"#dddddd\" />
        <param name=\"play\" value=\"true\" />
        <param name=\"loop\" value=\"true\" />
        <param name=\"wmode\" value=\"window\" />
        <param name=\"scale\" value=\"showall\" />
        <param name=\"menu\" value=\"true\" />
        <param name=\"devicefont\" value=\"false\" />
        <param name=\"salign\" value=\"\" />
        <param name=\"allowScriptAccess\" value=\"sameDomain\" />
        <param name=FlashVars value=\"idTeam=".$_GET['idTeam']."&idPlayer=".$_GET['idPlayer']."&fileType=image\">

<!--<![endif]-->
        <a href=\"http://www.adobe.com/go/getflash\">
            <img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Obtener Adobe Flash Player\" />
        </a>
        <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
</object>";

echo utf8_encode($out);

?></div>