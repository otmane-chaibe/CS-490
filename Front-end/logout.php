<?php

# Maurice Achtenhagen

require_once('../functions.php');

session_start();
session_destroy();

redirect('index.php');
