<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') die('Wrong method');

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../../config/database.php';
    include_once '../../classes/offers.php';
    include '../login/verifyToken.php';

    if (verifyToken()) {
        $database = new Database();
        $db = $database->getConnection();

        $offers = new Offer($db);
        $stmt = $offers->getById($_GET['id']);
        $num = $stmt->rowCount();
        $offersItem;
        if ($num) {
            while ($row = $stmt->fetch()){
                extract($row);

                $offersItem = (object) [
                    "id" => $id,
                    "image" => $image,
                    "title" => $title,
                    "content" => $content,
                    "link" => $link,
                    "dateTime" => $dateTime
                ];
            }
            http_response_code(200);

            echo json_encode($offersItem);
        } else echo json_encode(['message' => "Offer doesn't exists"]);
    } else {
        echo json_encode(['message' => 'Wrong token']);
    } 
?>