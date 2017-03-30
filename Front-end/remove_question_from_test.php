<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['test_id'])) {
	error("Missing Parameter: test_id.");
}

if (!isset($_POST['question_id'])) {
	error("Missing Parameter: question_id.");
}

$test_id = (int) $_POST['test_id'];
$question_id = (int) $_POST['question_id'];

$resp = http(MIDDLE_END, "remove_question_from_test", [
	"test_id"     => $test_id,
	"question_id" => $question_id,
]);

if ($resp === false) {
	error("cURL request failed");
}

echo json_encode(true);
