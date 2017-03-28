<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['test_id']) || !isset($_POST['question_id'])) {
	error("Missing Parameters");
}

$test_id = (int) $_POST['test_id'];
$question_id = (int) $_POST['question_id'];

Test::addQuestionToTest($test_id, $question_id);
echo json_encode(true);
