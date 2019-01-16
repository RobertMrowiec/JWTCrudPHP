<?php
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Origin: *");
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') die ('Wrong method');

    include_once '../../config/database.php';
    include_once '../../classes/offers.php';
    include '../login/verifyToken.php';

    if (verifyToken()) {
        $database = new Database();
        $db = $database->getConnection();

        $offers = new Offer($db);

        if ($offers->post($_POST, $_FILES)) echo json_encode(['message' => 'Offer was created']);
        else echo json_encode(['message' => 'Unable to create offers']);
    } else {
        echo json_encode(['message' => 'Wrong token']);
    }
?>