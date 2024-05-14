<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Arbitres</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="<table class='playersTable' cellspacing=0><tr><th width=20>&nbsp;</th><th width=350>Arbitre</th><th>Provincia</th><th width=10% colspan=2>Accio</th></tr>";
$sql = "select
        distinct id
        , name
        , province
       
        from rfrReferees where isDeleted=0
order by name, province";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    $out .="<tr>";
    $out .="<td class='zebra$n'>" . $row['rouand'] . "</td>";
    $out .="<td class='zebra$n'>" . $row['name'] . "</td>";
    $out .="<td class='zebra$n' align=center>" . $row['province'] . "</td>";
    $out .="<td class='zebra$n pointer'  align=center onClick='rfrRefereeEdit(" . $row['id'] . ");'>Editar</td><td class='zebra$n pointer' onClick='rfrRefereeResendAccount(".$row['id'].");'>Reenviar pass</td>";
    $out .="</tr>";
}
$out .="</table>";
$out .="</div></div>";

$out .="<div class='contentBoxSpacer'></div>";


$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Nou arbitre</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="<input type='text' class='newPlayerNameInput' id='rfrRefereeName'>";
$out .="&nbsp;<input type='button' onClick='rfrRefereeInsert();' class='newPlayerNameButton' id='newPlayerNameButton' value='Guardar' />";

$out .="</div>";
$out .="</div>";
echo utf8_encode($out);
?>
