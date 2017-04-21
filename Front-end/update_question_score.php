<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['id'])) {
	error("Missing Parameter: id.");
}

if (!isset($_POST['test_id'])) {
	error("Missing Parameter: test_id.");
}

if (!isset($_POST['score'])) {
	error("Missing Parameter: score.");
}

$id = (int) $_POST['id'];
$score = (int) $_POST['score'];
$test_id = (int) $_POST['test_id'];

$resp = http(MIDDLE_END, "update_question_score", [
	'id'      => $id,
	'test_id' => $test_id,
	'score'   => $score,
]);

if ($resp === false) {
	error("cURL request failed.");
}

echo json_encode(true);
