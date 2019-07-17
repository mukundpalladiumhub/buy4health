<?php

include_once 'database_file.php';

class tables extends database {

    public $dbConn;

    public function __construct() {
        $this->dbConn = $this->connection();
    }

    public function insert($user) {
        $sql = "INSERT INTO sign_up(s_name,s_mobile,s_gender,s_city,s_state,s_country,s_img)
                VALUES('" . $user['name'] . "','" . $user['num'] . "','" . $user['gen'] . "','" . $user['city'] . "','" . $user['state'] . "','" . $user['cou'] . "','" . $user['img'] . "')";
        $result = mysqli_query($this->dbConn, $sql);
        return $result;
    }

    public function update($user, $id) {
        $sql = "UPDATE sign_up SET s_name='" . $user['name'] . "', s_mobile='" . $user['num'] . "',s_gender='" . $user['gen'] . "',s_city='" . $user['city'] . "',s_state='" . $user['state'] . "',s_country='" . $user['cou'] . "',s_img='" . $data['img'] . "' WHERE s_id = $id";
        $result = mysqli_query($this->dbConn, $sql);
        return $result;
    }

    public function delete($id) {
        $sql = "DELETE FROM sign_up WHERE s_id = $id";
        $result = mysqli_query($this->dbConn, $sql);
        return $result;
    }

    public function table($abc = '') {
        if ($abc == '') {
            $sql = "SELECT * FROM sign_up";
            $result = mysqli_query($this->dbConn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $user_data[] = $row;
            }
            return $user_data;
        } else {
            $sql = "SELECT * FROM sign_up WHERE s_name LIKE '$abc%' or s_mobile LIKE '$abc%' or s_gender LIKE '$abc%' or s_city LIKE '$abc%' or s_state LIKE '$abc%' or s_country LIKE '$abc%'";
            $result = mysqli_query($this->dbConn, $sql);
            return $result;
        }
    }

    public function databyid($id) {
        $sql = "SELECT `s_id`,`s_name`,`s_mobile`,`s_gender`,`s_city`,`s_state`,`s_country` FROM sign_up WHERE s_id=$id";
        $data = mysqli_query($this->dbConn, $sql);
        while ($row = mysqli_fetch_assoc($data)) {
            $user_data = $row;
        }
        return $user_data;
    }

    public function pagein($start_from, $recode_page) {
        $sql = "SELECT * FROM sign_up ORDER BY s_id DESC LIMIT $start_from,$recode_page";
        $result = mysqli_query($this->dbConn, $sql);
        return $result;
    }

    public function pageins() {
        $sql = "SELECT * FROM sign_up ORDER BY s_id DESC";
        $result = mysqli_query($this->dbConn, $sql);
        return $result;
    }

}

?>