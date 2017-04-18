<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['test_id']) || !isset($_POST['score']))
{
	error("Missing Parameters");
}

$test_id = $_POST['test_id'];
$score = $_POST['score'];

echo json_encode(Test::updateTestScore($test_id, $score));

