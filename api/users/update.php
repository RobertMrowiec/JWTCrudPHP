<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') die ('Wrong method');

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Allow-Origin: *");

    include_once '../../config/database.php';
    include_once '../../classes/users.php';
    include '../login/verifyToken.php';

    if (verifyToken()) {
        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        $password = $data['password'];
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        if ($user->update($_GET['id'], $data['password'])) echo json_encode(['message' => 'User password changed']);
        else echo json_encode(['message' => 'Unable to edit user']);
    } else {
        echo json_encode(['message' => 'Wrong token']);
    }
?>