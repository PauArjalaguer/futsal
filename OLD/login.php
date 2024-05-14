<?
include("init.php");
if (isset($_POST['loginSubmit'])) {
    include ("includes/test/db.inc");
    include("Classes/Users_class.php");
    $users = new Users;
    $users->login = trim($_POST['login']);
    $users->pass = trim($_POST['password']);
    //echo "remember: ".$_POST['remember'];
    $data = $users->getLogin();
    $num = count($data);
    if ($num > 0) {
        foreach ($data as $user) {

            setcookie("userId", $user[0], time() + (3600 ), "/");
            setcookie("userName", $user[2], time() + (3600), "/");
            setcookie("userEmail", $user[3], time() + (3600), "/");
            setcookie("idClub", $user[4], time() + (3600), "/");
            setcookie("userImage", $user[5], time() + (3600), "/");
            setcookie("idReferee", $user[7], time() + (3600), "/");
            //echo $user[6];

            header("Location: " . $user[6]);
        }
    } else {
        //header("Location: usuari/login");
        echo "<script type='text/javascript'>alert(\"Nom d' usuari o contrassenya incorrectes.\");  window.location=\"http://www.futsal.cat\"; </script>";

    }
}
?>