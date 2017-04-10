<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['user_id']) || !isset($_POST['test_id']))
{
	error("Missing Parameters");
}

$user_id = (int) $_POST['user_id'];
$test_id = (int) $_POST['test_id'];

echo json_encode(Test::getTestSolutions($user_id, $test_id));
