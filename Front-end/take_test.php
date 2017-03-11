<?php

require_once('../functions.php');
require_once('header.php');

$test_id = (int) $_GET['id'];
if (empty($test_id)) {
	redirect("student.php");
}

$test = Test::getTestById($test_id);
$questions = Question::getQuestionsForTest($test_id);

function type_to_string($type) {
	switch ($type) {
		case 0: return "Int";
		case 1: return "Float";
		case 2: return "Double";
		case 3; return "String";
		case 4: return "Boolean";
		default: return "Int";
	}
}

function get_args($args) {
	$str_out = array_map(function($value) { return type_to_string($value); }, $args);
	return implode(', ', $str_out);
}

if (empty($test)) { die('No Such Test.'); }

?>

<div id="test-questions-wrapper">
	<div id="error"></div>
	<ul id="test-questions">
		<?php
			$idx = 0;
			foreach ($questions as $index => $q) {
				$idx++;
				echo '
					<li>
						' . $idx .'. Write a function named <strong>' . $q['function_name'] . '</strong>
						of type <strong>' . type_to_string($q['function_type']) . '</strong>
						accepting ' . count($q['arguments']) . ' argument(s), of type(s): <b>' . get_args($q['arguments']) . ' </b>' . $q['description'] . '
						<textarea id="solution-' . $q['id'] . '"></textarea>
					</li>
				';
			}
		?>
	</ul>
	<button id="submit-btn" class="button green" type="button">Submit</button>
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