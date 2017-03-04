<?php

require_once('../functions.php');
require_once('FunctionCheck.php');

# Test 0 - Fail
try {
	$f_check = new FunctionCheck("");
	$f_check->signature();
	echo $f_check . "\n";
} catch (InvalidArgumentException $ex) {
	echo "Test 0 (failed): " . $ex->getMessage() . "\n";
} catch (BadModifierException $ex) {
	echo $ex->getMessage() . "\n";
}
	
# Test 1 - Pass
$sample = "public int sum (int a, int b)";
$f_check = new FunctionCheck($sample);
$f_check->signature();
echo $f_check . "\n";
echo "Test passed\n";

# Test 2 - Pass
$sample = "public int sum(int a, int b)";
$f_check = new FunctionCheck($sample);
$f_check->signature();
echo $f_check . "\n";
echo "Test passed\n";

# Test 3 - Pass 
$sample = " public int sum(int a,int b) ";
$f_check = new FunctionCheck($sample);
$f_check->signature();
echo $f_check . "\n";
echo "Test passed\n";

# Test 4 - Pass
$sample = " public static int sum (int a,int b) ";
$f_check = new FunctionCheck($sample);
$f_check->signature();
echo $f_check . "\n";
echo "Test passed\n";

# Test 5 - Fail
$sample = "public static void int sum (int a,int b)";
$f_check = new FunctionCheck($sample);
$f_check->signature();
echo $f_check . "\n";
echo "Test passed\n";

# Test 6 - Fail
$sample = "public class static void int sum (int a,int b)";
$f_check = new FunctionCheck($sample);
$f_check->signature();
echo $f_check . "\n";
echo "Test passed\n";
