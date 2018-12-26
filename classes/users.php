<?php

    class User {
        private $connection;

        public function __construct($db){
            $this->connection = $db;
        }

        public function get() {
            $query = "select * from users";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function getById($id) {
            $query = 'select * from users where id = '.$id;
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function post($body) {
            if (
                !$body['email'] || 
                !$body['password']
            ) die(json_encode(['message' => 'Wrong data']));
            
            $checkQuery = 'select * from users where email = "'.$body['email'].'"';
            $this->checkRecordExists($checkQuery, 'User with specific email already exists');

            $query = 'insert into users (email, password) values ("'.$body['email'].'", "'.$body['password'].'");';
            $stmt = $this->connection->prepare($query);
            $stmt->execute(); 
            return $stmt;
        }

        public function update($id, $password) {
            if (!$password || !$id) die (json_encode(['message' => 'Wrong data']));
            $query = ' update users SET password = "'.$password.'" WHERE id = '.$id;
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
            if ($num > 0) echo json_encode($response);
        }

        function checkRecordNotExists($query, $response) {
            $checkStmt = $this->connection->prepare($query);
            $checkStmt->execute(); 
            $num = $checkStmt->rowCount();
            if ($num == 0) die (json_encode(['message' => $response]));
        }
    }

?>