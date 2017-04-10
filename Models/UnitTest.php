<?php

# Maurice Achtenhagen

class UnitTest {

	public static function createUnitTest($question_id, $inputs, $types, $output) {
		global $mysqli;
		$sql = "INSERT INTO unit_tests (question_id, output) VALUES ($question_id, '$output')";
		$mysqli->query($sql);
		$unit_test_id = $mysqli->insert_id;
		foreach ($inputs as $idx => $input) {
			$type = (int) $types[$idx];
			$sql = "INSERT INTO unit_test_inputs (unit_test_id, type, input) VALUES ($unit_test_id, '$type', '$input')";
			$mysqli->query($sql);
		}
		return $unit_test_id;
	}

	public static function insertUnitTestResult($unit_test_id, $output, $expected) {
		global $mysqli;
		$sql = "INSERT INTO unit_test_results (unit_test_id, output, expected) VALUES ($unit_test_id, '$output', '$expected')";
		$mysqli->query($sql);
		return $mysqli->insert_id;
	}

	public static function getUnitTestResults($unit_test_id) {
		global $mysqli;
		$unit_test_results = [];
		$sql = "SELECT output,expected FROM unit_test_results WHERE unit_test_id = $unit_test_id";
		$result = $mysqli->query($sql);
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$unit_test_results[] = [
				'output'   => $row['output'],
				'expected' => $row['expected'],
			];
		}
		return $unit_test_results;
	}

	public static function getUnitTestsForQuestion($question_id) {
		global $mysqli;
		$unit_tests = [];
		$sql = "SELECT id,output FROM unit_tests WHERE question_id = $question_id";
		$result = $mysqli->query($sql);
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$unit_test_id = (int) $row['id'];
			$unit_tests[] = [
				'id'     => $unit_test_id,
				'inputs' => self::getInputsForUnitTest($unit_test_id),
				'output' => $row['output'],
			];
		}
		return $unit_tests;
	}

	private static function getInputsForUnitTest($unit_test_id) {
		global $mysqli;
		$sql = "SELECT type,input FROM unit_test_inputs WHERE unit_test_id = $unit_test_id";
		$result = $mysqli->query($sql);
		$out = [];
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[] = [
				'type'  => (int) $row['type'],
				'value' => $row['input'],
			];
		}
		return $out;
	}
}
