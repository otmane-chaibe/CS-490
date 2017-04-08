<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if (!isset($_POST['difficulty']) && !isset($_POST['category']))
	{
	 echo json_encode(Question::listAllQuestions());
	}

else
	{
	 $difficulty = (int)$_POST['difficulty'];
	 $category = (int)$_POST['category'];
	 echo json_encode(Question::filter($category, $difficulty));
	}
