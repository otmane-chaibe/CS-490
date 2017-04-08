<?php

# Maurice Achtenhagen

require_once('header.php');

$questions = http(MIDDLE_END, "get_all_test_questions");

if ($questions === false) {
	error("cURL request failed");
}

function generateQuestionDescription($q) {
	$question = '
		Write a function of type <strong>' . type_to_string($q['function_type']) . '</strong>
		 named <strong>' . $q['function_name'] . '</strong>
		that accepts ' . count($q['arguments']) . ' ' . (count($q['arguments']) === 1 ? 'argument' : 'arguments') . ' of type (' . get_args($q['arguments']) . '), ' . $q['description'];
	return $question;
}

function get_args($args) {
	$arg_arr = [];
	foreach($args as $arg) {
		$arg_arr[] = '<strong>' . type_to_string($arg['type']) . '</strong>';
	}
	return implode(', ', $arg_arr);
}

function get_difficulty($diff) {
	switch ($diff) {
		case 0:
			return "easy";
		case 1:
			return "medium";
		case 2:
			return "difficult";
		default:
			return "easy";
	}
}

?>
<div id="sidebar">
	<div id="filter">
		<input id="filter-search" type="text" placeholder="Search Questions" />
		<button id="filter-search-btn" type="button" class="button blue">Search</button>
		<div class="selector">
			<span>Type</span>
			<select id="filter-type">
				<option value="0" selected>Conditional</option>
				<option value="1">Control Flow</option>
				<option value="2">Recursion</option>
				<option value="3">Other</option>
			</select>
		</div>
		<div class="selector">
			<span>Difficulty</span>
			<select id="filter-difficulty">
				<option value="0" selected>Easy</option>
				<option value="1">Medium</option>
				<option value="2">Difficult</option>
			</select>
		</div>
		<div class="clear"></div>
	</div>
	<ul id="question-list">
		<?php
			foreach ($questions as $question) {
				echo '
					<li>
						<p class="' . get_difficulty($question['difficulty']) . '">' . generateQuestionDescription($question) . '</p>
					</li>
				';
			}
		?>
		</li>
	</ul>
</div>
<div id="question-wrapper">
	<h1>Create Question</h1>
	<div class="step">
		<div class="num">1</div>
		Question Type
		<select id="question-type">
			<option value="0" selected>Conditional</option>
			<option value="1">Control Flow</option>
			<option value="2">Recursion</option>
			<option value="3">Other</option>
		</select>
		Difficulty
		<select id="question-difficulty">
			<option value="0" selected>Easy</option>
			<option value="1">Medium</option>
			<option value="2">Difficult</option>
		</select>
	</div>
	<div class="step">
		<div class="num">2</div>
		Function Name<input id="function-name" type="text" placeholder="e.g., sum" required>Function Type
		<select id="func-type">
			<option value="0" selected>Int</option>
			<option value="1">Float</option>
			<option value="2">Double</option>
			<option value="3">String</option>
			<option value="4">Bool</option>
		</select>
		<p style="margin-top:40px">Question Description</p>
		<textarea id="description" placeholder="e.g., which returns the sum of a and b." required></textarea>
	</div>
	<div class="step">
		<div class="num">3</div>
		<p>Function Arguments</p>
		<table>
			<tbody id="arguments"></tbody>
		</table>
		<button id="add-arg" type="button" class="blue">Add Argument</button>
	</div>
	<div class="step">
		<div class="num">4</div>
		<p>Unit Tests</p>
		<table>
			<tbody id="unit-tests"></tbody>
		</table>
		<button id="add-unit-test" type="button" class="blue">Add Unit Test</button>
	</div>
	<div class="step">
		<div class="num">5</div>
		<div id="error"></div>
		<p>Submit Question</p>
		<button id="submit" type="button" class="green">Let's Go!</button>
	</div>
</div>
<?php
	$js = "question";
	require_once('footer.php');
?>
