<?php

# Maurice Achtenhagen

require_once('../functions.php');

session_start();
assertPost();

$test_id = (int) $_POST['test_id'];
$question_id = (int) $_POST['question_id'];

Test::removeQuestionFromTest($test_id, $question_id);
