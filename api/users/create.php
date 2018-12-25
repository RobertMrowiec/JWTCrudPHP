<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') die ('Wrong method');

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Origin: *");

    include_once '../../config/database.php';
    include_once '../../models/users.php';

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
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