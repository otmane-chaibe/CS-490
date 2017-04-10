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
<div id="test-results-wrapper">
	<h1>Test Results</h1>
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
				$status = '<div class="status pass">Yes</div>';
				if ($result['released']) {
					$status = '<div class="status">No</div>';
				}
				echo '<tr>';
				echo '<td>' . $str . '</td>';
				echo '<td>' . ($result['released'] == 1 ? $result['score'] : "--") .'</td>';
				echo '<td style="text-align: center">' . $status . '</td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>
</div>
