<?php

require_once('../functions.php');
require_once('header.php');

$tests = Test::getAllTests();

?>
<div id="students-wrapper">
<h1>Available Tests</h1>
	<ul class="list" id="tests">
		<?php
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
