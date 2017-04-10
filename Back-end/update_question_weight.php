<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['test_question_id']) || !isset($_POST['weight']))
{
	error("Missing Parameters");
}

$test_question_id = (int) $_POST['test_question_id'];
$weight = (double) $_POST['weight'];

Question::updateQuestionWeight($test_question_id, $weight);
echo json_encode(true);
