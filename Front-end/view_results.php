<?php

# Maurice Achtenhagen

require_once('header.php');

$test_id = (int) $_GET['id'];

$test_results = http(MIDDLE_END, "get_test_solutions", [
	'test_id' => $test_id
]);

if ($test_results === false) {
	error("cURL request failed.");
}

$questions = http(MIDDLE_END, "get_questions_for_test", [
	'test_id' => $test_id
]);

if ($questions === false) {
	error("cURL request failed");
}

function getUnitTestInputsAsString($inputs) {
	$input_arr = [];
	foreach($inputs as $input) {
		$input_arr[] = $input['value'];
	}
	return implode(",", $input_arr);
}

?>

<div id="results-wrapper">
<?php
	$idx = 0;
	foreach ($questions as $index => $q) {
		$idx++;
		if (isset($test_results[$idx-1]['solution'])) {
			echo '
				<div class="question">' .
					generate_question_description($q) . '
					<textarea id="solution-' . $q['question_id'] . '" readonly>' .
						$test_results[$idx-1]['solution'] .'
					</textarea>
				</div>
			';
		}
	}
?>
</div>
<div id="results-table-wrapper">
	<?php
		foreach($test_results as $result) {
			$unit_tests = http(MIDDLE_END, "get_unit_tests_for_question", [
				'q_id' => $result['question_id']
			]);
			echo '
				<div class="result">
					<div class="header">Results</div>
					<table class="result-table">
						<thead>
							<tr>
								<td><input type="number" name="score" value="' . $result['score'] . '" step="1" min="0" max="100"></td>
								<td>Points</td>
								<td>Pass</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Function Modifier</td>
								<td>10</td>
								<td>' . ($result['has_correct_function_modifier'] == 1 ? "<div class=\"pass\">Yes</div>" : "<div>No</div>") .'</td>
							</tr>
							<tr>
								<td>Function Type</td>
								<td>10</td>
								<td>' . ($result['has_correct_function_type'] == 1 ? "<div class=\"pass\">Yes</div>" : "<div>No</div>") .'</td>
							</tr>
							<tr>
								<td>Function Name</td>
								<td>10</td>
								<td>' . ($result['has_correct_function_name'] == 1 ? "<div class=\"pass\">Yes</div>" : "<div>No</div>") .'</td>
							</tr>
								<td>Function Params</td>
								<td>10</td>
								<td>' . ($result['has_correct_function_params'] == 1 ? "<div class=\"pass\">Yes</div>" : "<div>No</div>") .'</td>
							</tr>
							<tr>
								<td>Compiles</td>
								<td>10</td>
								<td>' . ($result['does_compile'] == 1 ? "<div class=\"pass\">Yes</div>" : "<div>No</div>") .'</td>
							</tr>
							<tr>
								<td>Passes Unit Tests</td>
								<td>50</td>
								<td>' . ($result['passes_unit_tests'] == 1 ? "<div class=\"pass\">Yes</div>" : "<div>No</div>") .'</td>
							</tr>
						</tbody>
					</table>
			';
			if (!empty($unit_tests)) {
				echo '
					<div class="header">Unit Tests</div>
					<table class="unit-test-table">
						<thead>
							<tr>
								<td>Input</td>
								<td>Output</td>
								<td>Expected</td>
								<td>Pass</td>
							</tr>
						</thead>
						<tbody>
				';
				foreach($unit_tests as $key => $unit_test) {
					$results = http(MIDDLE_END, "get_unit_test_results", [
						'unit_test_id' => $unit_test['id']
					]);
					foreach($results as $k => $r) {
						$expected = "";
						if (isset($r['expected'])) {
							$expected = $r['expected'];
						}
						$output = "";
						if (isset($r['output'])) {
							$output = $r['output'];
						}
						echo '
							<tr>
								<td><b>' . getUnitTestInputsAsString($unit_test['inputs']) . '</b></td>
								<td><b>' . $output . '</b></td>
								<td><b>' . $expected . '</b></td>
								<td>' . (strcasecmp((string) $output, (string) $expected) == 0 ? "<div class=\"pass\">Yes</div>" : "<div>No</div>") . '</td>
							</tr>
						';
					}

				}
				echo '
					</tbody>
					</table>
				';
				echo '
					<div class="header">Remark</div>
					<textarea id="remark" placeholder="Question Remark"' . ($_SESSION['role'] == 0 ? "readonly" : "") . '>' . $result['remark'] . '</textarea>
				';
			}
			echo '</div>';
		}
	?>
</div>
