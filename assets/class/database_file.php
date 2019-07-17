<?php

class database {

    public $servername;
    public $username;
    public $password;
    public $dbname;

    public function __construct() {
        global $conn;
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "phpform";
    }

    public function connection() {
        $conn = mysqli_connect("localhost", "root", "", "phpform");
        if (!($conn)) {
            echo "Database is not connected";
            exit;
        } else {
            return $conn;
        }
    }

}

?>