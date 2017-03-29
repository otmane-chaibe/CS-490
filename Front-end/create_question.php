<?php

# Maurice Achtenhagen

require_once('../functions.php');

session_start();

header('Content-Type: application/json');

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

$fname = trim($_POST['fname']);
$category = (int) $_POST['category'];
$difficulty = (int) $_POST['difficulty'];
$return_type = (int) $_POST['return_type'];
$description = $_POST['description'];

if (empty($fname)) {
	error('Function name cannot be empty.');
}

if (empty($description)) {
	error('Function description cannot be empty.');
}

$arg_names = [];
$arg_types = [];
if (isset($_POST['arg_name'])) {
	foreach ($_POST['arg_name'] as $name) {
		$arg_names[] = $name;
	}
}

if (isset($_POST['arg_type'])) {
	foreach ($_POST['arg_type'] as $type) {
		$arg_types[] = $type;
	}
}

$question_id = http(MIDDLE_END, "create_question", [
	"user_id"     => $_SESSION['user_id'],
	"fname"       => $fname,
	"category"    => $category,
	"difficulty"  => $difficulty,
	"return_type" => $return_type,
	"description" => $description,
	"arg_name"    => json_encode($arg_names),
	"arg_type"    => json_encode($arg_types),
]);

if ($question_id === false) {
	error("cURL request failed");
}

echo json_encode($question_id);
