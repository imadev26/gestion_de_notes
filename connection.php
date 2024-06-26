<?php

class Connection {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    public $cnx;

    public function __construct() {
        $this->cnx = new mysqli($this->servername, $this->username, $this->password);

        // Check connection
        if ($this->cnx->connect_errno) {
            die("Connection failed: " . $this->cnx->connect_error);
        }
    }

    function createDatabase($dbName) {
        $query = "CREATE DATABASE IF NOT EXISTS $dbName";
        if (!$this->cnx->query($query)) {
            echo "Database not created: " . $this->cnx->error;
        } else {
            echo "Database has been created";
        }
    }

    function selectDatabase($dbName) {
        if (!$this->cnx->select_db($dbName)) {
            echo "Failed to select database: " . $this->cnx->error;
        }
    }

    function createTable($query) {
        if (!$this->cnx->query($query)) {
            echo "The table not created: " . $this->cnx->error;
        } else {
            echo "The table has been created";
        }
    }

    public function getMysqli() {
        return $this->cnx;
    }
}

?>
