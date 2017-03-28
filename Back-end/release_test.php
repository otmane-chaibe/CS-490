<?php

# Maurice Achtenhagen

require_once('../functions.php');

header('Content-Type: application/json');

assertPost();

$test_id=$_POST['test_id'];
$user_id=$_POST['user_id'];

echo json_encode(Test::releaseTest($test_id, $user_id));
