<?php

# Maurice Achtenhagen

require_once('header.php');

$test_id = (int) $_GET['id'];
if (empty($test_id)) {
	redirect("instructor.php");
}

$test = http(MIDDLE_END, "test", [
	"test_id" => $test_id
]);

if ($test === false) {
	error("cURL request failed");
}

if (empty($test)) { die('No Such Test.'); }

$test_questions = http(MIDDLE_END, "get_questions_for_test", [
	"test_id" => $test_id
]);

$all_questions = http(MIDDLE_END, "get_all_test_questions");

?>
<div id="test-wrapper">
	<h1><?=$test['name']?></h1>
	<table border="1" id="questions">
		<tbody>
		<?php
			$seen = [];
			foreach($test_questions as $id => $question) {
				$seen[] = $id;
				echo '<tr>';
				echo '<td>' . $question['function_name'] . '</td>';
				echo '<td><button id="delete' . $id . '" class="red">Delete</button></td>';
				echo '</tr>';
			}
		?>
		</tbody>
	</table>
	<hr/>
	Add a question:
	<select id="question"><?php
		foreach ($all_questions as $q) {
			if (in_array($q['id'], $seen)) { continue; }
			$id = $q['id'];
			$name = $q['function_name'];
			$diff = "Unknown";
			switch ($q['difficulty']) {
				case Question::DIFFICULTY_EASY: $diff = 'Easy'; break;
				case Question::DIFFICULTY_MEDIUM: $diff = 'Medium'; break;
				case Question::DIFFICULTY_DIFFICULT: $diff = 'Difficult'; break;
			}
			echo sprintf('<option value="%d">%s (%s)</option>', $id, $name, $diff);
		}
	?></select>
	<button id="submit" type="submit" style="width: 100px" class="green" >Add</button>
</div>
<script>
	var test_id = <?=$test_id?>;
	var questions = <?=json_encode($seen)?>;
</script>
<?php
	$js = "test";
	require_once('footer.php');
?>
