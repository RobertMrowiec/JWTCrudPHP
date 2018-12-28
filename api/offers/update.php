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

        if ($offers->update($_GET['id'], $_POST, $_FILES)) echo json_encode(['message' => 'Offer data changed']);
        else echo json_encode(['message' => 'Unable to edit offers']);
    } else {
        echo json_encode(['message' => 'Wrong token']);
    }
?>