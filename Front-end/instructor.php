<?php

require_once('../functions.php');
require_once('header.php');

$_SESSION['user_id'] = 2;
$_SESSION['role'] = 1;
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


<?php require_once('footer.php') ?>