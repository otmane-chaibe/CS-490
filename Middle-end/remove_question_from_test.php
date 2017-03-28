<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

$test_id = (int) $_POST['test_id'];
$question_id = (int) $_POST['question_id'];

$resp = http(BACK_END, "remove_question_from_test.php", [
	"test_id"     => $test_id,
	"question_id" => $question_id,
]);

if ($resp === false) {
	error("cURL request failed");
}

echo json_encode(true);
