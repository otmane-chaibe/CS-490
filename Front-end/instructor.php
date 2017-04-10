<?php

# Maurice Achtenhagen

require_once('header.php');

if ($_SESSION['role'] != 1) {
	redirect("student.php");
}

$tests = http(MIDDLE_END, "get_tests_for_user", [
	"user_id" => $_SESSION['user_id']
]);

if ($tests === false) {
	error("cURL request failed");
}

$pending_tests = http(MIDDLE_END, "get_pending_tests", [
	'user_id' => (int) $_SESSION['user_id']
]);

if ($pending_tests === false) {
	error("cURL request failed");
}

/*
  {
    "id": 1,
    "user_id": 1,
    "test_id": 1,
    "score": 100
  }
*/

?>
<div id="tests-wrapper">
	<h1>Create New Test</h1>
	<div class="header">
		<input id="name" type="text" placeholder="Test Name" />
		<button id="submit" type="button" class="green">Submit</button>
		<div class="clear"></div>
	</div>
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
</div>
<div id="pending-wrapper">
	<h1>Pending Tests</h1>
	<table>
		<thead>
			<tr>
				<td>Test</td>
				<td>Score</td>
				<td>Released</td>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach($pending_tests as $test) {
				echo '
					<tr>
						<td><a href="view_results.php?id=' . $test['id'] . '">' . $test['name'] . '</a></td>
						<td>' . $test['score'] . '</td>
						<td><input type="checkbox"</td>
					</tr>
				';
			}
		?>
		</tbody>
	</table>
</div>
<?php
	$js = "instructor";
	require_once('footer.php');
?>
