<?php

date_default_timezone_set('Europe/Madrid');

function teamUrlFormat($str) {

    $str = htmlentities(trim($str));
    $str = stripslashes(strtolower($str));
    $str = str_replace("'", "", $str);
    $str = str_replace("-", "", $str);
    $str = str_replace("(", "", $str);
    $str = str_replace(") ", "", $str);

    $str = str_replace("&agrave;", "a", $str);
    $str = str_replace("&aacute;", "a", $str);
    $str = str_replace("&eacute;", "e", $str);
    $str = str_replace("&egrave;", "e", $str);
    $str = str_replace("&iacute;", "i", $str);
    $str = str_replace("&igrave;", "i", $str);
    $str = str_replace("&oacute;", "o", $str);
    $str = str_replace("&oagrave;", "o", $str);
    $str = str_replace("&uacute;", "u", $str);
    $str = str_replace("&ugrave;", "u", $str);
    $str = str_replace("&ccedil;", "c", $str);
    $str = str_replace("/", "-", $str);
    $str = str_replace(",", "", $str);
    $str = str_replace(".", "", $str);
    $str = str_replace(" ", "-", $str);

    return $str;
}

function invertdateformat($date) {
    if ($date != '0000-00-00 00:00:00' && strlen($date) > 4) {
        $temp = explode(" ", $date);
        $data = $temp[0];

        $d = explode("-", $data);

        $date = $d[2] . "-" . $d[1] . "-" . $d[0];
    } else {
        $date = "";
    }


    return $date;
}

function invertdateformatshort($date) {
    if ($date != '0000-00-00 00:00:00' && strlen($date) > 4) {
        $temp = explode(" ", $date);
        $data = $temp[0];

        $d = explode("-", $data);
        $d[0] = substr($d[0],-2);
        $date = $d[2] . "-" . $d[1] . "-" . $d[0];
    } else {
        $date = "";
    }


    return $date;
}

function hour($date) {
    if ($date != '0000-00-00 00:00:00' && strlen($date) > 4) {
        $temp = explode(" ", $date);
        $hour = $temp[1];
          $hour = substr($hour,0,5);

    } else {
        $hour = "";
    }


    return $hour." h";
}
function calculaedad($date) {
    $date2 = date('Y-m-d'); //
    $diff = abs(strtotime($date2) - strtotime($date));
    $years = floor($diff / (365 * 60 * 60 * 24));
    return $years;
}

function generateRandomString($length = 5) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function create_token($idAccount, $userName,$userEmail){
   
    return md5($idAccount.$userEmail.SECRET_WORD);
}
function create_link($idAccount, $userName,$userEmail,$buttonName,$url){
   // echo $idAccount;
    $token= create_token($idAccount, $userName, $userEmail);
    $link ="<a href='".base_url()."admin/Verifylogin/auto/$token/".$idAccount."/".$url."'>$buttonName</a>";
    return $link;
}

