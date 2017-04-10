<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['user_id']) || !isset($_POST['test_id']) ||
!isset($_POST['q_id']) || !isset($_POST['solution']) ||
!isset($_POST['results']) || !isset($_POST['score']))
{
	error("Missing Parameters");
}

$user_id=(int) $_POST['user_id'];
$test_id=(int) $_POST['test_id'];
$question_id=(int) $_POST['q_id'];
$solution=$_POST['solution'];
$results=json_decode($_POST['results']);
$score=(int) $_POST['score'];

echo json_encode(Test::insertQuestionSolution($user_id, $test_id, $question_id, $solution, $results, $score));
