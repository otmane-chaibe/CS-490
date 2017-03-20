<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

# cURL Request -> Back-end -> student_tests.php
$resp = http(BACK_END, "student_tests");

if ($resp === false) {
	error("cURL request failed");
}

echo $resp;
