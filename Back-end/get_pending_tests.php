<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

echo json_encode(Test.php::getPendingTests());
