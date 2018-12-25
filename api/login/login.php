<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') die ('Wrong method');

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Origin: *");
    
    include_once '../../config/database.php';
    include_once '../../classes/login.php';

    $database = new Database();
    $db = $database->getConnection(); 

    $login = new Login($db);
    
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $res = $login->login($data);
    if (!$res['status']) {
        http_response_code(400);
        echo json_encode(array('error' => 'Wrong credentials'));
    } else {
        $result = array(
            'message' => 'Logged succesfully',
            'token' => $res['token']

        );
        http_response_code(200);
        echo json_encode($result);
    }

?>