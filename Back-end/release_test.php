<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

$test_id=$_POST['test_id'];
$user_id=$_POST['user_id'];

echo json_encode(Test::releaseTest($test_id, $user_id));
