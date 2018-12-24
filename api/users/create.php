<?php

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Origin: *");

    include_once '../../config/database.php';
    include_once '../../models/users.php';

    $database = new Database();
    $db = $database->getConnection(); 

    $user = new User($db);

    # Get JSON as a string
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    // $user->post($data);
    if ($user->post($data)) {
        echo '{';
            echo '"message": "User was created."';
        echo '}';
    }
    else {
        echo '{';
            echo '"message": "Unable to create user."';
        echo '}';
    }

?>