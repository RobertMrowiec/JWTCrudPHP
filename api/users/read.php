<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../../config/database.php';
    include_once '../../models/users.php';

    $database = new Database();
    $db = $database->getConnection();
    
    $user = new User($db);
    $stmt = $user->get();
    $num = $stmt->rowCount();
    $users_arr=array();

    # Get JSON as a string
    $json_str = file_get_contents('php://input');

    # Get as an object
    $json_obj = json_decode($json_str); //working

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