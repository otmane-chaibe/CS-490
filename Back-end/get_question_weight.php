<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['q_id']))
{
	error("Missing Parameters");
}

$q_id = $_POST['q_id'];

echo json_encode(Test::getQuestionWeight($q_id));
