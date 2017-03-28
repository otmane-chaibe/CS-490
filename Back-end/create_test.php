<?php

# Maurice Achtenhagen

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if (empty($_POST['name'])) {
	error('Test name cannot be empty.');
}

$user_id = (int) $_POST['user_id'];
$name = trim($_POST['name']);

echo(json_encode(Test::createTest($name, $user_id)));
