<?php

require_once('header.php');

if ($_SESSION['role'] != 1) {
	redirect("student.php");
}

$tests = http(MIDDLE_END, "get_tests_for_user", [
	"user_id" => $_SESSION['user_id']
]);

?>
<form id="tests-wrapper">
	<h1>Create New Test</h1>
	<input id="name" type="text" placeholder="Test Name" />
	<div class="step">
		<div id="error"></div>
		<button id="submit" type="button" class="green">Submit</button>
	</div>
</form>
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
<?php
	$js = "instructor";
	require_once('footer.php');
?>
