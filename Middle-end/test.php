<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['test_id'])) {
	error("Test id cannot be empty");
}

$test_id = (int) $_POST['test_id'];

$resp = http(BACK_END, "test", [
	"test_id" => $test_id
]);

if ($resp === false) {
	error("cURL request failed");
}

echo $resp;
