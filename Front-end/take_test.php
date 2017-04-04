<?php

# Maurice Achtenhagen

require_once('header.php');

if (!isset($_GET['id'])) {
	redirect("student.php");
}

$test_id = (int) $_GET['id'];

$test = http(MIDDLE_END, "take_test", [
	"test_id" => $test_id,
]);

if ($test === false) {
	error("cURL request failed");
}

if (empty($test)) { die('No Such Test.'); }

$questions = http(MIDDLE_END, "get_questions_for_test", [
	"test_id" => $test_id,
]);

if ($questions === false) {
	error("cURL request failed");
}

function get_args($args) {
	$str_out = array_map(function($value) { return type_to_string($value); }, $args);
	return implode(', ', $str_out);
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
						' . $idx .'. Write a function of type <strong>' . type_to_string($q['function_type']) . '</strong> named <strong>' . $q['function_name'] . '</strong>
						accepting ' . count($q['arguments']) . ' argument(s), of type(s): <b>' . get_args($q['arguments']) . ' </b>' . $q['description'] . '
						<textarea id="solution-' . $q['id'] . '"></textarea>
					</li>
				';
			}
		?>
	</ul>
	<button id="submit-btn" class="button green" type="button">Submit Answers</button>
</div>
<script type="text/javascript">
	var elems = [<?php foreach ($questions as $idx => $q) { echo "'solution-" . $idx . "'"; if ($idx !== count($questions) -1 ) { echo ","; } } ?>]
	var ids = [<?php foreach ($questions as $idx => $q) { echo $q['id']; if ($idx !== count($questions) -1 ) { echo ","; } } ?>]
	var testID = <?php echo $test_id ?>
</script>
<?php
	$js = "take_test";
	require_once('footer.php');
?>
