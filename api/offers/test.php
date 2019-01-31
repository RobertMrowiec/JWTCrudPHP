<?php

echo 123;

include_once '../../config/database.php';
include_once '../../classes/offers.php';
include '../login/verifyToken.php';

$database = new Database();
print_r($database);
echo 123;
$db = $database->getConnection();

?>