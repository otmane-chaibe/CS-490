<?php

require_once('../functions.php');
require_once('FunctionCheck.php');

//$tests = [
//	"",
//	"{",
//	"public int sum (int a, int b) {",
//	"public int sum(int a,int b) {",
//	" public int sum(int a,int b) {",
//	" public static int sum (int a,int b){ ",
//	"public static void sum (int a,int b){",
//	"public static void int sum(int a,int b) {",
//	"public class static void int sum (int a,int b) {"
//];

$tests = ["
	public static int sum(int a, int b) {
		return a + b;
	}
"];

$unit_tests = [
	"inputs" => [5,2],
	"output" => 7
];

foreach($tests as $key => $value) {
	echo "Test $key: ";
	try {
		$f_check = new FunctionCheck($value, $unit_tests);
		$f_check->parse();
		$f_check->compile();
		$f_check->run_tests();
		echo "Test passed.";
	} catch (InvalidArgumentException $ex) {
		echo $ex->getMessage();
	} catch (BadModifierException $ex) {
		echo $ex->getMessage();
	} catch (BadFunctionNameException $ex) {
		echo $ex->getMessage();
	}
	echo "\n";
}
