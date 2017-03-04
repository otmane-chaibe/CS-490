<?php require_once('header.php') ?>

<div id="question-wrapper">
	<h1>Create Question</h1>
	<div class="step">
		<div class="num">1</div>
		Question type
		<select id="question-type">
			<option value="0" selected>Conditional</option>
			<option value="1">Control Flow</option>
			<option value="2">Recursion</option>
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
		Function Name<input id="function-name" type="text">Function Type
		<select id="func-type">
			<option value="0" selected>Int</option>
			<option value="1">Float</option>
			<option value="2">Double</option>
			<option value="3">String</option>
			<option value="4">Bool</option>
		</select>
	</div>
	<div class="step">
		<div class="num">3</div>
		<p>Function arguments (0)</p>
		Argument Name<input id="arg-name" type="text">Argument Type
		<select id="arg-type">
			<option value="0" selected>Int</option>
			<option value="1">Float</option>
			<option value="2">Double</option>
			<option value="3">String</option>
			<option value="4">Bool</option>
		</select>
		<button id="add-arg" type="button" class="blue">Add Argument</button>
	</div>
	<div class="step">
		<div class="num">4</div>
		<p>Question Solution</p>
		<textarea id="solution"></textarea>
	</div>
	<div class="step">
		<div class="num">5</div>
		<button id="submit" type="button" class="green">Submit</button>
	</div>
</div>
<div id="sidebar"></div>

<?php require_once('footer.php') ?>
