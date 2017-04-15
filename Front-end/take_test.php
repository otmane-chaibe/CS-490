<?php

# Maurice Achtenhagen

require_once('header.php');

if (!isset($_GET['id'])) {
	redirect("student.php");
}

$test_id = (int) $_GET['id'];

$test = http(MIDDLE_END, "take_test", [
	'test_id' => $test_id,
]);

if ($test === false) {
	error("cURL request failed");
}

if (empty($test)) {
	redirect("student.php");
}

$questions = http(MIDDLE_END, "get_questions_for_test", [
	'test_id' => $test_id,
]);

if ($questions === false) {
	error("cURL request failed");
}

?>
<div id="test-questions-wrapper">
	<div id="note"><strong>Please note:</strong>&nbsp;all answers must be provided in Java code.</div>
	<div id="error"></div>
	<ul id="test-questions">
		<?php
			$idx = 0;
			foreach ($questions as $index => $q) {
				$idx++;
				echo '
					<li>
						<strong>' . ($q['weight'] * 100) . ' pts</strong>
						<p>'
							. generate_question_description($q) . '
						</p>
						<textarea id="solution-' . $q['question_id'] . '"></textarea>
					</li>
				';
			}
		?>
	</ul>
	<button id="submit-btn" class="button green" type="button">Submit Answers</button>
</div>
<script type="text/javascript">
	let questions =  JSON.parse('<?=json_encode($questions)?>')
	let identifiers = Object.keys(questions)
	var testID = <?=$test_id?>
</script>
<?php
	$js = "take_test";
	require_once('footer.php');
?>
