<?php

require_once('../functions.php');

assertPost();

$test_id = (int) $_POST['test_id'];
$question_id = (int) $_POST['question_id'];

Test::addQuestionToTest($test_id, $question_id);
