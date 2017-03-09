<?php
	require_once('../functions.php');
	require_once('header.php');
?>

<div id="question-wrapper">
	<h1>Create Question</h1>
	<div class="step">
		<div class="num">1</div>
		Question type
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
		Function name<input id="function-name" type="text">Function type
		<select id="func-type">
			<option value="0" selected>Int</option>
			<option value="1">Float</option>
			<option value="2">Double</option>
			<option value="3">String</option>
			<option value="4">Bool</option>
		</select>
		<p style="margin-top:40px">Question description</p>
		<textarea id="description"></textarea>
	</div>
	<div class="step">
		<div class="num">3</div>
		<p>Function arguments (<span id="argumentCounter">0</span>)</p>
		<table border="1" width="100%">
			<thead>
				<th>Argument Name</th>
				<th>Argument Type</th>
				<th>Delete</th>
			</thead>
			<tbody id="arguments"></tbody>
		</table>
		<hr />
		<button id="add-arg" type="button" class="blue">Add Argument</button>
	</div>
	<div class="step">
		<div class="num">4</div>
		<p>Unit Tests</p>
		<input id="unit-input" type="text" placeholder="Inputs (ex: int 1,int 2)">
		<input id="unit-output" type="text" placeholder="Output (ex: 3)">
	</div>
	<div class="step">
		<div class="num">5</div>
		<div id="error"></div>
		<button id="submit" type="button" class="green">Submit</button>
	</div>
</div>

<?php
	$js = "question";
	require_once('footer.php');
?>
