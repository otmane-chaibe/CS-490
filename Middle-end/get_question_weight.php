<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['test_id'])) {
	error("Missing Parameter: test_id.");
}

if (!isset($_POST['q_id'])) {
	error("Missing Parameter: q_id.");
}

$test_id = (int) $_POST['test_id'];
$q_id = (int) $_POST['q_id'];

$weight = http(BACK_END, "get_question_weight", [
	'test_id' => $test_id,
	'q_id'    => $q_id,
]);

if ($weight === false) {
	error("cURL request failed.");
}

echo $weight;
