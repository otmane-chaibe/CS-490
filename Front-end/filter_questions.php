<?php

# Maurice Achtenhagen

require_once('../functions.php');

session_start();

header('Content-Type: application/json');

assertPost();

$params = [];

if (isset($_POST['category']) && isset($_POST['difficulty'])) {
	$params = [
		'category'   => (int) $_POST['category'],
		'difficulty' => (int) $_POST['difficulty'],
	];
}

$questions = http(MIDDLE_END, "get_all_test_questions", $params);

if ($questions === false) {
	error("cURL request failed");
}

echo json_encode($questions);
