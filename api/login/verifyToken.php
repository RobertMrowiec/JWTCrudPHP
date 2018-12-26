<?php

    function verifyToken() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        include_once '../../config/database.php';
        include_once '../../classes/users.php';

        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);

        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'];
        $token = explode(' ', $authHeader)[1];
        $tokenHeader = explode('.', $token)[0];
        $tokenPayload = explode('.', $token)[1];

        function base64url_encode($data) {
            return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
        };

        function base64url_decode($data) { 
            return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
        }
        
        $generateHeaders = ['alg'=>'HS256','typ'=>'JWT'];
        $headers_encoded = base64url_encode(json_encode($generateHeaders));

        $payload_decoded = json_decode(base64url_decode($tokenPayload), true);
        
        $stmt = $user->getById($payload_decoded['id']);
        $num = $stmt->rowCount();

        if ($num) {
            while ($row = $stmt->fetch()){
                extract($row);
                if (
                    $tokenHeader == $headers_encoded && 
                    $row['email'] == $payload_decoded['email'] && 
                    $row['password'] == $payload_decoded['password']
                ) return 1;

                else {
                    http_response_code(400);
                    return 0;
                }
            }
        }
        else {
            http_response_code(400);
            return 0;
        }
}
?>