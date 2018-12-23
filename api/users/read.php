<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../../config/database.php';
    include_once '../../models/users.php';

    $database = new Database();
    $db = $database->getConnection();
    
    $user = new User($db);
    $stmt = $user->read();
    $num = $stmt->rowCount();
    $users_arr=array();
    if ($num > 0){
        
        while ($row = $stmt->fetch()){
            extract($row);

            $user_item=array(
                "id" => $id,
                "name" => $name,
            );

            array_push($users_arr, $user_item);
        }

        http_response_code(200);

        echo json_encode($users_arr);
    }
?>