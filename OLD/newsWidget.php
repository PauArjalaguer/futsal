<?

$out ="";
if($_GET['field']=="visits" or empty($_GET['field'])){
	$visitsClass="activeTab";
	$rateClass="inactiveTab";
	$sendClass="inactiveTab";
}else if($_GET['field']=="rate"){
	$visitsClass="inactiveTab";
	$rateClass="activeTab";
	$sendClass="inactiveTab";
}else{
	$visitsClass="inactiveTab";
	$rateClass="inactiveTab";
	$sendClass="activeTab";}
$out .= "<div id=\"news_visits\"  class='$visitsClass' onclick=\"newsWidget('visits');\">&bull; Noticies més vistes</div>
<div id=\"news_rate\" class='$rateClass' onclick=\"newsWidget('rate');\">&bull; Més votades</div>
<div id=\"news_send\" class='$sendClass' onclick=\"newsWidget('send');\">&bull; Més enviades</div>";


$out .="<div id=\"newsWidgetContainer\">"; 	
	if(isset($_GET['field'])){
		include ("includes/db.inc");
		include ("includes/funciones.php");
		include("Classes/News_class.php");
	}
	$news=new News;
	$news->tablename="news";
	if(isset($_GET['field'])){
		$news->order=" ".$_GET['field']." desc";
	}
	else{
		$news->order="visits desc";
	}
	$news->fields="Id,Title,Content,PathImage,InsertDate";
	$news->pageno=1;
	$news->rows_per_page=10;
	$data=$news->getInitialNews($where);
	foreach($data as $noticia){
		$out .= ". <a href='".$serverUrl."noticia/".$noticia[0]."-".str_replace(" ","-",treuAccents($noticia[1]))."'>".$noticia[1]."</a><br />";
	}
	if(isset($_GET['field'])){
		echo utf8_encode($out);
	}else{
		echo $out;
	}
	
						?>
						</div>