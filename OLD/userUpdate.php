<?
if(isset($_POST['userUpdateSubmit'])){
	include ("includes/db.inc");
	include("includes/funciones.php");
	include("Classes/Users_class.php");
	$users=new Users;
	
	$users->id=$_COOKIE['userId'];
	$users->email=$_POST['email'];
	$users->password=$_POST['password'];
	$data=$users->userUpdate();
	
	header ("Location: usuari/edita/ok");
			
}
?>