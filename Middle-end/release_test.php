<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['id'])) {
	error("Missing Parameter: id.");
}

$id = (int) $_POST['id'];

$resp = http(BACK_END, "release_test", [
	'id' => $id
]);

if ($resp === false) {
	error("cURL request failed.");
}

echo $resp;
