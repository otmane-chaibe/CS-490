<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (empty($_POST['test_id'])) {
	error('Test id cannot be empty.');
}

$test_id = (int) $_POST['test_id'];

$resp = http(BACK_END, "get_questions_for_test", [
	"test_id" => $test_id,
]);

if ($resp === false) {
	error("cURL request failed");
}

echo $resp;
