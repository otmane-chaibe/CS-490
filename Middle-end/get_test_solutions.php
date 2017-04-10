<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['test_id'])) {
	error("Missing Parameter: test_id.");
}

$test_id = (int) $_POST['test_id'];

$test_results = http(BACK_END, "get_test_solutions", [
	'test_id' => $test_id
]);

if ($test_results === false) {
	error("cURL request failed.");
}

echo $test_results;
