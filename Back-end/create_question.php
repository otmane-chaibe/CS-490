<?php

# Khurshid Sohail

require_once('../functions.php');

assertPost();

$user_id = $_POST['user_id'];
$fname = $_POST['fname'];
$category = $_POST['category'];
$difficulty = $_POST['difficulty'];
$return_type = $_POST['returntype'];
$args = $_POST['args'];
$description = $_POST['description'];

$question_id = Question::createQuestion($user_id, $fname, $category, $difficulty, $return_type, $args, $description);

if (empty($question_id)) {
	error("Failed to create question.");
}

echo json_encode($question_id);
