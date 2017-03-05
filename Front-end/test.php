<?php

require_once('../functions.php');
require_once('header.php');

$_SESSION['user_id'] = 2;
$_SESSION['role'] = 1;
$test_id = $_GET['id'];
if (empty($test_id)) {
	redirect("instructor.php");
}

?>

<ul class="list" id="questions">
	<?php
		foreach(Question::getQuestionsForTest($test_id) as $question) {
			echo '
				<li class="item">' . $question['function_name'] . '</li>
			';
		}
	?>
</ul>

<?php require_once('footer.php') ?>