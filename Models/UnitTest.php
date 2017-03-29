<?php

# Maurice Achtenhagen

class UnitTest {

	public static function createUnitTest($question_id, $inputs, $types, $output) {
		global $mysqli;
		foreach ($inputs as $idx => $input) {
			$type = (int) $types[$idx];
			$sql = "INSERT INTO unit_test_inputs (question_id, type, value) VALUES ($question_id, '$type', '$input')";
			$mysqli->query($sql);
		}
		$sql = "INSERT INTO unit_tests (question_id, output) VALUES ($question_id, '$output')";
		$mysqli->query($sql);
		return $mysqli->insert_id;
	}

	# Support arg types other than int
	public static function getUnitTestsForQuestion($question_id) {
		global $mysqli;
		$unit_tests = [];
		$sql = "SELECT question_id, output FROM unit_tests WHERE question_id = $question_id";
		$result = $mysqli->query($sql);
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$unit_tests[] = [
				'inputs' => self::getInputsForUnitTest($question_id),
				'output' => (int) $row['output']
			];
		}
		return $unit_tests;
	}

	# Todo: return arg type as well
	private static function getInputsForUnitTest($question_id) {
		global $mysqli;
		$sql = "SELECT input,value FROM unit_test_inputs WHERE question_id = $question_id";
		$result = $mysqli->query($sql);
		$out = [];
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[] = (int) $row['value'];
		}
		return $out;
	}
}
