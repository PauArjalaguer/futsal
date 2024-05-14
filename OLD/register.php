<?
if(isset($_POST['registerSubmit'])){
	include ("includes/db.inc");
	include("includes/funciones.php");
	include("Classes/Users_class.php");
	$users=new Users;
	$users->login=$_POST['login'];
	$users->pass=substr(md5(uniqid(rand())),0,7);
	$users->email=$_POST['email'];
	
	if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
    	$foto = substr(md5(uniqid(rand())),0,3).$_FILES['file']['name'].".jpg";
		chmod("users/avatars", 0777) ;
   		 move_uploaded_file($_FILES['avatar']['tmp_name'], "users/avatars/$foto") ;
		 //redimensionar("users/avatars/$foto");
		$users->avatar=$foto;
	}
	$data=$users->insertUser();
	$lastId=  mysql_insert_id();
	include("registerMailSend.php");
	header ("Location: usuari/registrat");
			
}
?>