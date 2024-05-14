<?php
include ("includes/db.inc");
include("Classes/Users_class.php");
$users=new Users;
// Script Que copia el archivo temporal subido al servidor en un directorio.
/*echo '<p>Nombre Temporal: '.$_FILES['fileUpload']['tmp_name'].'</p>';
echo '<p>Nombre en el Server: '.$_FILES['fileUpload']['name'].'</p>';
echo '<p>Tipo de Archivo: '.$_FILES['fileUpload']['type'];*/
$tipo = substr($_FILES['fileUpload']['type'], 0, 5);
$imageName=substr(md5(uniqid(rand())),0,7).".jpg";
// Definimos Directorio donde se guarda el archivo
$dir = 'users/avatars/';
// Intentamos Subir Archivo
// (1) Comprovamos que existe el nombre temporal del archivo
if (isset($_FILES['fileUpload']['tmp_name'])) {
	// (2) - Comprovamos que se trata de un archivo de im‡gen
	if ($tipo == 'image') {
		// (3) Por ultimo se intenta copiar el archivo al servidor.
		if (!copy($_FILES['fileUpload']['tmp_name'], $dir.$imageName))
		echo '<script> alert("Error al Subir el Archivo");</script>';
	}
	else echo 'El Archivo que se intenta subir NO ES del tipo Imagen.';
}
else echo 'El Archivo no ha llegado al Servidor.';
$users->image=$imageName;
$users->id=$_POST['userId'];
$data=$users->userUpdateImage();

include("includes/funciones.php");
redimensionar("users/avatars/".$imageName);
echo "<a href=\"".$_SERVER['php_self']."\">Continuar</a>";
echo "<img src=\"users/avatars/".$imageName."\" width=100>";
echo "<script> parent.location.reload();</script>";



?>
