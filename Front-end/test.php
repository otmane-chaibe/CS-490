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

if ($test_questions === false) {
	error("cURL request failed");
}

$questions = http(MIDDLE_END, "get_all_test_questions");

if ($questions === false) {
	error("cURL request failed");
}

$q_ids = [];

?>
<div id="sidebar">
	<div id="filter">
		<input id="filter-search" type="text" placeholder="Search Questions" />
		<button id="filter-search-btn" type="button" class="button red">Search</button>
		<div class="selector">
			<span id="filter-type-label">Category</span>
			<select id="filter-type">
				<option value="4">All Categories</option>
				<option value="0">Conditional</option>
				<option value="1">Control Flow</option>
				<option value="2">Recursion</option>
				<option value="3">Other</option>
			</select>
		</div>
		<div class="selector">
			<span id="filter-difficulty-label">Difficulty</span>
			<select id="filter-difficulty">
				<option value="3" selected>Any Difficulty</option>
				<option value="0">Easy</option>
				<option value="1">Medium</option>
				<option value="2">Difficult</option>
			</select>
		</div>
		<div class="clear"></div>
	</div>
	<ul id="question-list">
		<?php
			foreach ($questions as $question) {
				$q_ids[] = $question['id'];
				echo '
					<li id="q-' . $question['id'] . '">
						<p class="' . $question['difficulty_str'] . '">' .
						generate_question_description($question) . '</p>
					</li>
				';
			}
		?>
		</li>
	</ul>
</div>
<div id="test-wrapper">
	<h1><?=$test['name']?></h1>
	<table border="1" id="questions">
		<thead>
			<tr>
				<td>Question</td>
				<td>Weight</td>
				<td>Action</td>
			</tr>
		</thead>
		<tbody>
		<?php
			$seen = [];
			foreach($test_questions as $id => $question) {
				$seen[] = $id;
				echo '<tr>';
				echo '<td>' . $question['function_name'] . '</td>';
				echo '<td><input type="text" value="' . $question['weight'] . '" /></td>';
				echo '<td><button id="delete' . $id . '" class="red">Delete</button></td>';
				echo '</tr>';
			}
		?>
		</tbody>
	</table>
</div>
<script>
	let test_id = <?=$test_id?>;
	let questions = <?=json_encode($seen)?>;
	let question_bank = <?=json_encode($q_ids)?>;
	<?php echo file_get_contents('js/sidebar.js') ?>
</script>
<?php
	$js = "test";
	require_once('footer.php');
?>
