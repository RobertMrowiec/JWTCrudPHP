<?php
    class Login {
        private $connection;
        
        public function __construct($db){
            $this->connection = $db;
        }
        
        public function login($data){
            $query = 'select * from users where email = "'.$data['email'].'"';
            $arr;

            $stmt = $this->connection->prepare($query);
            $stmt->execute();

            $num = $stmt->rowCount();
            if ($num == 0) die('User not exists');

            while ($row = $stmt->fetch()) {
                $arr = (array) [
                    'id' => $row['id'],
                    'email' => $row['email'],
                    'password' => $row['password'],
                ];
            };
                
            if(password_verify($data['password'], $arr['password'])) {
                //GENERATE TOKEN

                function base64url_encode($data) {
                    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
                };
                
                //build the headers
                $headers = ['alg'=>'HS256','typ'=>'JWT'];
                $headers_encoded = base64url_encode(json_encode($headers));

                // //build the payload
                $payload_encoded = base64url_encode(json_encode($arr));

                // //build the signature
                $key = 'secret';
                $signature = hash_hmac('SHA256',"$headers_encoded.$payload_encoded",$key,true);
                $signature_encoded = base64url_encode($signature);
                
                // //build and return the token
                $token = "$headers_encoded.$payload_encoded.$signature_encoded";
                return array(
                    'token' => $token,
                    'status' => true
                );
            } else {
                return array(
                    'token' => null,
                    'status' => false
                );
            }
        }
    }
?>