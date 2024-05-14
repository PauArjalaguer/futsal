<div style="background-image:url(webImages/webBackground.jpg); text-align:right; font-size:8px; padding:0px 3px 0px 3px;"><span onClick="closePopUp();" class="button">X</span></div>
<div style="padding:6px;">
    <table width="100%" cellpadding="3" cellspacing="0">
        <tr>
            <td colspan="2" class="newTitle" style="border-bottom:1px solid #bbb;"> Enviar noticia</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
                
        <tr>
            <td>El teu nom:</td>
            <td><input type="text" id="senderName" /></td>
        </tr>
        
        
        <tr>
            <td>El seu nom:</td>
            <td><input type="text" id="receiverName" /></td>
        </tr>
        <tr>
            <td>El seu mail:</td>
            <td><input type="text" id="receiverMail" /><input type="hidden" value="<? echo $_GET['id']; ?>" id="idNew"></td>
        </tr>
        <tr>
            <td colspan="2" align="right"><input type="button" onClick="newsMailSend()" value="Enviar"></td>
        </tr>
	</table>
</div>