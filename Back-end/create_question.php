<?php

# Khurshid Sohail // Maurice Achtenhagen 

require_once('../mysql.php');
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

$args = [];
$user_id = (int) $_POST['user_id'];
$fname = $_POST['fname'];
$category = (int) $_POST['category'];
$difficulty = (int) $_POST['difficulty'];
$return_type = (int) $_POST['return_type'];
$description = $_POST['description'];

if (isset($_POST['arg_name'])) {
	$arg_names = json_decode($_POST['arg_name']);
	$arg_types = json_decode($_POST['arg_type']);
	foreach ($arg_names as $offset => $argname) {
		$argname = trim($argname);
		if (empty($argname)) {
			error("Argument #" . ($offset + 1) . ": name cannot be empty.");
		}
		$argtype = $arg_types[$offset];
		if ($argtype == "-1") {
			error("Argument #" . ($offset + 1) . ": type must be set.");
		}
		$args[] = [
			'type' => $argtype,
			'name' => $argname,
		];
	}
}

$question_id = Question::createQuestion($user_id, $fname, $category, $difficulty, $return_type, $description, $args);

if (empty($question_id)) {
	error("Failed to create question.");
}

echo json_encode($question_id);
