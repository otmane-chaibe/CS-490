<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['id']) || !isset($_POST['test_id']) || !isset($_POST['score']))
{
	error("Missing Parameters");
}

$id = (int) $_POST['id'];
$test_id = (int) $_POST['test_id'];
$score = (int) $_POST['score'];

Test::updateQuestionScore($id, $test_id, $score);

echo json_encode(true);
