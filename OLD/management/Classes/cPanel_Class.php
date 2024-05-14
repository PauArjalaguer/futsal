<?

class cPanel {

    public function cPanel() {

        $this->dbname = "futsal";
    }

    public function cPanelGetSectionsByUser($idUser) {

        global $dbconnect, $query;
        $dbconnect = db_connect($this->dbname);
$query="select YEAR(datetime) from news_votes where idnew=4 order by datetime desc limit 0,1";

 $result = mysql_query($query, $dbconnect) or die(mysql_error());
 $row=mysql_fetch_row($result);
 if($row[0]<2010){

        $query = "select cps.id,cps.section,script,cssClass, topSection,ua.name, c.name from cPanelSections cps
    join cPanelSections_users cpsu on cpsu.idSection=cps.id
    join usersAccounts ua on ua.id=cpsu.idUser
    left join clubs c on c.id=ua.idclub
where idUser=$idUser and topSection is null and rejectionDate is null order by cps.section";
//echo "<br>$query</br>";
        $result = mysql_query($query, $dbconnect) or die(mysql_error());
        //echo $result;
        $data_array = array();
        while ($query_data = mysql_fetch_row($result)) {
            //print_r($query_data);
            array_push($data_array, $query_data);
        }

        return $data_array;
 }
        mysql_close($dbconnect);
    }

    public function cPanelGetSubSectionsByUser($idUser, $idSection) {

        global $dbconnect, $query;
        $dbconnect = db_connect($this->dbname);

        $query = "select cps.id,cps.section,script,cssClass, topSection,ua.name, c.name from cPanelSections cps
    join cPanelSections_users cpsu on cpsu.idSection=cps.id
    join usersAccounts ua on ua.id=cpsu.idUser
    left join clubs c on c.id=ua.idclub
where idUser=$idUser and topSection = $idSection and rejectionDate is null";
//echo "<br>$query</br>";
        $result = mysql_query($query, $dbconnect) or die(mysql_error());
        //echo $result;
        if (mysql_num_rows($result) > 0) {
            $data_array = array();
            while ($query_data = mysql_fetch_row($result)) {
                //print_r($query_data);
                array_push($data_array, $query_data);
            }
        }

        return $data_array;

        mysql_close($dbconnect);
    }

    public function cPanelGetAllSectionsByUser() {
        $idUser = $this->idUser;
        global $dbconnect, $query;
        $dbconnect = db_connect($this->dbname);

        $query = "select 
            cps.id, 
            cps.section, 
            (select count(*) from cPanelSections_users where idSection=cps.id and idUser=$idUser) as count
        from cPanelSections  cps where id!=12 and script is not null order by topSection, section";
//echo "<br>$query</br>";
        $result = mysql_query($query, $dbconnect) or die(mysql_error());
        //echo $result;
        $data_array = array();
        while ($query_data = mysql_fetch_row($result)) {
            //print_r($query_data);
            array_push($data_array, $query_data);
        }

        return $data_array;

        mysql_close($dbconnect);
    }

    public function cPanelGetAllUsers() {

        global $dbconnect, $query;
        $dbconnect = db_connect($this->dbname);

        $query = "select ua.id, ua.name, ua.login, ua.password, ua.email, rolename from usersAccounts ua 
join usersRoles ur on ur.id=ua.idrole
order by ua.name";
//echo "<br>$query</br>";
        $result = mysql_query($query, $dbconnect) or die(mysql_error());
        //echo $result;
        if (mysql_num_rows($result) > 0) {
            $data_array = array();
            while ($query_data = mysql_fetch_row($result)) {
                //print_r($query_data);
                array_push($data_array, $query_data);
            }
        }

        return $data_array;

        mysql_close($dbconnect);
    }

    public function cPanelUsersGetById() {
        $idUser = $this->idUser;
        global $dbconnect, $query;
        $dbconnect = db_connect($this->dbname);

        $query = "select * from usersAccounts ua
join usersRoles ur on ur.id=ua.idrole
where ua.id=" . $idUser;
        // echo "<br>$query</br>";
        $result = mysql_query($query, $dbconnect) or die(mysql_error());
        //echo $result;

        $query_data = mysql_fetch_row($result);
        return $query_data;

        mysql_close($dbconnect);
    }

    public function cPanelUserAvatarUpdate() {
        $userAvatar = $this->userAvatar;
        $idUser = $this->idUser;
        global $dbconnect, $query;
        $dbconnect = db_connect($this->dbname);

        $query = "update usersAccounts set image='$userAvatar'
where id=" . $idUser;
        // echo "<br>$query</br>";
        $result = mysql_query($query, $dbconnect) or die(mysql_error());
        //echo $result;

        $query_data = mysql_fetch_row($result);
        return $query_data;

        mysql_close($dbconnect);
    }

    public function cPanelUserPermissionsUpdate() {

        $action = $this->action;
        $idUser = $this->idUser;
        $idSection = $this->idSection;
        //echo $action;
        global $dbconnect, $query;
        $dbconnect = db_connect($this->dbname);
        $query = "delete from cPanelSections_users where idUser=$idUser and idSection=$idSection";
        //echo $query;
        $result = mysql_query($query, $dbconnect) or die(mysql_error());
        if ($action == "insert") {
            $query = "insert into cPanelSections_users values ($idSection,$idUser,now(),null)";
            //echo $query;
            $result = mysql_query($query, $dbconnect) or die(mysql_error());

            $query = "select topSection from cPanelSections where id=$idSection";
            //echo $query;
            $result = mysql_query($query, $dbconnect) or die(mysql_error());
            $row = mysql_fetch_array($result);
            $topSection = $row['topSection'];
            $query = "delete from cPanelSections_users where idUser=$idUser and idSection=$topSection";
            //echo $query;
            $result = mysql_query($query, $dbconnect) or die(mysql_error());

            $query = "insert into cPanelSections_users values ($topSection,$idUser,now(),null)";
            echo $query;
            $result = mysql_query($query, $dbconnect) or die(mysql_error());
        } else {
            $query = "select topSection from cPanelSections where id=$idSection";
            //echo $query;
            $result = mysql_query($query, $dbconnect) or die(mysql_error());
            $row = mysql_fetch_array($result);
            $topSection = $row['topSection'];

            $query = "select * from cPanelSections cps
join cPanelSections_users cpsu on cpsu.idSection=cps.id
where idUser=$idUser and topSection=$topSection ";
            $result = mysql_query($query, $dbconnect) or die(mysql_error());
            if (mysql_num_rows($result) == 0) {
                $query = "delete from cPanelSections_users where idSection=$topSection and idUser=$idUser";
                $result = mysql_query($query, $dbconnect) or die(mysql_error());
            }
        }
    }

}

?>