<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if (!isset($_POST['id'])) {
	error("Missing Parameter: id.");
}

$id=(int)$_POST['id'];

Test::releaseTest($id);

echo json_encode(true);
