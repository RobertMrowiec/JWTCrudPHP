<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') die ('Wrong method');

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Origin: *");

    include_once '../../config/database.php';
    include_once '../../classes/news.php';
    include '../login/verifyToken.php';

    if (verifyToken()) {
        $database = new Database();
        $db = $database->getConnection();

        $news = new News($db);

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        if ($news->post($data)) echo json_encode(['message' => 'News was created']);
        else echo json_encode(['message' => 'Unable to create news']);
    } else {
        echo json_encode(['message' => 'Wrong token']);
    }
?>