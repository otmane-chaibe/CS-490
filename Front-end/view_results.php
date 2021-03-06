<?php

# Maurice Achtenhagen

require_once('header.php');

$seen = [];

$test_id = (int) $_GET['id'];

$test_results = http(MIDDLE_END, "get_test_solutions", [
	'test_id' => $test_id
]);

if ($test_results === false) {
	error("cURL request failed.");
}

if (empty($test_results)) {
	redirect("instructor.php");
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
	foreach ($questions as $index => $q) {
		$seen[] = $index;
		echo '
			<div class="question">' .
				generate_question_description($q) . '
				<textarea id="solution-' . $q['question_id'] . '" readonly>' .
					$test_results[$index]['solution'] .'
				</textarea>
			</div>
		';
	}
?>
</div>
<div id="results-table-wrapper">
<?php
	foreach($seen as $index) {
	$unit_tests = http(MIDDLE_END, "get_unit_tests_for_question", [
		'q_id' => $index
	]);
	$result = $test_results[$index];
	echo '
		<div class="result">
			<div class="header">Results</div>
			<table class="result-table">
				<thead>
					<tr>
						<td>Criteria</td>
						<td>Points</td>
						<td>Pass</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Function Modifier</td>
						<td>' . ($result['has_correct_function_modifier'] == 1 ? ((double) $result['weight'] * 10) : "0") .'</td>
						<td>' . ($result['has_correct_function_modifier'] == 1 ? "<div class=\"pass\">Yes</div>" : "<div>No</div>") .'</td>
					</tr>
					<tr>
						<td>Function Type</td>
						<td>' . ($result['has_correct_function_type'] == 1 ? ((double) $result['weight'] * 10) : "0") .'</td>
						<td>' . ($result['has_correct_function_type'] == 1 ? "<div class=\"pass\">Yes</div>" : "<div>No</div>") .'</td>
					</tr>
					<tr>
						<td>Function Name</td>
						<td>' . ($result['has_correct_function_name'] == 1 ? ((double) $result['weight'] * 10) : "0") .'</td>
						<td>' . ($result['has_correct_function_name'] == 1 ? "<div class=\"pass\">Yes</div>" : "<div>No</div>") .'</td>
					</tr>
						<td>Function Params</td>
						<td>' . ($result['has_correct_function_params'] == 1 ? ((double) $result['weight'] * 10) : "0") .'</td>
						<td>' . ($result['has_correct_function_params'] == 1 ? "<div class=\"pass\">Yes</div>" : "<div>No</div>") .'</td>
					</tr>
					<tr>
						<td>Code Compiles</td>
						<td>' . ($result['does_compile'] == 1 ? ((double) $result['weight'] * 10) : "0") .'</td>
						<td>' . ($result['does_compile'] == 1 ? "<div class=\"pass\">Yes</div>" : "<div>No</div>") .'</td>
					</tr>
					<tr>
						<td>Passes Unit Tests</td>
						<td>' . ($result['passes_unit_tests'] == 1 ? ((double) $result['weight'] * 50) : "0") .'</td>
						<td>' . ($result['passes_unit_tests'] == 1 ? "<div class=\"pass\">Yes</div>" : "<div>No</div>") .'</td>
					</tr>
					<tr>
						<td><b>Total</b></td>
						<td>';
						if ($_SESSION['role'] == 1) {
							echo '
								<input id="score-counter-' . $result['question_id'] . '" type="number" data-id="' . $result['id'] .
								'" value="' . $result['score'] . '" step="1" min="0" max="' . ($result['weight'] * 100) . '" />
							';
						} else {
							echo $result['score'];
						}
						echo '
						</td>
						<td><b>' . ((double) $result['weight'] * 100) . '</b></td>
					</tr>
				</tbody>
			</table>';
		if ($result['does_compile'] == 1) {
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
					'unit_test_id' => $unit_test['id'],
					'test_id'      => $test_id,
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
							<td>' . getUnitTestInputsAsString($unit_test['inputs']) . '</td>
							<td>' . $output . '</td>
							<td>' . $expected . '</td>
							<td>' . (strcasecmp((string) $output, (string) $expected) == 0 ? "<div class=\"pass\">Yes</div>" : "<div>No</div>") . '</td>
						</tr>
					';
				}
			}
			echo '
				</tbody>
				</table>
			';
		}
		echo '
			<div class="header">Remark</div>
			<textarea id="remark-' . $result['question_id'] . '" placeholder="Question Remark"' . ($_SESSION['role'] == 0 ? "readonly" : "") . '>' . $result['remark'] . '</textarea>
		';
		if ($_SESSION['role'] == 1) {
			echo '<button id="question-edit-btn-' . $result['question_id'] . '" type="button" data-id="' . $result['id'] . '" class="blue">Save Changes</button>';
		}
		echo '</div>';
	}
?>
</div>
<script type="text/javascript">
	let questions =  JSON.parse('<?=json_encode($questions)?>')
	let identifiers = Object.keys(questions)
	var testID = <?=$test_id?>
</script>
<?php
	$js = "view_results";
	require_once('footer.php');
?>
