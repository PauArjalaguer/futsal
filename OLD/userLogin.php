<div class="newHeader"><h1 id="sectionTitle">Login</h1></div>
<script type="text/javascript">
	var flashvars={ rotul:"Login"};
	var params = { allowfullscreen : "true", wmode : "transparent", id : "myplayer", name : "myplayer" };
	var attributes ={};
	swfobject.embedSWF("<? echo $serverUrl; ?>Rotul.swf", "sectionTitle", "630", "30", "9.0.0", null, flashvars, params,attributes);    
</script>
<div class="Container">
	<table><form action="login.php" enctype="multipart/form-data" method="post">
    	<tr>
        	<td>Nom:</td>
            <td><input type="text" name="login" /></td>
        </tr>
        <tr>
        	<td>Password:</td>
            <td><input type="text" name="password" /></td>
        </tr>
        <tr>
        	<td align="left">
            	<input type="checkbox" name="remember"> Recordar
                <input type="hidden" value=<? echo $_SERVER['HTTP_REFERER']; ?> name="referer">
             </td>
        	<td  align="right">
				<input type="submit" value="Entrar" name="loginSubmit" /></form>
            </td>
        </tr>
    </table>
</div>