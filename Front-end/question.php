<?php require_once('header.php') ?>

<div id="question-wrapper">
	<h1>Create Question</h1>
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
	<br /><br />
	Write a function named<input id="function-name" type="text">of type
	<select id="func-type">
		<option value="0" selected>Int</option>
		<option value="1">Float</option>
		<option value="2">Double</option>
		<option value="3">String</option>
		<option value="4">Bool</option>
	</select>using
	<input id="arg-count" type="text">args of type
	<select id="arg-type">
		<option value="0" selected>Int</option>
		<option value="1">Float</option>
		<option value="2">Double</option>
		<option value="3">String</option>
		<option value="4">Bool</option>
	</select>
	<textarea id="solution"></textarea>
	<button id="submit" type="button" class="green">Submit</button>
</div>
<div id="sidebar"></div>

<?php require_once('footer.php') ?>