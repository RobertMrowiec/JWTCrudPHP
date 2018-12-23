<?php

    class Database {

        private $host = "localhost";
        private $db_name = "firstCrud";
        private $username = "root";
        private $password = "root";
        public $connection;

        // get the database connection
        public function getConnection(){
            try {
                $this->connection = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username, $this->password);
                $this->connection->exec("set names utf8");
            } catch(PDOExpection $exception) {
                echo "Connection error: ".$this->exception->getMessage();
            }
            return $this->connection;
        }
    }

?>