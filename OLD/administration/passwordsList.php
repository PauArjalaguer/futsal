<table cellpadding="3" cellspacing="0"><tr><th>Nom</th><th>Login</th><th>Password</th></tr><?php

?>
<?php

//echo $_GET['idTeam'];
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar ();
$a=1;
$res=mysql_query("select a.name, login ,password, c.name as club from usersAccounts a join clubs c on c.id=a.idclub where idrole=1 order by a.name") or die(mysql_error());
while($row=mysql_fetch_array($res)){
    if($n==1){
        $n=2;
    }else{
        $n=1;
    }
    if($n==1){
        $style=" style='background-color:#eee; border-top:1px solid; font-family:verdana;'";
    }else{
        $style=" style='background-color:#fff; border-top:1px solid; font-family:verdana; '";
    }
    echo "<tr><td $style>$a</td><td $style>".$row['name']."</td><td  $style>".$row['login']."</td><td $style>".$row['password']."</td></tr>";
$a++;

}
?>
</table>
