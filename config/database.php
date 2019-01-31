<?php

    class Database {

        private $host = "semar.pl"; //localhost
        private $db_name = "14579249_0000001"; //firstCrud
        private $username = "14579249_0000001"; //root
        private $password = "#j9S.sD51wXA"; //root
        public $connection;

        // get the database connection
        public function getConnection(){
            try {
                $this->connection = new PDO("mysql:host=".$this->host.";port=3306;dbname=".$this->db_name, $this->username, $this->password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->exec("set names utf8");

            } catch(PDOExpection $exception) {
                echo 123;
                return;
                print_r($exception->getMessage());
                echo "Connection error: ".$this->exception->getMessage();
            }
            return $this->connection;
        }
    }

?>