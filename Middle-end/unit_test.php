<?php

require_once('../functions.php');
require_once('FunctionCheck.php');

//$tests = ["
//	public static int sum(int a, int b, int c) {
//		return a + b;
//	}
//", "
//	public int oddEven (int n) {
//		if (a % mod == 0) {
//			return 1;
//		} else {
//			return 0;
//		}
//	}
//", "
//	class static void int sum (int a, int b, int c) {
//		// Bad function signature
//	}
//"];

$tests = ["
	public static int sum(int a, int b) {
		return a + b;
	}
"];

$unit_tests = [
	["inputs" => [5,2], "output" => 7],
	["inputs" => [1,1], "output" => 2]
];

$solution = [
	"modifiers" => ["public", "static"],
	"type"      => "int",
	"name"      => "sum",
	"params"    => [
		["name" => "a", "type" => "int"],
		["name" => "b", "type" => "int"]
	]
];

foreach($tests as $key => $value) {
	echo "Test $key: ";
	try {
		$f_check = new FunctionCheck($value, $solution, $unit_tests);
		$f_check->parse();
		$f_check->compile();
		$f_check->run_tests();
		echo "Test score: " . $f_check->score;
	} catch (InvalidArgumentException $ex) {
		echo $ex->getMessage();
	} catch (BadModifierException $ex) {
		echo $ex->getMessage();
	} catch (BadFunctionNameException $ex) {
		echo $ex->getMessage();
	}
	echo "\n";
}
