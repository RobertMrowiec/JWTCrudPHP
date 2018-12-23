<?php

    class User {
        private $connection;
        private $table_name = "users";

        // public $id;
        // public $email;
        // public $name;
        // public $password;
        // public $surname;

        public function __construct($db){
            $this->connection = $db;
        }

        public function read() {
            $query = "select * from users";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    }

?>