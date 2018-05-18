<?php

$_POST = json_decode(file_get_contents('php://input'), true);

require_once '../db.php';

$con = new pdo_db();

$where = "";

if ( (isset($_POST['year'])) && (isset($_POST['month'])) ) {

	$year = ($_POST['year']=="")?"":$_POST['year'];
	$month = $_POST['month']['month'];

	$year_month = "'%$year-$month-%'";
	if ($month == "-") $year_month = "'$year-%'";

	$where = " WHERE DateRegistered LIKE $year_month";

};

$profiles = $con->getData("SELECT * FROM reg_jobseekers".$where);

foreach ($profiles as $i => $profile) {
	
	$profiles[$i]['DateRegistered'] = date("F j, Y",strtotime($profile['DateRegistered']));
	
};

echo json_encode($profiles);

?>