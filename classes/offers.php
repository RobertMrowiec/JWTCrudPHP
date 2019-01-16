<?php

    class Offer {
        private $connection;

        public function __construct($db){
            $this->connection = $db;
        }

        public function get() {
            $query = "select * from offers";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function getById($id) {
            $query = 'select * from offers where id = '.$id;
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function post($body, $files) {
            include '../uploadFunction.php';
            $filename = json_decode(uploadFile($files, 'photo'),true)['filename'];

            if (
                !$body['category'] || 
                !$body['title'] && 
                !$filename
            ) die(json_encode(['message' => 'Wrong data']));

            if ($filename){
                $query = 'insert into offers (photo,';
                $endQuery .= ' values ("'.$filename.'", ';
            } else {
                $query = 'insert into offers (';
                $endQuery .= ' values (';
            }
            while ($value = current($body)) {
                $query .= key($body).', ';
                $endQuery.= '"'.$body[key($body)].'", ';
                next($body);
            };
            $query .= ')';
            $endQuery .= ')';
            $query = str_replace(", )", ")", $query);
            $endQuery = str_replace(", )", ")", $endQuery);
            $resultQuery = $query.$endQuery;
            $stmt = $this->connection->prepare($resultQuery);
            $stmt->execute();
            return $stmt;
        }

        public function update($id, $body, $files) {
            include '../uploadFunction.php';

            $filename = json_decode(uploadFile($files, 'photo'),true)['filename'];
            print_r($body);
            if (
                !$body['category'] || 
                !$body['title'] ||
                ($files['photo'] && !$filename)
            ) die(json_encode(['message' => 'Wrong data']));

            $query = 'update offers SET ';
            if ($filename) $query .= 'photo = "'.$filename.'", ';
            $endQuery .= ' WHERE Id_item = '.$id;
            while ($value = current($body)) {
                $query .= key($body).'='.'"'.$body[key($body)].'", ';
                next($body);
            };
            $resultQuery = $query.$endQuery;
            $resultQuery = str_replace(",  ", " ", $resultQuery);
            $stmt = $this->connection->prepare($resultQuery);
            $stmt->execute();
            return $stmt;
        }

        public function delete($id) {
            $checkQuery = 'select * from offers where Id_item = '.$id.'';
            $this->checkRecordNotExists($checkQuery, "Specific offers doesn't exists");
            $query = 'delete from offers where Id_item = '.$id;
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        function checkRecordNotExists($query, $response) {
            $checkStmt = $this->connection->prepare($query);
            $checkStmt->execute(); 
            $num = $checkStmt->rowCount();
            if ($num == 0) die (json_encode(['message' => $response]));
        }
    }

?>