<?php

#Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['user_id']) || !isset($_POST['test_id']) || !isset($_POST['score']))
{
	error("Missing Parameters");
}

$user_id=(int) $_POST['user_id'];
$test_id=(int) $_POST['test_id'];
$score=(int) $_POST['score'];

Test::insertTestScore($user_id, $test_id, $score);
echo json_encode(true);
