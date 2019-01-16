<?php
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Origin: *");

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') die ('Wrong method');

    include_once '../../config/database.php';
    include_once '../../classes/users.php';
    include '../login/verifyToken.php';

    if (verifyToken()) {
        $database = new Database();
        $db = $database->getConnection();
        
        $user = new User($db);
        $stmt = $user->get();
        $num = $stmt->rowCount();
        $users_arr=array();

        if ($num > 0){
            while ($row = $stmt->fetch()){
                extract($row);

                $user_item=array(
                    "id" => $id,
                    "email" => $email,
                    "password" => $password,
                );

                array_push($users_arr, $user_item);
            }

            http_response_code(200);

            echo json_encode($users_arr);
        } else echo json_encode(['message' => 'Users not found']);
    } else {
        echo json_encode(['message' => 'Wrong token']);
    } 

?>