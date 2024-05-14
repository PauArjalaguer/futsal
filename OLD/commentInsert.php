<? if(isset($_POST['commentSubmit'])){
	include ("includes/db.inc");
	include("Classes/News_class.php");
	$news=new News;
	$news->idNew=$_POST['commentIdNew'];
	$news->idUser=$_POST['commentIdUser'];
	$news->comment=$_POST['commentText'];
	$data=$news->insertComment();
	$num=count($data);
	if(ereg("#comments",$_SERVER['HTTP_REFERER'])){
		header ("Location: ".$_SERVER['HTTP_REFERER']);
	}else{
		header ("Location: ".$_SERVER['HTTP_REFERER']."#comments");
	}
	
}
?>