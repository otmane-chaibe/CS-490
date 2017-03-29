<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['category'])) {
	error('Missing Parameter: category.');
}

if (!isset($_POST['difficulty'])) {
	error('Missing Parameter: difficulty.');
}

if (!isset($_POST['fname'])) {
	error('Missing Parameter: fname.');
}

if (!isset($_POST['return_type'])) {
	error('Missing Parameter: return_type.');
}

if (!isset($_POST['description'])) {
	error('Missing Parameter: description.');
}

$user_id = (int) $_POST['user_id'];
$fname = $_POST['fname'];
$category = (int) $_POST['category'];
$difficulty = (int) $_POST['difficulty'];
$return_type = (int) $_POST['return_type'];
$description = $_POST['description'];

$question_id = http(BACK_END, "create_question", [
	"user_id"     => $user_id,
	"fname"       => $fname,
	"category"    => $category,
	"difficulty"  => $difficulty,
	"return_type" => $return_type,
	"description" => $description,
	"arg_name"    => $_POST['arg_name'],
	"arg_type"    => $_POST['arg_type'],
]);

if ($question_id === false) {
	error("cURL request failed");
}

echo $question_id;
