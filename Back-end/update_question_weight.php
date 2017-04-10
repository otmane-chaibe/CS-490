<?php

# Khurshid SOhail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['test_question_id']) || !isset($_POST['weight']))
{
	error("Missing Parameters");
}

$test_question_id = (int) $_POST['test_question_id'];
$weight = (double) $_POST['weight'];

echo json_encode(Question::updateQuestionWeight($test_questions_id, $weight));
