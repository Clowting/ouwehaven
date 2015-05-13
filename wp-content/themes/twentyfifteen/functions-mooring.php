<?php
require_once('../../../wp-load.php');


global $wpdb;
function addMooringTable() {
	if ($_POST ['ID']) {
		$id = $_POST ['ID'];
		$result = $wpdb->get_results ( "SELECT * FROM oh_moorings WHERE Haven_ID == $id" );
		var_dump ( $result );
		if ($result != null) {
			?>
	<thead>
		<th>Nummer</th>
		<th>Prijs per meter?</th>
	</thead>
	<tbody>
				<?php
				foreach ( $result as $res ) {
					echo "<tr>";
					echo "<td>" . $res ['Nummer'] . "<td>";
					echo "<td></td>";
					echo "<tr>";
				}
			}
		}
	}
	
?>