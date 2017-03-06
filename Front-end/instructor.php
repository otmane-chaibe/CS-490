<?php

require_once('../functions.php');
require_once('header.php');

$tests = Test::getTestsForUser($_SESSION['user_id']);

?>

<ul class="list" id="tests">
	<?php
		foreach($tests as $test) {			
			echo '
				<li class="item">
					<a href="test.php?id=' . $test['id'] . '">' . $test['name'] . '</a>
				</li>
			';
		}
	?>
</ul>

<br/><br/>

<form id="question-wrapper">
	<h1>Create New Test</h1>

	<div class="step">
		<div class="num">1</div>
		Name <input id="name" type="text" style="width: 400px" />
	</div>
	<div class="step">
		<div class="num">2</div>

		<div id="error"></div>

		<button id="submit" type="button" class="green">Submit</button>
	</div>
</form>

<?php
	$js = "instructor";
	require_once('footer.php');
?>
