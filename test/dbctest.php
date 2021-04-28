<?php
include '../class/class-dbc.php';
$dbc = new dbc();
try {
	//$result = $dbc->runQuery("addTribeMembership", 'iii', 1, 2, 0);
	$result = $dbc->runQuery("getAllTribalMemberships", 'i', 1);
	echo $result;
} catch (Exception $e) {
	echo "Graceful failure";
}

?>
