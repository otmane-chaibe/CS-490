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
			
			$sql = "INSERT INTO unit_tests (question_id, output) VALUES (?, ?)";
			$stmt = null;
			if (!$stmt = $mysqli->prepare($sql)) {
				return;
			}
			$stmt->bind_param('is', $question_id, $output);
			$stmt->execute();
			$stmt->close();
		}
	}
}