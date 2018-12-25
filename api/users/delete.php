<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') die ('Wrong method');

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Origin: *");

    include_once '../../config/database.php';
    include_once '../../models/users.php';

    $database = new Database();
    $db = $database->getConnection(); 

    $user = new User($db);

    if ($user->delete($_GET['id'])) {
        echo '{';
            echo '"message": "User deleted succesfully."';
        echo '}';
    } else {
        echo '{';
            echo '"message": "Unable to delete user."';
        echo '}';
    }

?>