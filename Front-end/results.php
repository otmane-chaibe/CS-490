<?php

require_once('../functions.php');
require_once('header.php');

$results = Test::getResultsForUser($_SESSION['user_id']);

?>

<table cellpadding="8">
	<thead>
		<th>Test Name</th>
		<th>Grade</th>
		<th>Completed?</th>
	</thead>
	<tbody>

<?php
foreach ($results as $result) {
	echo '<tr>';

	echo '<td>' . $result['test_name'] . '</td>';
	echo '<td><meter min="0" max="100" value="' . $result['test_grade'] . '">' . $result['test_grade'] . '%</meter></td>';

	echo '<td style="text-align: center">&' . ($result['completed'] ? 'check' : 'cross') . ';';

	echo '</tr>';
}
?>

	</tbody>
</table>
