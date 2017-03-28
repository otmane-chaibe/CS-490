<?php

# Maurice Achtenhagen

/*
	student_tests.php
	-----------------------------------------------
	This file is called via a cURL request from the
	middle-end. It will query the db and return its
	response. Note the call to the model here.
	-----------------------------------------------
*/

require_once('../functions.php');

header('Content-Type: application/json');

assertPost();

$test_id=$_POST['test_id'];
$user_id=$_POST['user_id'];

echo json_encode(Test::releaseTest($test_id, $user_id));

