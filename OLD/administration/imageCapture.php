<span style="font-weight: bold; font-size: 14px; color:#242424;">Capturar imatge del jugador </span>
<span style="font-weight: bold; font-size: 14px; color:#242424;float:right;width:10px; cursor: pointer;" onClick="hideModal();">X</span>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553554000" width="640" height="540" id="imageCapturer" align="middle">
    <param name="movie" value="flash/imageCapturer.swf" />
    <param name="quality" value="high" />
    <param name="bgcolor" value="#ffffff" />
    <param name="play" value="true" />
    <param name="loop" value="true" />
    <param name="wmode" value="window" />
    <param name="scale" value="showall" />
    <param name="menu" value="true" />
    <param name="devicefont" value="false" />
    <param name="salign" value="" />
    <param name="allowScriptAccess" value="sameDomain" />
    <param name=FlashVars value="idTeam=<? echo $_GET['idTeam']; ?>&idPlayer=<? echo $_GET['idPlayer']; ?>">
    <!--[if !IE]>-->
    <object type="application/x-shockwave-flash" data="flash/imageCapturer.swf" width="640" height="540">
        <param name="movie" value="flash/imageCapturer.swf?idTeam=<? echo $_GET['idTeam']; ?>&idPlayer=<? echo $_GET['idPlayer']; ?>" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#ffffff" />
        <param name="play" value="true" />
        <param name="loop" value="true" />
        <param name="wmode" value="window" />
        <param name="scale" value="showall" />
        <param name="menu" value="true" />
        <param name="devicefont" value="false" />
        <param name="salign" value="" />
        <param name="allowScriptAccess" value="sameDomain" />
        <param name=FlashVars value="idTeam=<? echo $_GET['idTeam']; ?>&idPlayer=<? echo $_GET['idPlayer']; ?>">
        <!--<![endif]-->
        <a href="http://www.adobe.com/go/getflash">
            <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Obtener Adobe Flash Player" />
        </a>
        <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
</object>