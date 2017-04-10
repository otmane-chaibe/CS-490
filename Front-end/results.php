<?php

# Maurice Achtenhagen

require_once('../functions.php');
require_once('header.php');

$results = http(MIDDLE_END, "results", [
	"user_id" => $_SESSION['user_id']
]);

if ($results === false) {
	error("cURL request failed");
}

?>
<table cellpadding="8">
	<thead>
		<th>Test Name</th>
		<th>Grade</th>
		<th>Released</th>
	</thead>
	<tbody>
		<?php
		foreach ($results as $result) {
			$str = $result['test_name'];
			if ($result['released'] == 1) {
				$str = '<a href="view_results.php?id=' . $result['test_id'] . '">' . $result['test_name'] . '</a>';
			}
			echo '<tr>';
			echo '<td>' . $str . '</td>';
			echo '<td><meter min="0" max="100" value="' . $result['score'] . '">' . $result['score'] . '%</meter></td>';
			echo '<td style="text-align: center">&' . ($result['released'] ? 'check' : 'cross') . ';';
			echo '</tr>';
		}
		?>
	</tbody>
</table>
