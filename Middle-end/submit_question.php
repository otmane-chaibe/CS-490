<?php
	
require_once('../functions.php');
require_once('FunctionCheck.php');

header('Content-Type: application/json');

assertPost();

$solution = $_POST['solution'];
$question_id = $_POST['question_id'];
$test_id = $_POST['test_id'];

	
?>