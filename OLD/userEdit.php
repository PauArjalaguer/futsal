


<?
include("Classes/Users_class.php");
$users=new Users;
$users->id=$_COOKIE['userId'];
$data=$users->getUserById();

?>
<div class="newHeader">
<div id='sectionTitle'><? echo $data[1]; ?></div>
<script type="text/javascript">
	var flashvars={ rotul:"<? echo $data[1]; ?>"};
	var params = { allowfullscreen : "true", wmode : "transparent", id : "myplayer", name : "myplayer" };
	var attributes ={};
	swfobject.embedSWF("http://www.futsal.cat/Rotul.swf", "sectionTitle", "630", "30", "9.0.0", null, flashvars, params,attributes);    
</script></div>
<div class="newContainer"><? if($_GET['result']=="ok"){echo "El teu perfil ha estat actualitzat";} ?>
<table border="0">
	<form action="userUpdate.php" method="post"
		enctype="multipart/form-data">
	<tr>
		<td><img id="userImage" src="users/avatars/<? echo $data[4]; ?>"><br />
		<!--  <img src="webImages/image.png" style="vertical-align: bottom;"> <span
			onClick='userShowAvatarForm();' style='cursor:pointer;'>Canviar foto</span>--></td>

		<td valign="top">Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input
			type="text" name="email" value="<? echo $data[3]; ?>" /><br />
		<br />
		Password: <input type="password" name="password"
			value="<? echo $data[2]; ?>" /><br />
		<br />
		<input type="submit" name="userUpdateSubmit" value="Enviar">
	
	</form>
	</td>
	</tr>
</table>
<div id="userPhotoUploaderForm" style="width:560px; border:1px solid #efefef; background-color:#dfdfdf; padding:10px; display:none; margin-top:10px;">
<table cellpadding=3 cellspacing=3>
<form method="post" enctype="multipart/form-data"
	action="userAvatarUpload.php" target="iframeUpload"><input
	type="hidden" name="userId" value="<?php  echo $_COOKIE['userId']; ?>" />
<input type="hidden" name="phpMyAdmin" /><tr><td> Arxiu:</td><td> <input
	name="fileUpload" type="file" /> </td></tr><tr><td><input type="submit" value="enviar"> </td></tr></table><iframe
	name="iframeUpload" style='border:0;'></iframe></form></div>

</div>
