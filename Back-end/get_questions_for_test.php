<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

$test_id = (int) $_POST['test_id'];

echo json_encode(Question::getQuestionsForTest($test_id));
