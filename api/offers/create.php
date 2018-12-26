<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') die ('Wrong method');

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Origin: *");

    include_once '../../config/database.php';
    include_once '../../classes/offers.php';
    include '../login/verifyToken.php';

    if (verifyToken()) {
        $database = new Database();
        $db = $database->getConnection();

        $offers = new Offer($db);

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        if ($offers->post($data)) echo json_encode(['message' => 'Offer was created']);
        else echo json_encode(['message' => 'Unable to create offers']);
    } else {
        echo json_encode(['message' => 'Wrong token']);
    }
?>