<?php

require_once('../functions.php');

header('Content-Type: application/json');

session_start();
assertPost();

$test_id = (int) $_POST['test_id'];
$question_id = (int) $_POST['question_id'];

Test::addQuestionToTest($test_id, $question_id);
