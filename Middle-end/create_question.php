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

if (!isset($_POST['returntype'])) {
	error('Missing Parameter: returntype.');
}

if (!isset($_POST['description'])) {
	error('Missing Parameter: description.');
}

$user_id = $_POST['user_id'];
$fname = $_POST['fname'];
$category = $_POST['category'];
$difficulty = $_POST['difficulty'];
$return_type = $_POST['returntype'];
$args = $_POST['args'];
$description = $_POST['description'];

$question_id = http(BACK_END, "create_question", [
	"user_id"     => $user_id,
	"fname"       => $fname,
	"category"    => $category,
	"difficulty"  => $difficulty,
	"returntype"  => $return_type,
	"args"        => $args,
	"description" => $description,
]);

if ($question_id === false) {
	error("cURL request failed");
}

echo $question_id;
