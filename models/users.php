<?php

    class User {
        private $connection;
        private $table_name = "users";

        public function __construct($db){
            $this->connection = $db;
        }

        public function get() {
            $query = "select * from users";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function post($body) {
            if (
                !$body['name'] || 
                !$body['surname'] || 
                !$body['email'] || 
                !$body['password']
            ) die('Wrong data');
            
            $query = 'insert into users (name, surname, email, password) values ("'.$body['name'].'", "'.$body['surname'].'", "'.$body['email'].'", "'.$body['password'].'");';
            // echo $query;
            $stmt = $this->connection->prepare($query);
            $stmt->execute(); 
            return $stmt;
        }
    }

?>