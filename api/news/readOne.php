<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') die('Wrong method');

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../../config/database.php';
    include_once '../../classes/news.php';
    include '../login/verifyToken.php';

    if (verifyToken()) {
        $database = new Database();
        $db = $database->getConnection();

        $news = new News($db);
        $stmt = $news->getById($_GET['id']);
        $num = $stmt->rowCount();
        $newsItem;
        if ($num) {
            while ($row = $stmt->fetch()){
                extract($row);

                $newsItem = (object) [
                    "id" => $id,
                    "image" => $image,
                    "title" => $title,
                    "content" => $content,
                    "link" => $link,
                    "dateTime" => $dateTime
                ];
            }
            http_response_code(200);

            echo json_encode($newsItem);
        } else echo json_encode(['message' => "News doesn't exists"]);
    } else {
        echo json_encode(['message' => 'Wrong token']);
    } 
?>