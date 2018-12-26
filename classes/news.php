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

        public function post($body) {
            if (!count($body)) die(json_encode(['message' => 'Wrong data']));
            
            $query = 'insert into news (';
            $endQuery .= ' values (';
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

        public function update($id, $body) {
            if (!count($body)) die(json_encode(['message' => 'Wrong data']));

            $query = 'update news SET ';
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