<?
if ($_GET["action"] == "upload") {
    include ("../../includes/config.php");
    include ("../../includes/funciones.php");
    $cnx = conectar();

    $archivo = $_FILES["Filedata"]['name'];


    $prefijo = substr(md5(uniqid(rand())), 0, 6);
    $destino = "../../newsImages/$prefijo.jpg";
  copy_file($_FILES['Filedata']['tmp_name'], $destino);
    $s = getimagesize($destino);
    if ($s[0] >= 600) {
        $ratio = $s[0] / 600;
        $h = $s[1] / $ratio;
        if (eregi("jpg", $destino)) {
            redimensionar_jpeg("../../newsImages/" . $prefijo . ".jpg", "../../newsImages/" . $prefijo . ".jpg", 600, $h, 100);
        }
    }
    if (eregi("jpg", $_FILES['Filedata']['name'])) {
        redimensionar_jpeg("../../newsImages/" . $prefijo . ".jpg", "../../newsImages/thumbs/" . $prefijo . ".jpg", 240, 120, 100);
    }

    mysql_query("INSERT	INTO newsimages (imagepath,inserted) values ('" . $prefijo . ".jpg',now())");
}
?>