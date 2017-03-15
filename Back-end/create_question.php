<?php

/*
	create_question.php
	-----------------------------------------------
	This file is called via a cURL request from the
	middle-end. It will query the db and return its
	response. Note the call to the model here.
	-----------------------------------------------
*/

require_once('../functions.php');

header('Content-Type: application/json');

assertPost();

$user_id=$_POST['user_id'];
$name=$_POST['function_name'];
$category=$_POST['category'];
$difficulty=$_POST['difficulty'];
$type=$_POST['function_type'];
$args=$_POST['args'];
$description=$_POST['description'];


#echo json_encode(Question::listAllQuestions());
echo json_encode(Question::createQuestion($user_id, $name,$category, $difficulty, $type, $args, $description));

