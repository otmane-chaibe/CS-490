<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if (!isset($_POST['test_id'])) {
	error("Missing Parameter: test_id.");
}

if(!isset($_POST['q_id']))
{
	error("Missing Parameters");
}

$test_id = (int) $_POST['test_id'];
$q_id = (int) $_POST['q_id'];

echo json_encode(Test::getQuestionWeight($test_id, $q_id));
