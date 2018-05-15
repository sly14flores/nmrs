<?php

$_POST = json_decode(file_get_contents('php://input'), true);

require_once '../db.php';

$con = new pdo_db();

$profiles = $con->getData("SELECT * FROM reg_jobseekers");

echo json_encode($profiles);

?>