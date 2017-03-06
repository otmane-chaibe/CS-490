<?php
	
class UnitTest {
	
	public static function createUnitTest($question_id, $inputs, $output) {
		global $mysqli;
		
		foreach ($inputs as $input) {
			$sql = "INSERT INTO unit_test_inputs (question_id, input, value) VALUES (?, ?, ?)";
			$stmt = null;
			if (!$stmt = $mysqli->prepare($sql)) {
				return;
			}
			$stmt->bind_param('iis', $question_id, $input["type"], $input["value"]);
			$stmt->execute();
			$stmt->close();
		}
		
		$sql = "INSERT INTO unit_tests (question_id, output) VALUES (?, ?)";
		$stmt = null;
		if (!$stmt = $mysqli->prepare($sql)) {
			return;
		}
		$stmt->bind_param('is', $question_id, $output);
		$stmt->execute();
		$stmt->close();
	}
	
	# Support arg types other than int
	public static function getUnitTestsForQuestion($question_id) {
		global $mysqli;
		$unit_tests = [];		
		$sql = "SELECT question_id,output FROM unit_tests WHERE question_id = $question_id";
		$result = $mysqli->query($sql);
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$unit_tests[] = [
				'inputs' => self::getInputsForUnitTest($question_id),
				'output' => (int)$row['output']
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
			$out[] = (int)$row['value'];
		}
		return $out;
	}
	
	# Get the argument type from string
	public static function get_type_from($str) {
		if (empty($str)) { return 0; }
		switch ($str) {
			case "int":
				return 0;
			case "float":
				return 1;
			case "double":
				return 2;
			case "string":
				return 3;
			case "bool":
				return 4;											
			default:
				return 0;
		}
	}
}
