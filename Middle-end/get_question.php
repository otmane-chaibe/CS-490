<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['q_id'])) {
	error("Missing Parameter: question_id.");
}

$q_id = (int) $_POST['q_id'];

$question = http(BACK_END, "get_question", [
	"q_id" => $q_id
]);

if ($question === false) {
	error("cURL request failed.");
}

echo $question;
