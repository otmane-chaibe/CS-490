<?php

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

# Check for filters ...

echo json_encode(Question::listAllQuestions());
