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
            
            $checkQuery = 'select * from users where email = "'.$body['email'].'"';
            $this->checkRecordExists($checkQuery, 'User with specific email already exists');

            $query = 'insert into users (name, surname, email, password) values ("'.$body['name'].'", "'.$body['surname'].'", "'.$body['email'].'", "'.$body['password'].'");';
            $stmt = $this->connection->prepare($query);
            $stmt->execute(); 
            return $stmt;
        }

        public function delete($id) {
            $checkQuery = 'select * from users where id = '.$id.'';
            $this->checkRecordNotExists($checkQuery, "Specific user doesn't exists");
            $query = 'delete from users where id = '.$id;
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        function checkRecordExists($query, $response) {
            $checkStmt = $this->connection->prepare($query);
            $checkStmt->execute(); 
            $num = $checkStmt->rowCount();
            if ($num > 0) die($response);
        }

        function checkRecordNotExists($query, $response) {
            $checkStmt = $this->connection->prepare($query);
            $checkStmt->execute(); 
            $num = $checkStmt->rowCount();
            if ($num == 0) die($response);
        }
    }

?>