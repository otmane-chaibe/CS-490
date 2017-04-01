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

if (!isset($_POST['score'])) {
	error("Missing Parameters: score.");
}

$remark = "";
if (isset($_POST['remark'])) {
	$remark = $_POST['remark'];
}

$user_id = (int) $_POST['user_id'];
$test_id = (int) $_POST['test_id'];
$question_id = (int) $_POST['question_id'];
$solution = $_POST['solution'];
$score = $_POST['score'];
