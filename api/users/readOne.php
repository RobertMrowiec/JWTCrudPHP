<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') die('Wrong method');

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../../config/database.php';
    include_once '../../classes/users.php';
    include '../login/verifyToken.php';

    if (verifyToken()) {
        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);
        $stmt = $user->getById($_GET['id']);
        $num = $stmt->rowCount();
        $userItem;
        if ($num) {
            while ($row = $stmt->fetch()){
                extract($row);

                $userItem = (object) [
                    'id' => $id,
                    'email' => $email,
                    'password' => $password,
                ];
            }
            http_response_code(200);

            echo json_encode($userItem);
        } else echo json_encode(['message' => "User doesn't exists"]);
    } else {
        echo json_encode(['message' => 'Wrong token']);
    } 
?>