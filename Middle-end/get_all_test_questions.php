<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

$params = [];

if (isset($_POST['category']) && isset($_POST['difficulty'])) {
	$params = [
		'category'   => (int) $_POST['category'],
		'difficulty' => (int) $_POST['difficulty'],
	];
}

$questions = http(BACK_END, "get_all_test_questions", $params);

if ($questions === false) {
	error("cURL request failed");
}

echo $questions;
