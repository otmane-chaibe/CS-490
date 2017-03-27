<?php

require_once('header.php');

assert_post();

if (!isset($_POST['test_id'])) {
	error("Missing Parameter: test_id.");
}

$test_id = (int) $_POST['test_id'];

$test = http(BACK_END, "take_test.php", [
	"test_id" => $test_id,
]);

if ($test === false) {
	error("cURL request failed");
}

echo $test;
