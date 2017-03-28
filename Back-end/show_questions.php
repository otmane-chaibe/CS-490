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

require_once('../mysql.php');
require_once('../functions.php');

header('Content-Type: application/json');

assertPost();

echo json_encode(Question::listAllQuestions());

