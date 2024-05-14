<div class="newHeader"><h1 id="sectionTitle">Registre</h1></div>
<script type="text/javascript">
	var flashvars={ rotul:"Registre"};
	var params = { allowfullscreen : "true", wmode : "transparent", id : "myplayer", name : "myplayer" };
	var attributes ={};
	swfobject.embedSWF("<? echo $serverUrl; ?>Rotul.swf", "sectionTitle", "630", "30", "9.0.0", null, flashvars, params,attributes);    
</script>
<div class="Container">
	<table><form action="register.php" enctype="multipart/form-data" method="post">
    	<tr>
        	<td>Nom:</td>
            <td><input type="text" name="login" /></td>
        </tr>
        <tr>
        	<td>Email:</td>
            <td><input type="text" name="email" /></td>
        </tr>
        
        <tr>
        	<td>Foto:</td>
            <td><input type="file" name="avatar"></td>
        <tr>
        	<td align="left">
            	
             </td>
        	<td  align="right">
				<input type="submit" value="Entrar" name="registerSubmit" /></form>
            </td>
        </tr>
    </table>
</div>