<?php

set_time_limit(30000);

require_once "vendor/autoload.php";

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxFile;

$app = new \Kunnu\Dropbox\DropboxApp("cgu6taka6arz95h", "t99yp3bkctpuog6", 'uMwixYYft7oAAAAAAAB7dbjSKrkVatS7uVX6J01wTTqD-l0sBs-ZvyWornqBRxeE');
$dropbox = new Dropbox($app);

$file = $_GET['file'];
// prepare file for upload 
$dropboxFile = new DropboxFile(__DIR__ . "/" . $file);

$dt = (new DateTime())->format("Y-m-d_H-i_s");
try {
    $fileN = $dropbox->upload($dropboxFile, "/backups/" . $file, ['autorename' => false]);
    //  echo $file->getName();
} catch (Exception $e) {
    echo $e;
}

if (file_exists($file)) {
    echo "Existeix " . $file;
    $img = unlink($file);
}
$mensaje = "Copia de seguridad de SQL DE GTURN copiada a DROPBOX";
$mensaje = wordwrap($mensaje, 70, "\r\n");
mail('pau.arjalaguer@gimage.es', 'Copia de seguridad de SQL DE GTURN copiada a DROPBOX. \n Archivo $file', $mensaje);
?>