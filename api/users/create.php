<?php
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Origin: *");

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') die ('Wrong method');

    include_once '../../config/database.php';
    include_once '../../classes/users.php';
    include '../login/verifyToken.php';

    if (verifyToken()) {
        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        $pass = $data['password'];
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if ($user->post($data)) echo json_encode(['message' => 'User was created']);
        else echo json_encode(['message' => 'Unable to create user']);
    } else {
        echo json_encode(['message' => 'Wrong token']);
    }
?>