<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (empty($_POST['ucid']) || empty($_POST['pass'])) {
	error("Bad Request");
}

$ucid = $_POST['ucid'];
$pass = $_POST['pass'];

if (strlen($ucid) > 6 || strlen($pass) > 20) {
	error("Bad Request");
}

$cred = http(BACK_END, "login", [
	"ucid" => $ucid,
	"pass" => $pass,
]);

if ($cred === false) {
	error("cURL request failed");
}

echo $cred;
