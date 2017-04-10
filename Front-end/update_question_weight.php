<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['test_question_id'])) {
	error("Missing Parameter: test_question_id.");
}

if (!isset($_POST['weight'])) {
	error("Missing Parameter: weight.");
}

$test_question_id = (int) $_POST['test_question_id'];
$weight = (double) $_POST['weight'];

$resp = http(MIDDLE_END, "update_question_weight", [
	'test_question_id' => $test_question_id,
	'weight'           => $weight,
]);

if ($resp === false) {
	error("cURL request failed");
}

echo json_encode(true);
