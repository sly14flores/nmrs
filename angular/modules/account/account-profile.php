<?php

require_once '../../../db.php';

session_start();

if (!isset($_SESSION['id'])) header('X-Error-Message: Session timeout', true, 500);

$con = new pdo_db("accounts");

$account = $con->get(["id"=>$_SESSION['id']],["CONCAT(first_name, ' ', last_name) fullname"]);

$avatar = "angular/modules/account/avatar.png";

$profile = array(
	"fullname"=>$account[0]['fullname'],
	"picture"=>$avatar,
	"group"=>"Administrator",
);

echo json_encode($profile);

?>