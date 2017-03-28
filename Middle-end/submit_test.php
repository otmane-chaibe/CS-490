<?php

# Maurice Achtenhagen

require_once('../functions.php');
require_once('FunctionCheck.php');

header('Content-Type: application/json');

assertPost();
session_start();

$final_score = 0;
$scores = [];

$solutions = []; # student solutions
$q_solutions = []; # question solutions
$question_ids = [];
$unit_tests = [];
foreach ($_POST['solution'] as $input) { $solutions[] = $input; }
foreach ($_POST['qid'] as $q_id) { $question_ids[] = $q_id; }
foreach ($question_ids as $q_id) { $unit_tests[] = UnitTest::getUnitTestsForQuestion($q_id); }
foreach ($question_ids as $q_id) { $q_solutions[] = Question::getQuestionSolution($q_id); }
foreach($solutions as $idx => $input) {
	try {
		$f_check = new FunctionCheck($input, $q_solutions[$idx], $unit_tests[$idx]);
		$f_check->parse();
		$f_check->compile();
		$f_check->run_tests();
		Test::insertQuestionScore($_SESSION['user_id'], $_POST['test_id'], $_POST['qid'], $f_check->score);
		$scores[] = $f_check->score;
	} catch (InvalidArgumentException $ex) {
		echo $ex->getMessage();
	} catch (BadModifierException $ex) {
		echo $ex->getMessage();
	} catch (BadFunctionNameException $ex) {
		echo $ex->getMessage();
	}
}

foreach($scores as $s) { $final_score =+ $s; }
Test::insertTestScore($_SESSION['user_id'], $_POST['test_id'], $final_score / count($question_ids));

echo(json_encode(true));