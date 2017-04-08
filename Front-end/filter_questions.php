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

$category = (int) $_POST['category'];
$difficulty = (int) $_POST['difficulty'];

$questions = http(MIDDLE_END, "get_all_test_questions", [
	'category'   => $category,
	'difficulty' => $difficulty,
]);

if ($questions === false) {
	error("cURL request failed");
}

echo json_encode($questions);
