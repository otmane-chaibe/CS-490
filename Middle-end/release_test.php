<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['test_id'])) {
	error("Missing Parameter: test_id.");
}

$test_id = (int) $_POST['test_id'];

$resp = http(BACK_END, "release_test", [
	'test_id' => $test_id
]);

if ($resp === false) {
	error("cURL request failed.");
}

echo json_encode(true);
