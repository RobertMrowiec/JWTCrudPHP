<?php

    class News {
        private $connection;

        public function __construct($db){
            $this->connection = $db;
        }

        public function get() {
            $query = "select * from news";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function getById($id) {
            $query = 'select * from news where id = '.$id;
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function post($body, $files) {
            include '../uploadFunction.php';
            $filename = json_decode(uploadFile($files, 'image'),true)['filename'];
            print_r($files);

            if (!count($body) && !$filename) die(json_encode(['message' => 'Wrong data']));
            if ($filename){
                $query = 'insert into news (image, ';
                $endQuery .= ' values ("'.$filename.'", ';
            } else {
                $query = 'insert into news (';
                $endQuery .= ' values (';
            }
            while ($value = current($body)) {
                $query .= key($body).', ';
                $endQuery.= '"'.$body[key($body)].'", ';
                next($body);
            };
            $query .= 'dateTime';
            $endQuery.= '"'.date("Y-m-d H:i:s").'", ';
            $query .= ')';
            $endQuery .= ')';
            $query = str_replace(", )", ")", $query);
            $endQuery = str_replace(", )", ")", $endQuery);
            $resultQuery = $query.$endQuery;
            echo $resultQuery;
            $stmt = $this->connection->prepare($resultQuery);
            $stmt->execute();
            return $stmt;
        }

        public function update($id, $body, $files) {
            include '../uploadFunction.php';

            $filename = json_decode(uploadFile($files, 'image'),true)['filename'];

            if (!count($body) && !$filename) die(json_encode(['message' => 'Wrong data']));

            $query = 'update news SET ';
            if ($filename) $query .= 'image = "'.$filename.'",';

            $endQuery .= ' WHERE id = '.$id;
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
            $checkQuery = 'select * from news where id = '.$id.'';
            $this->checkRecordNotExists($checkQuery, "Specific news doesn't exists");
            $query = 'delete from news where id = '.$id;
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