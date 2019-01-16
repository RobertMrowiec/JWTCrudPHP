<?php
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Origin: *");

    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') die ('Wrong method');

    include_once '../../config/database.php';
    include_once '../../classes/news.php';
    include '../login/verifyToken.php';

    if (verifyToken()) {
        $database = new Database();
        $db = $database->getConnection(); 

        $news = new News($db);

        if ($news->delete($_GET['id'])) echo json_encode(['message' => 'News deleted succesfully']);
        else echo json_encode(['message' => 'Unable to delete news']);
    } else {
        echo json_encode(['message' => 'Wrong token']);
    }
?>