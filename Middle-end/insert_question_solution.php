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

if (!isset($_POST['q_id'])) {
	error("Missing Parameters: q_id.");
}

if (!isset($_POST['solution'])) {
	error("Missing Parameters: solution.");
}

if (!isset($_POST['results'])) {
	error("Missing Parameters: results.");
}

if (!isset($_POST['score'])) {
	error("Missing Parameters: score.");
}

$user_id = (int) $_POST['user_id'];
$test_id = (int) $_POST['test_id'];
$question_id = (int) $_POST['q_id'];
$solution = $_POST['solution'];
$results = $_POST['results'];
$score = (int) $_POST['score'];

$score_id = http(BACK_END, "insert_question_solution", [
	"user_id"  => $user_id,
	"test_id"  => $test_id,
	"q_id"     => $question_id,
	"solution" => $solution,
	"results"  => $results,
	"score"    => $score,
]);

if ($score_id === false) {
	error("cURL request failed.");
}

echo $score_id;
