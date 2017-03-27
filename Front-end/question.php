<?php require_once('header.php') ?>

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
		Function Name<input id="function-name" type="text" placeholder="e.g., sum">Function Type
		<select id="func-type">
			<option value="0" selected>Int</option>
			<option value="1">Float</option>
			<option value="2">Double</option>
			<option value="3">String</option>
			<option value="4">Bool</option>
		</select>
		<p style="margin-top:40px">Question Description</p>
		<textarea id="description" placeholder="e.g., which returns the sum of a and b."></textarea>
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
