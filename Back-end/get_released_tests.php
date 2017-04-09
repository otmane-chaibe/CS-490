<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../funcions.php');

assertPost();

echo json_encode(Test::getReleasedTests());
