<?php
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Origin: *");

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') die ('Wrong method');

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