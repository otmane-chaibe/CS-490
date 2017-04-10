<?php

# Maurice Achtenhagen

require_once('header.php');

if ($_SESSION['role'] != 0) {
	redirect("instructor.php");
}

$user_id = (int) $_SESSION['user_id'];

$tests = http(MIDDLE_END, "student_tests", [
	'user_id' => $user_id
]);

if ($tests === false) {
	error("cURL request failed");
}

?>
<div id="students-wrapper">
<h1>Available Tests</h1>
	<ul class="list" id="tests">
		<?php
			if (empty($tests)) {
				echo "<p>There are currently no tests available.</p>";
			}

			foreach($tests as $test) {
				echo '
					<li class="item">
						<a href="take_test.php?id=' . $test['id'] . '">' . $test['name'] . '</a>
					</li>
				';
			}
		?>
	</ul>
</div>

<?php require_once('footer.php') ?>
