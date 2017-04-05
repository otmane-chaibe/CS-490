<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if (!isset($_POST['difficulty']) && !isset($_POST['ftype']))
	{
	 echo json_encode(Question::listAllQuestions());
	}

else
	{
	 $difficulty = (int)$_POST['difficulty'];
	 $ftype = (int)$_POST['ftype'];
	 echo json_encode(Question::filter($difficulty, $ftype));
	}
