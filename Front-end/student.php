<?php

/*
	student.php
	-----------------------------------------------
	This file is shown to users with role 0.
	-----------------------------------------------
*/

require_once('../functions.php');
require_once('header.php');

# cURL Request -> Middle-end -> student_tests.php
# TODO: replace mma93 with sma76 in url
$curl = curl_init();
curl_setopt_array($curl, [
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL            => 'https://web.njit.edu/~mma93/Middle-end/student_tests.php',
	CURLOPT_POST           => 1,
	CURLOPT_POSTFIELDS     => []
]);
$resp = curl_exec($curl);
curl_close($curl);
if ($resp === false) {
	error("cURL request failed");
}
$tests = json_decode($resp, true);

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
