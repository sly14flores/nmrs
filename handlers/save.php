<?php

$_POST = json_decode(file_get_contents('php://input'), true);

require_once '../db.php';

$con = new pdo_db("reg_jobseekers");

$data = $_POST;

$date = date(" H:i:s");
$data['DateRegistered'] = date("Y-m-d",strtotime($data['DateRegistered'])).$date;
if ($data['DateOfBirth'] != null) $data['DateOfBirth'] = date("Y-m-d",strtotime($data['DateOfBirth']));

if ($data['SeekerID']) {
	
	$profile = $con->updateData($data,'SeekerID');
	
} else {
	
	unset($data['SeekerID']);	
	$profile = $con->insertData($data);
	
};

?>