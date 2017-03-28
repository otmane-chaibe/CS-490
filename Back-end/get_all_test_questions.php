<?php

# Khurshid Sohail

require_once('../functions.php');

assertPost();

# Check for filters ...
if (empty($_POST['difficulty'] && $_POST['ftype']))
	{
	 echo json_encode(Question::listAllQuestions());
	}

else
	{
	 $difficulty = $_POST['difficulty'];
	 $ftype = $_POST['ftype'];

	 echo json_encode(Question::filter($difficulty, $ftype));
	}
