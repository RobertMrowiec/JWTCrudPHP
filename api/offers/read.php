<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') die ('Wrong method');

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../../config/database.php';
    include_once '../../classes/offers.php';
    include '../login/verifyToken.php';

    if (verifyToken()) {
        $database = new Database();
        $db = $database->getConnection();

        $offers = new Offer($db);
        $stmt = $offers->get();
        $num = $stmt->rowCount();
        $offers_arr=array();

        if ($num > 0){
            while ($row = $stmt->fetch()){
                extract($row);

                $offers_item=array(
                    "id_item" => $id_item,
                    "category" => $category,
                    "title" => $title,
                    "photo" => $photo,
                    "description" => $description
                );

                array_push($offers_arr, $offers_item);
            }

            http_response_code(200);

            echo json_encode($offers_arr);
        } else echo json_encode(['message' => 'Offers not found']);
    } else {
        echo json_encode(['message' => 'Wrong token']);
    } 

?>