<?php

# Khurshid Sohail

require_once('../functions.php');

assertPost();

echo json_encode(Test::getAllTests());
