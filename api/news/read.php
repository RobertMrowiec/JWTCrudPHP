<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') die ('Wrong method');

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../../config/database.php';
    include_once '../../classes/news.php';
    include '../login/verifyToken.php';

    if (verifyToken()) {
        $database = new Database();
        $db = $database->getConnection();
        
        $news = new News($db);
        $stmt = $news->get();
        $num = $stmt->rowCount();
        $news_arr=array();

        if ($num > 0){
            while ($row = $stmt->fetch()){
                extract($row);

                $news_item=array(
                    "id" => $id,
                    "image" => $image,
                    "title" => $title,
                    "content" => $content,
                    "link" => $link,
                    "dateTime" => $dateTime
                );

                array_push($news_arr, $news_item);
            }

            http_response_code(200);

            echo json_encode($news_arr);
        } else echo json_encode(['message' => 'News not found']);
    } else {
        echo json_encode(['message' => 'Wrong token']);
    } 

?>