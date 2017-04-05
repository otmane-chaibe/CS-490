<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['user_id'])) {
	error("Missing Parameters: user_id.");
}

if (!isset($_POST['test_id'])) {
	error("Missing Parameters: test_id.");
}

if (!isset($_POST['score'])) {
	error("Missing Parameters: score.");
}

$user_id = (int) $_POST['user_id'];
$test_id = (int) $_POST['test_id'];
$score = (int) $_POST['score'];

$score_id = http(BACK_END, "insert_test_score", [
	"user_id" => $user_id,
	"test_id" => $test_id,
	"score"   => $score,
]);

if ($score_id === false) {
	error("cURL request failed.");
}

echo $score_id;
